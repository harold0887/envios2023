<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class DashboardRender extends Component
{
    use WithPagination;
    public  $salesDay, $salesMonth;
    public $search = '';
    public $sortDirection = 'desc';
    public $sortField = 'created_at';
    protected $paginationTheme = 'bootstrap';



    public function mount()
    {

        $fecha = now();
        $day = $fecha->format('Y-m-d');
        $month = $fecha->format('m');
        $this->salesDay = Order::whereBetween('created_at', [$day . " 00:00:01", $day . " 23:59:59"])
            ->sum('amount');



        $this->salesMonth = Order::whereMonth('created_at', $month)
            ->where(function ($query) {
                $query->whereYear('created_at', '=', date("Y"));
            })
            ->sum('amount');
    }



    public function render()
    {
        $products = Product::all();

        $orders = Order::where(function ($query) {
            $query->where('socialNetwork', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->orWhere('folio', 'like', '%' . $this->search . '%');
        })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(100);



        return view('livewire.dashboard-render', compact('products', 'orders'));
    }

    public function setSort($field)
    {

        $this->sortField = $field;

        if ($this->sortDirection == 'desc') {
            $this->sortDirection = 'asc';
        } else {
            $this->sortDirection = 'desc';
        }
    }
    public function clearSearch()
    {
        $this->reset(['search']);
    }
}
