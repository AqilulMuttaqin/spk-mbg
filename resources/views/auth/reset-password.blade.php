@extends('auth.app')

@section('content')
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="mb-3">
            <label class="form-label" for="email">Email</label>
            <input class="form-control form-control-lg" type="email" name="email" id="email"
                   value="{{ old('email', $request->email) }}" required autofocus placeholder="Enter your email" />
            @error('email')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label class="form-label" for="password">Password</label>
            <input class="form-control form-control-lg" type="password" name="password" id="password"
                   required placeholder="Enter your new password" />
            @error('password')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-3">
            <label class="form-label" for="password_confirmation">Confirm Password</label>
            <input class="form-control form-control-lg" type="password" name="password_confirmation"
                   id="password_confirmation" required placeholder="Confirm your new password" />
            @error('password_confirmation')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="d-grid gap-2 mt-3">
            <button type="submit" class="btn btn-lg btn-primary">Reset Password</button>
        </div>
    </form>
@endsection
{{-- <x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
