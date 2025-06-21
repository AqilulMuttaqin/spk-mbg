@extends('auth.app')

@section('content')
    <div class="mb-4 text-muted">
        {{ __('Lupa kata sandi? Tidak masalah. Cukup beri tahu kami alamat email Anda dan kami akan mengirimkan tautan untuk menyetel ulang kata sandi yang akan memungkinkan Anda memilih kata sandi baru.') }}
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success mb-3">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <label class="form-label" for="email">Email</label>
            <input class="form-control form-control-lg" type="email" name="email" id="email"
                   value="{{ old('email') }}" required autofocus placeholder="Enter your email" />
            @error('email')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-grid gap-2 mt-3">
            <button type="submit" class="btn btn-lg btn-primary">
                Email Password Reset Link
            </button>
        </div>
    </form>
    <div class="d-flex align-items-center justify-content-end mt-2">
        <a href="{{ route('login') }}">Login ?</a>
    </div>
@endsection

{{-- <x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
