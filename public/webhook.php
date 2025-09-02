<?php
/**
 * GitHub Webhook Handler untuk Auto-Deployment
 * File ini akan menerima webhook dari GitHub dan menjalankan deployment otomatis
 */

// Konfigurasi
$secret = 'KantorCamatWaesama2024!SecureKey'; // Secret key untuk GitHub webhook
$branch = 'main'; // Branch yang akan di-deploy
$projectPath = dirname(__DIR__); // Path ke root project

// Log file untuk debugging
$logFile = $projectPath . '/storage/logs/webhook.log';

// Fungsi untuk logging
function writeLog($message) {
    global $logFile;
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[$timestamp] $message" . PHP_EOL, FILE_APPEND | LOCK_EX);
}

// Fungsi untuk menjalankan command
function runCommand($command) {
    global $projectPath;
    $output = [];
    $returnVar = 0;
    
    // Pindah ke directory project
    chdir($projectPath);
    
    // Jalankan command
    exec($command . ' 2>&1', $output, $returnVar);
    
    $result = [
        'command' => $command,
        'output' => implode("\n", $output),
        'success' => $returnVar === 0
    ];
    
    writeLog("Command: $command");
    writeLog("Output: " . $result['output']);
    writeLog("Success: " . ($result['success'] ? 'Yes' : 'No'));
    
    return $result;
}

// Fungsi untuk verifikasi signature GitHub
function verifyGitHubSignature($payload, $signature, $secret) {
    $expectedSignature = 'sha256=' . hash_hmac('sha256', $payload, $secret);
    return hash_equals($expectedSignature, $signature);
}

// Set header response
header('Content-Type: application/json');

try {
    // Ambil payload dari GitHub
    $payload = file_get_contents('php://input');
    $signature = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';
    
    writeLog('Webhook received');
    writeLog('Signature: ' . $signature);
    
    // Verifikasi signature (opsional, untuk keamanan)
    if (!empty($secret) && !verifyGitHubSignature($payload, $signature, $secret)) {
        writeLog('Invalid signature');
        http_response_code(401);
        echo json_encode(['error' => 'Invalid signature']);
        exit;
    }
    
    // Parse payload JSON
    $data = json_decode($payload, true);
    
    if (!$data) {
        writeLog('Invalid JSON payload');
        http_response_code(400);
        echo json_encode(['error' => 'Invalid JSON payload']);
        exit;
    }
    
    // Cek apakah ini push ke branch yang benar
    $pushedBranch = str_replace('refs/heads/', '', $data['ref'] ?? '');
    
    if ($pushedBranch !== $branch) {
        writeLog("Push to different branch: $pushedBranch (expected: $branch)");
        echo json_encode(['message' => "Ignored push to branch: $pushedBranch"]);
        exit;
    }
    
    writeLog("Starting deployment for branch: $branch");
    
    // Jalankan deployment commands
    $commands = [
        'git fetch origin',
        'git reset --hard origin/' . $branch,
        'git pull origin ' . $branch,
        'composer install --no-dev --optimize-autoloader',
        'npm install',
        'npm run build',
        'php artisan config:cache',
        'php artisan route:cache',
        'php artisan view:cache',
        'php artisan optimize'
    ];
    
    $results = [];
    $allSuccess = true;
    
    foreach ($commands as $command) {
        $result = runCommand($command);
        $results[] = $result;
        
        if (!$result['success']) {
            $allSuccess = false;
            writeLog("Command failed: $command");
            break;
        }
    }
    
    if ($allSuccess) {
        writeLog('Deployment completed successfully');
        echo json_encode([
            'status' => 'success',
            'message' => 'Deployment completed successfully',
            'branch' => $branch,
            'commit' => $data['head_commit']['id'] ?? 'unknown'
        ]);
    } else {
        writeLog('Deployment failed');
        http_response_code(500);
        echo json_encode([
            'status' => 'error',
            'message' => 'Deployment failed',
            'results' => $results
        ]);
    }
    
} catch (Exception $e) {
    writeLog('Exception: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Internal server error: ' . $e->getMessage()
    ]);
}
?>