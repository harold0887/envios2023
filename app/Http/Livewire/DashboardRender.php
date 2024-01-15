<?php

namespace App\Http\Livewire;

use App\Models\Membership;
use App\Models\Order;
use App\Models\Package;
use App\Models\Product;
use App\Models\Shipment;
use Livewire\Component;
use Livewire\WithPagination;

class DashboardRender extends Component
{
    use WithPagination;
    public  $salesDay, $salesMonth, $salesYear, $salesRange;
    public  $productsDay, $packagesDay, $membershipsDay;
    public $maxProducts = 0, $maxPackages = 0, $maxMemberships = 0;
    public $products, $packages, $memberships;
    public $search = '', $range = '', $range2 = '', $rangeStart, $rangeEnd, $rangeStart2, $rangeEnd2;
    public $sortDirection = 'desc';
    public $sortField = 'created_at';
    public $monthSelect, $monthSelectName, $yearSelect;
    public $sum_day_products;
    public  $topProducts;
    public  $max_top_products;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['rangeSelect', 'rangeClear'];




    public function mount()
    {

        $fecha = now();
        $day = $fecha->format('Y-m-d');
        $this->monthSelect = $fecha->format('m');
        $this->yearSelect = $fecha->format('Y');


        $this->products = Product::all();
        $this->packages = Package::all();

        $this->memberships = Membership::all();

        $this->salesDay = Order::whereBetween('created_at', [$day . " 00:00:00", $day . " 23:59:59"])
            ->sum('amount');



        $this->productsDay = Product::join('shipments', 'shipments.idProduct', 'products.id')
            ->join('orders', 'shipments.id_order', 'orders.id')
            ->whereBetween('orders.created_at', [$day . " 00:00:00", $day . " 23:59:59"])
            ->get();

      

     


        Product::join('shipments', 'shipments.idProduct', 'products.id')
            ->join('orders', 'shipments.id_order', 'orders.id')
            ->whereBetween('orders.created_at', [$day . " 00:00:00", $day . " 23:59:59"])
            ->get();



        $this->packagesDay = Package::join('shipments', 'shipments.idPackage', 'packages.id')
            ->join('orders', 'shipments.id_order', 'orders.id')
            ->whereBetween('orders.created_at', [$day . " 00:00:00", $day . " 23:59:59"])
            ->get();



        $this->membershipsDay = Membership::join('shipments', 'shipments.idMembership', 'memberships.id')
            ->join('orders', 'shipments.id_order', 'orders.id')
            ->whereBetween('orders.created_at', [$day . " 00:00:00", $day . " 23:59:59"])
            ->get();


        $this->range = now()->format('Y-m-d') . '-' . now()->format('Y-m-d');
        $this->range2 = now()->format('Y-m-d') . '-' . now()->format('Y-m-d');




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


        $this->salesMonth = Order::whereMonth('created_at', $this->monthSelect)
            ->where(function ($query) {
                $query->whereYear('created_at', '=', $this->yearSelect);
            })
            ->sum('amount');


        $this->salesYear = Order::whereYear('created_at', $this->yearSelect)->sum('amount');

        $this->salesRange = Order::whereBetween('created_at', [$this->rangeStart . " 00:00:01", $this->rangeEnd . " 23:59:59"])
            ->sum('amount');

        $this->setName($this->monthSelect);




        $this->topProducts = Product::where(function ($query) {
            $query->where('title', 'like', '%' . $this->search . '%');
        })->withCount('sales')
            ->withSum('sales', 'price')
            ->orderBy('sales_count', 'desc')
            ->take(5)
            ->get();

        $this->max_top_products = Product::where(function ($query) {
            $query->where('title', 'like', '%' . $this->search . '%');
        })->withCount('sales')
            ->orderBy('sales_count', 'desc')
            ->first();


        return view('livewire.dashboard-render', compact('orders'));
    }




    protected function setName($numeroMes)
    {
        switch ($numeroMes) {
            case 1:
                $this->monthSelectName = "enero";
                break;
            case 2:
                $this->monthSelectName = "febrero";
                break;
            case 3:
                $this->monthSelectName = "marzo";
                break;
            case 4:
                $this->monthSelectName = "abril";
                break;
            case 5:
                $this->monthSelectName = "mayo";
                break;
            case 6:
                $this->monthSelectName = "junio";
                break;
            case 7:
                $this->monthSelectName = "julio";
                break;
            case 8:
                $this->monthSelectName = "agosto";
                break;
            case 9:
                $this->monthSelectName = "septiembre";
                break;
            case 10:
                $this->monthSelectName = "octubre";
                break;
            case 11:
                $this->monthSelectName = "noviembre";
                break;
            case 12:
                $this->monthSelectName = "diciembre";
                break;
            default:

                break;
        }
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


    public function rangeSelect($value, $value2)
    {
        $this->range = $value;
        $this->range2 = $value2;

        $this->rangeStart = substr($this->range, 0, 10);
        $this->rangeEnd = substr($this->range, 13, 24);
        $this->rangeStart2 = substr($this->range2, 0, 10);
        $this->rangeEnd2 = substr($this->range2, 13, 24);
    }
}
