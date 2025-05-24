<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        Password::sendResetLink($this->only('email'));

        session()->flash('status', __('A reset link will be sent if the account exists.'));
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Forgot password')" :description="__('Enter your email to receive a password reset link')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink" class="flex flex-col gap-6">
        <!-- Email Address -->
        <flux:input class:input="dark:bg-zinc-950! dark:text-white/90!" wire:model="email" :label="__('Email Address')"
            type="email" required autofocus placeholder="email@example.com" viewable />

        <flux:button type="submit" class="w-full dark:bg-zinc-800! dark:hover:bg-zinc-700! dark:text-white/90!">
            {{ __('Email password reset link') }}
        </flux:button>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-white/90">
        {{ __('Or, return to') }}
        <flux:link :href="route('login')" wire:navigate>{{ __('login') }}</flux:link>
    </div>
</div>