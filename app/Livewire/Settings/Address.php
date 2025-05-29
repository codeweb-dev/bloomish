<?php

namespace App\Livewire\Settings;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class Address extends Component
{
    public $region;
    public $province;
    public $city;
    public $brgy;
    public $postal_code;
    public $street_address;

    public function mount()
    {
        $user = Auth::user();

        $this->region = $user->region;
        $this->province = $user->province;
        $this->city = $user->city;
        $this->brgy = $user->brgy;
        $this->postal_code = $user->postal_code;
        $this->street_address = $user->street_address;
    }

    public function updateAddressInformation()
    {
        $this->validate([
            'region' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'brgy' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'street_address' => 'nullable|string|max:255',
        ]);

        Auth::user()->update([
            'region' => $this->region,
            'province' => $this->province,
            'city' => $this->city,
            'brgy' => $this->brgy,
            'postal_code' => $this->postal_code,
            'street_address' => $this->street_address,
        ]);

        $this->dispatch('profile-updated');
        Toaster::success('Address information updated successfully. Go back to Cart to continue shopping.');
    }

    public function render()
    {
        $layout = auth()->user()?->hasRole('admin')
            ? 'components.layouts.admin'
            : 'components.layouts.app';

        return view('livewire.settings.address')->layout($layout);
    }
}
