<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Notification;
use App\Helpers\NotificationHelper;

class NotificationHelperTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create roles
        $adminRole = Role::create(['name' => 'admin', 'display_name' => 'Administrator']);
        $wargaRole = Role::create(['name' => 'warga', 'display_name' => 'Warga']);
        
        // Create users
        $this->admin = User::factory()->create([
            'role_id' => $adminRole->id,
            'email' => 'admin@test.com',
            'name' => 'Admin Test'
        ]);
        
        $this->warga = User::factory()->create([
            'role_id' => $wargaRole->id,
            'email' => 'warga@test.com',
            'name' => 'Warga Test'
        ]);
    }

    public function test_notify_all_creates_notifications_for_all_users()
    {
        $this->actingAs($this->admin);
        
        // Check initial state
        $userCount = User::count();
        $this->assertEquals(2, $userCount, 'Should have 2 users');
        
        $initialNotificationCount = Notification::count();
        $this->assertEquals(0, $initialNotificationCount, 'Should start with 0 notifications');
        
        // Call notifyAll
        $result = NotificationHelper::notifyAll(
            'Test Notification',
            'This is a test notification message',
            'medium',
            'http://test.com',
            $this->admin->id
        );
        
        // Check result
        $this->assertEquals(2, $result, 'Should return count of 2 notifications created');
        
        // Check database
        $finalNotificationCount = Notification::count();
        $this->assertEquals(2, $finalNotificationCount, 'Should have 2 notifications in database');
        
        // Check notification content
        $notifications = Notification::all();
        foreach ($notifications as $notification) {
            $this->assertEquals('Test Notification', $notification->title);
            $this->assertEquals('This is a test notification message', $notification->message);
            $this->assertEquals('medium', $notification->priority);
            $this->assertEquals('http://test.com', $notification->action_url);
            $this->assertEquals($this->admin->id, $notification->sender_id);
        }
    }
}