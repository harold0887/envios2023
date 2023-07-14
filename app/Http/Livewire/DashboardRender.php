<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class DashboardRender extends Component
{
    public function render()
    {
        $products=Product::all();

        return view('livewire.dashboard-render', compact('products'));
    }
}
