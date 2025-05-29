<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Address')" :subheading="__('Update your address')">
        <form wire:submit="updateAddressInformation" class="my-6 w-full space-y-6">
            <flux:input wire:model="region" :label="__('Region')" type="text" autofocus autocomplete="region" />
            <flux:input wire:model="province" :label="__('Province')" type="text" autofocus autocomplete="province" />
            <flux:input wire:model="city" :label="__('City')" type="text" autofocus autocomplete="city" />
            <flux:input wire:model="brgy" :label="__('Barangay')" type="text" autofocus autocomplete="brgy" />
            <flux:input wire:model="postal_code" :label="__('Postal Code')" type="text" autofocus
                autocomplete="postal_code" />
            <flux:input wire:model="street_address" :label="__('Street, Name, Building, House No.')" type="text"
                autofocus autocomplete="street_address" />

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                </div>

                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>
    </x-settings.layout>
</section>
