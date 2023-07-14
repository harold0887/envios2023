<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\Product;
use Livewire\Component;

class DashboardRender extends Component
{
    public $fecha, $salesDay, $day;


    public function mount()
    {

        $this->fecha = now();
        $this->day = $this->fecha = $this->fecha->format('Y-m-d');
        $this->salesDay = Order::whereBetween('created_at', [$this->day . " 00:00:01", $this->day . " 23:59:59"])
            ->sum('amount');
    }



    public function render()
    {
        $products = Product::all();



        return view('livewire.dashboard-render', compact('products'));
    }
}
