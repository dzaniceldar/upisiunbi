<x-jet-form-section submit="updatePassword">
    <x-slot name="title">
        <span class="text-white font-semibold">{{ __('Update Password') }}</span>
    </x-slot>

    <x-slot name="description">
        <span class="text-gray-300">{{ __('Ensure your account is using a long, random password to stay secure.') }}</span>
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="current_password" class="text-gray-300" value="{{ __('Current Password') }}" />
            <x-jet-input id="current_password" type="password" class="neo-input" wire:model.defer="state.current_password" autocomplete="current-password" />
            <x-jet-input-error for="current_password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="password" class="text-gray-300" value="{{ __('New Password') }}" />
            <x-jet-input id="password" type="password" class="neo-input" wire:model.defer="state.password" autocomplete="new-password" />
            <x-jet-input-error for="password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="password_confirmation" class="text-gray-300" value="{{ __('Confirm Password') }}" />
            <x-jet-input id="password_confirmation" type="password" class="neo-input" wire:model.defer="state.password_confirmation" autocomplete="new-password" />
            <x-jet-input-error for="password_confirmation" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3 text-green-300" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button class="!bg-blue-600 hover:!bg-blue-500 !rounded-xl">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
