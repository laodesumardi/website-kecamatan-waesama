<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Role;
use App\Models\Surat;
use App\Models\Pengaduan;
use App\Models\Antrian;
use App\Models\Berita;
use App\Models\Notification;
use App\Helpers\NotificationHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NotificationSystemTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $admin;
    protected $pegawai;
    protected $warga;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create roles
        $adminRole = Role::create(['name' => 'admin', 'display_name' => 'Administrator']);
        $pegawaiRole = Role::create(['name' => 'pegawai', 'display_name' => 'Pegawai']);
        $wargaRole = Role::create(['name' => 'warga', 'display_name' => 'Warga']);
        
        // Create users
        $this->admin = User::factory()->create([
            'role_id' => $adminRole->id,
            'email' => 'admin@test.com'
        ]);
        
        $this->pegawai = User::factory()->create([
            'role_id' => $pegawaiRole->id,
            'email' => 'pegawai@test.com'
        ]);
        
        $this->warga = User::factory()->create([
            'role_id' => $wargaRole->id,
            'email' => 'warga@test.com'
        ]);
    }

    /** @test */
    public function it_can_send_notification_to_specific_user()
    {
        $notification = NotificationHelper::sendToUser(
            $this->warga->id,
            'Test Notification',
            'This is a test message',
            'medium',
            'http://test.com',
            $this->admin->id
        );

        $this->assertDatabaseHas('notifications', [
            'user_id' => $this->warga->id,
            'sender_id' => $this->admin->id,
            'title' => 'Test Notification',
            'message' => 'This is a test message',
            'priority' => 'medium',
            'action_url' => 'http://test.com'
        ]);
    }

    /** @test */
    public function it_can_send_notification_to_role()
    {
        $count = NotificationHelper::sendToRole(
            'admin',
            'Role Notification',
            'This is a role-based notification',
            'high'
        );

        $this->assertEquals(1, $count);
        $this->assertDatabaseHas('notifications', [
            'user_id' => $this->admin->id,
            'title' => 'Role Notification',
            'message' => 'This is a role-based notification',
            'priority' => 'high'
        ]);
    }

    /** @test */
    public function it_can_notify_all_users()
    {
        $count = NotificationHelper::notifyAll(
            'Broadcast Notification',
            'This is a broadcast message',
            'low'
        );

        $this->assertEquals(3, $count); // admin, pegawai, warga
        
        $this->assertDatabaseHas('notifications', [
            'user_id' => $this->admin->id,
            'title' => 'Broadcast Notification'
        ]);
        
        $this->assertDatabaseHas('notifications', [
            'user_id' => $this->pegawai->id,
            'title' => 'Broadcast Notification'
        ]);
        
        $this->assertDatabaseHas('notifications', [
            'user_id' => $this->warga->id,
            'title' => 'Broadcast Notification'
        ]);
    }

    /** @test */
    public function it_can_notify_admins()
    {
        $count = NotificationHelper::notifyAdmins(
            'Admin Notification',
            'This is for admins only',
            'high'
        );

        $this->assertEquals(1, $count);
        $this->assertDatabaseHas('notifications', [
            'user_id' => $this->admin->id,
            'title' => 'Admin Notification'
        ]);
        
        $this->assertDatabaseMissing('notifications', [
            'user_id' => $this->warga->id,
            'title' => 'Admin Notification'
        ]);
    }

    /** @test */
    public function it_can_get_unread_count()
    {
        // Create some notifications
        NotificationHelper::sendToUser($this->warga->id, 'Test 1', 'Message 1');
        NotificationHelper::sendToUser($this->warga->id, 'Test 2', 'Message 2');
        
        $count = NotificationHelper::getUnreadCount($this->warga->id);
        $this->assertEquals(2, $count);
    }

    /** @test */
    public function it_can_mark_notification_as_read()
    {
        $notification = NotificationHelper::sendToUser(
            $this->warga->id,
            'Test Notification',
            'Test Message'
        );

        NotificationHelper::markAsRead($notification->id, $this->warga->id);
        
        $this->assertDatabaseHas('notifications', [
            'id' => $notification->id,
            'user_id' => $this->warga->id
        ]);
        
        $updatedNotification = Notification::find($notification->id);
        $this->assertNotNull($updatedNotification->read_at);
    }

    /** @test */
    public function it_can_mark_all_notifications_as_read()
    {
        // Create multiple notifications
        NotificationHelper::sendToUser($this->warga->id, 'Test 1', 'Message 1');
        NotificationHelper::sendToUser($this->warga->id, 'Test 2', 'Message 2');
        
        NotificationHelper::markAllAsRead($this->warga->id);
        
        $unreadCount = NotificationHelper::getUnreadCount($this->warga->id);
        $this->assertEquals(0, $unreadCount);
    }

    /** @test */
    public function it_can_get_recent_notifications()
    {
        // Create some notifications
        NotificationHelper::sendToUser($this->warga->id, 'Test 1', 'Message 1');
        NotificationHelper::sendToUser($this->warga->id, 'Test 2', 'Message 2');
        NotificationHelper::sendToUser($this->warga->id, 'Test 3', 'Message 3');
        
        $notifications = NotificationHelper::getRecentNotifications($this->warga->id, 2);
        
        $this->assertCount(2, $notifications);
        $this->assertEquals('Test 3', $notifications->first()->title); // Most recent first
    }
}
