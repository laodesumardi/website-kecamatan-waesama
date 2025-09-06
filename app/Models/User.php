<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'phone',
        'address',
        'nik',
        'birth_date',
        'gender',
        'is_active',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the role that owns the user.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the surat processed by the user.
     */
    public function suratProcessed(): HasMany
    {
        return $this->hasMany(Surat::class, 'diproses_oleh');
    }

    /**
     * Get the antrian served by the user.
     */
    public function antrianServed(): HasMany
    {
        return $this->hasMany(Antrian::class, 'dilayani_oleh');
    }

    /**
     * Get the berita authored by the user.
     */
    public function berita(): HasMany
    {
        return $this->hasMany(Berita::class, 'author_id');
    }

    /**
     * Get the pengaduan handled by the user.
     */
    public function pengaduanHandled(): HasMany
    {
        return $this->hasMany(Pengaduan::class, 'ditangani_oleh');
    }

    /**
     * Get the bookmarks for the user.
     */
    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }

    /**
     * Get the bookmarked berita for the user.
     */
    public function bookmarkedBerita()
    {
        return $this->belongsToMany(Berita::class, 'bookmarks')->withTimestamps();
    }
}
