<?php

namespace App\Http\Livewire;

use App\Models\Membership;
use App\Models\Order;
use App\Models\Package;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class DashboardRender extends Component
{
    use WithPagination;
    public  $salesDay, $salesMonth, $salesYear;
    public  $productsDay, $packagesDay, $membershipsDay;
    public $maxProducts = 0, $maxPackages = 0, $maxMemberships = 0;
    public $products, $packages, $memberships;
    public $search = '';
    public $sortDirection = 'desc';
    public $sortField = 'created_at';
    protected $paginationTheme = 'bootstrap';



    public function mount()
    {

        $fecha = now();
        $day = $fecha->format('Y-m-d');
        $month = $fecha->format('m');
        $this->products = Product::all();
        $this->packages = Package::all();
        $this->memberships = Membership::all();
        $this->salesDay = Order::whereBetween('created_at', [$day . " 00:00:01", $day . " 23:59:59"])
            ->sum('amount');

        $this->salesMonth = Order::whereMonth('created_at', $month)
            ->where(function ($query) {
                $query->whereYear('created_at', '=', date("Y"));
            })
            ->sum('amount');

        $this->salesYear = Order::whereYear('created_at', date("Y"))->sum('amount');

        $this->productsDay = Product::join('shipments', 'shipments.idProduct', 'products.id')
            ->join('orders', 'shipments.id_order', 'orders.id')
            ->whereBetween('orders.created_at', [$day . " 00:00:01", $day . " 23:59:59"])
            ->get();



        $this->packagesDay = Package::join('shipments', 'shipments.idPackage', 'packages.id')
        ->join('orders', 'shipments.id_order', 'orders.id')
        ->whereBetween('orders.created_at', [$day . " 00:00:01", $day . " 23:59:59"])
        ->get();
        
       

        $this->membershipsDay = Membership::join('shipments', 'shipments.idMembership', 'memberships.id')
            ->join('orders', 'shipments.id_order', 'orders.id')
            ->whereBetween('orders.created_at', [$day . " 00:00:01", $day . " 23:59:59"])
            ->get();







        //sacar el maximo de ventas
        foreach ($this->products as $product) {
            foreach ($this->productsDay as $item) {
                if ($product->id == $item->idProduct) {
                    $product->n = $product->n + 1;
                }
            }
            if ($this->maxProducts < $product->n) {
                $this->maxProducts = $product->n;
            }
        }

        foreach ($this->packages as $package) {
            foreach ($this->packagesDay as $item) {
                if ($package->id == $item->idPackage) {
                    $package->n = $package->n + 1;
                }
            }
            if ($this->maxPackages < $package->n) {
                $this->maxPackages = $package->n;
            }
        }
        foreach ($this->memberships as $membership) {
            foreach ($this->membershipsDay as $item) {
                if ($membership->id == $item->idMembership) {
                    $membership->n = $membership->n + 1;
                }
            }
            if ($this->maxMemberships < $membership->n) {
                $this->maxMemberships = $membership->n;
            }
        }
    }



    public function render()
    {


        $orders = Order::where(function ($query) {
            $query->where('socialNetwork', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->orWhere('folio', 'like', '%' . $this->search . '%');
        })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(100);



        return view('livewire.dashboard-render', compact('orders'));
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
