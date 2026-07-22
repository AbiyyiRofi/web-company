@php
    $siteLogo = \App\Models\SiteSetting::singleton();
@endphp
<x-guest-layout>
    <div class="flex flex-col items-center text-center mb-5">
        <!-- Brand Logo -->
        <div class="mb-3">
            @if($siteLogo->logo)
                <img src="{{ asset('storage/'.$siteLogo->logo) }}" class="h-10 w-auto object-contain">
            @else
                <div class="w-12 h-12 rounded-2xl bg-primary-50 flex items-center justify-center border border-primary-100 shadow-sm">
                    <span class="text-2xl">💧</span>
                </div>
            @endif
        </div>
        
        <h1 class="text-xl font-bold tracking-tight text-slate-800 font-display">Portal Internal</h1>
        <p class="text-xs text-slate-400 mt-1 max-w-[280px]">PERUMDAM Tirta Darma Ayu</p>
    </div>

    <x-auth-session-status class="mb-4 text-xs" :status="session('status')" />

    <form method="POST" action="{{ route('admin.login') }}" class="space-y-3.5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-slate-500 font-semibold mb-1 text-[11px] uppercase tracking-wider" />
            <x-text-input id="email" class="block w-full px-4 py-2 border border-slate-200 focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 rounded-xl transition duration-150 text-slate-800 placeholder-slate-300 text-sm" type="email" name="email" :value="old('email')" placeholder="nama@pdamindramayu.co.id" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-slate-500 font-semibold mb-1 text-[11px] uppercase tracking-wider" />
            <x-text-input id="password" class="block w-full px-4 py-2 border border-slate-200 focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 rounded-xl transition duration-150 text-slate-800 placeholder-slate-300 text-sm" type="password" name="password" placeholder="••••••••" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between text-xs pt-0.5">
            <label for="remember" class="inline-flex items-center cursor-pointer select-none">
                <input id="remember" type="checkbox" class="rounded border-slate-200 text-primary-600 shadow-sm focus:ring-primary-500/30 w-3.5 h-3.5 cursor-pointer" name="remember">
                <span class="ms-2 text-slate-400 hover:text-slate-600 transition">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('admin.password.request'))
                <a class="text-primary-600 hover:text-primary-700 font-semibold transition" href="{{ route('admin.password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <x-primary-button class="w-full justify-center py-2.5 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-semibold rounded-xl shadow-md hover:shadow-lg focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-all duration-150 !normal-case !text-sm !tracking-normal">
            {{ __('Log in') }}
        </x-primary-button>
    </form>
</x-guest-layout>