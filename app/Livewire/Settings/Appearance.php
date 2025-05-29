<?php

namespace App\Livewire\Settings;

use Livewire\Component;

class Appearance extends Component
{
    public function render()
    {
        $layout = auth()->user()?->hasRole('admin')
            ? 'components.layouts.admin'
            : 'components.layouts.app';

        return view('livewire.settings.appearance')->layout($layout);
    }
}
