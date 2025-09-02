<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Role;
use App\Models\Berita;
use App\Models\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NotificationIntegrationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $admin;
    protected $warga;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create roles
        $adminRole = Role::create(['name' => 'Admin', 'display_name' => 'Administrator']);
        $wargaRole = Role::create(['name' => 'Warga', 'display_name' => 'Warga']);
        
        // Create users
        $this->admin = User::factory()->create([
            'role_id' => $adminRole->id,
            'email' => 'admin@test.com',
            'name' => 'Admin Test',
            'is_active' => true
        ]);
        
        $this->warga = User::factory()->create([
            'role_id' => $wargaRole->id,
            'email' => 'warga@test.com',
            'name' => 'Warga Test',
            'is_active' => true
        ]);
    }

    public function test_berita_creation_sends_notification_to_all_users()
    {
        $this->actingAs($this->admin);
        
        // Create a published berita
        $response = $this->post(route('admin.berita.store'), [
            'judul' => 'Test Berita Notification',
            'konten' => 'This is test content for notification',
            'kategori' => 'Pengumuman',
            'penulis' => 'Admin Test',
            'status' => 'Published',
            'is_featured' => false,
            'author_id' => $this->admin->id
        ]);
        
        $response->assertRedirect(route('admin.berita.index'));
        
        // Check if berita was created
        $this->assertDatabaseHas('berita', [
            'judul' => 'Test Berita Notification',
            'status' => 'Published'
        ]);
        
        // Check if notifications were sent to all users
        $this->assertDatabaseHas('notifications', [
            'user_id' => $this->admin->id,
            'title' => 'Berita Baru Dipublikasikan',
            'type' => 'broadcast_notification'
        ]);
        
        $this->assertDatabaseHas('notifications', [
            'user_id' => $this->warga->id,
            'title' => 'Berita Baru Dipublikasikan',
            'type' => 'broadcast_notification'
        ]);
        
        // Should have 2 notifications (one for each user)
        $notificationCount = Notification::where('title', 'Berita Baru Dipublikasikan')->count();
        $this->assertEquals(2, $notificationCount);
    }

    public function test_berita_draft_does_not_send_notification()
    {
        $this->actingAs($this->admin);
        
        // Create a draft berita
        $response = $this->post(route('admin.berita.store'), [
            'judul' => 'Test Draft Berita',
            'konten' => 'This is draft content',
            'kategori' => 'Pengumuman',
            'penulis' => 'Admin Test',
            'status' => 'Draft',
            'is_featured' => false,
            'author_id' => $this->admin->id
        ]);
        
        $response->assertRedirect(route('admin.berita.index'));
        
        // Check if berita was created as draft
        $this->assertDatabaseHas('berita', [
            'judul' => 'Test Draft Berita',
            'status' => 'Draft'
        ]);
        
        // Check that no notifications were sent
        $this->assertDatabaseMissing('notifications', [
            'title' => 'Berita Baru Dipublikasikan'
        ]);
    }

    public function test_berita_update_to_published_sends_notification()
    {
        $this->actingAs($this->admin);
        
        // Create a draft berita first
        $berita = Berita::create([
            'judul' => 'Test Update Berita',
            'slug' => 'test-update-berita',
            'konten' => 'This is test content',
            'kategori' => 'Pengumuman',
            'penulis' => 'Admin Test',
            'status' => 'Draft',
            'author_id' => $this->admin->id
        ]);
        
        // Update berita to published
        $response = $this->put(route('admin.berita.update', $berita->id), [
            'judul' => 'Test Update Berita',
            'konten' => 'This is updated content',
            'kategori' => 'Pengumuman',
            'penulis' => 'Admin Test',
            'status' => 'Published',
            'is_featured' => false,
            'author_id' => $this->admin->id
        ]);
        
        $response->assertRedirect(route('admin.berita.index'));
        
        // Check if berita was updated to published
        $this->assertDatabaseHas('berita', [
            'id' => $berita->id,
            'status' => 'Published'
        ]);
        
        // Check if notifications were sent
        $this->assertDatabaseHas('notifications', [
            'title' => 'Berita Baru Dipublikasikan',
            'type' => 'broadcast_notification'
        ]);
        
        // Should have 2 notifications (one for each user)
        $notificationCount = Notification::where('title', 'Berita Baru Dipublikasikan')->count();
        $this->assertEquals(2, $notificationCount);
    }

    public function test_notification_contains_correct_berita_information()
    {
        $this->actingAs($this->admin);
        
        // Create a published berita
        $response = $this->post(route('admin.berita.store'), [
            'judul' => 'Berita Penting Terbaru',
            'konten' => 'This is important news content',
            'kategori' => 'Pengumuman',
            'penulis' => 'Admin Test',
            'status' => 'Published',
            'is_featured' => false,
            'author_id' => $this->admin->id
        ]);
        
        // Debug response
        if ($response->status() !== 302) {
            dump('Response status: ' . $response->status());
            dump('Response content: ' . $response->getContent());
        }
        
        // Get the created berita
        $berita = Berita::where('judul', 'Berita Penting Terbaru')->first();
        
        // Debug berita creation
        if (!$berita) {
            dump('Berita not found in database');
            $allBerita = \App\Models\Berita::all();
            dump('All berita in database: ' . $allBerita->count());
            foreach ($allBerita as $b) {
                dump("Berita: {$b->judul}, Status: {$b->status}");
            }
        } else {
            dump("Berita found: {$berita->judul}, Status: {$berita->status}");
        }
        
        // Debug: Check if users exist
        $userCount = \App\Models\User::count();
        dump("Users in database: {$userCount}");
        
        // Check notification content
        $notifications = Notification::all();
        dump("Notifications in database: {$notifications->count()}");
        $this->assertGreaterThan(0, $notifications->count(), 'No notifications found in database');
        
        $notification = Notification::where('title', 'Berita Baru Dipublikasikan')->first();
        
        if (!$notification) {
            // Debug: show all notifications
            foreach ($notifications as $notif) {
                dump("Title: {$notif->title}, Message: {$notif->message}");
            }
        }
        
        $this->assertNotNull($notification, 'Notification with title "Berita Baru Dipublikasikan" not found');
        $this->assertStringContainsString('Berita Penting Terbaru', $notification->message);
        $this->assertEquals('medium', $notification->priority);
        $this->assertStringContainsString($berita->slug, $notification->action_url);
    }
}
