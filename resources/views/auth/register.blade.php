<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ $user ? route('register.update', $user) : route('register') }}">
            @if ($user)
                @method('PUT')
            @endif
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Nome')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $user->name)" required autofocus />
            </div>

            @if (!$user)
                <!-- Email Address -->
                <div class="mt-4">
                    <x-label for="email" :value="__('E-mail')" />

                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $user->email)" required />
                </div>
            @endif

            <!-- Password -->
            @if ($user)
                <div class="mt-4">
                    <x-label for="password" :value="__('Senha')" />

                    <x-input id="password" class="block mt-1 w-full"
                                    type="password"
                                    name="password"
                                    required autocomplete="new-password" />
                </div>

                <div class="mt-4">
                    <x-label for="password_confirmation" :value="__('Confirmar Senha')" />

                    <x-input id="password_confirmation" class="block mt-1 w-full"
                                    type="password"
                                    name="password_confirmation" required />
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a href="{{ route('dashboard') }}">Voltar</a>
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Já tem cadastro?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Cadastrar') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
