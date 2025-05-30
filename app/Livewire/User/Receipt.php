<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

#[Title('Receipt')]
class Receipt extends Component
{
    public $orders;

    public function mount($orderIds)
    {
        if (!preg_match('/^\d+(,\d+)*$/', $orderIds)) {
            abort(403, 'Invalid order IDs.');
        }

        $ids = explode(',', $orderIds);

        $this->orders = Order::whereIn('id', $ids)
            ->where('user_id', Auth::id())
            ->get();

        if (count($this->orders) !== count($ids)) {
            abort(403, 'Some orders do not belong to you.');
        }
    }

    public function render()
    {
        return view('livewire.user.receipt', [
            'orders' => $this->orders,
        ]);
    }
}
