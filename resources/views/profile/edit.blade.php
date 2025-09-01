@extends('layouts.main')

@section('title', 'Profile')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-[#003f88] rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-2">Profile Settings</h2>
                <p class="text-blue-100">Kelola informasi profil dan keamanan akun Anda.</p>
            </div>
            <div class="hidden md:block">
                <i class="fas fa-user-cog text-6xl text-blue-200"></i>
            </div>
        </div>
    </div>

    <!-- Profile Information Card -->
    <div class="bg-white rounded-xl p-6 card-shadow">
        <div class="max-w-xl">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    <!-- Update Password Card -->
    <div class="bg-white rounded-xl p-6 card-shadow">
        <div class="max-w-xl">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    <!-- Delete Account Card -->
    <div class="bg-white rounded-xl p-6 card-shadow">
        <div class="max-w-xl">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection
