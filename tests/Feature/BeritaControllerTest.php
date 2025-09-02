<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Berita;
use App\Models\Notification;

class BeritaControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create roles
        $adminRole = Role::create(['name' => 'Admin', 'display_name' => 'Administrator']);
        
        // Create admin user
        $this->admin = User::factory()->create([
            'role_id' => $adminRole->id,
            'email' => 'admin@test.com',
            'name' => 'Admin Test',
            'is_active' => true
        ]);
    }

    public function test_berita_store_creates_berita_successfully()
    {
        $this->actingAs($this->admin);
        
        $response = $this->post(route('admin.berita.store'), [
            'judul' => 'Test Berita',
            'konten' => 'This is test content',
            'kategori' => 'Pengumuman',
            'penulis' => 'Admin Test',
            'status' => 'Published',
            'is_featured' => false,
            'author_id' => $this->admin->id
        ]);
        
        // Check response
        $response->assertRedirect(route('admin.berita.index'));
        
        // Check if berita was created
        $this->assertDatabaseHas('berita', [
            'judul' => 'Test Berita',
            'status' => 'Published',
            'author_id' => $this->admin->id
        ]);
        
        // Get the created berita
        $berita = Berita::where('judul', 'Test Berita')->first();
        $this->assertNotNull($berita);
        $this->assertEquals('Published', $berita->status);
    }
    
    public function test_berita_store_with_published_status_creates_notification()
    {
        $this->actingAs($this->admin);
        
        // Create another user to receive notification
        $wargaRole = Role::create(['name' => 'Warga', 'display_name' => 'Warga']);
        $warga = User::factory()->create([
            'role_id' => $wargaRole->id,
            'email' => 'warga@test.com',
            'name' => 'Warga Test',
            'is_active' => true
        ]);
        
        $response = $this->post(route('admin.berita.store'), [
            'judul' => 'Test Berita Notification',
            'konten' => 'This is test content for notification',
            'kategori' => 'Pengumuman',
            'penulis' => 'Admin Test',
            'status' => 'Published',
            'is_featured' => false,
            'author_id' => $this->admin->id
        ]);
        
        // Check response
        $response->assertRedirect(route('admin.berita.index'));
        
        // Check if berita was created
        $berita = Berita::where('judul', 'Test Berita Notification')->first();
        $this->assertNotNull($berita);
        
        // Test if berita can be viewed publicly
        $publicResponse = $this->get(route('public.berita.detail', $berita->slug));
        $publicResponse->assertStatus(200);
        
        // Check if notifications were created
        $notificationCount = Notification::count();
        $this->assertGreaterThan(0, $notificationCount, 'No notifications were created');
        
        // Check notification content
        $notification = Notification::where('title', 'Berita Baru Dipublikasikan')->first();
        $this->assertNotNull($notification, 'Notification with expected title not found');
    }
}