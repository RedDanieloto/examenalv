<x-guest-layout>
    <form method="POST" action="{{ route('activation.resend') }}">
        @csrf
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block w-full mt-1" type="email" name="email" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Resend Activation Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
