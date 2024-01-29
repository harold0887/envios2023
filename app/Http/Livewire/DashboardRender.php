<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Package;
use App\Models\Product;
use Livewire\Component;
use App\Models\Shipment;
use App\Models\Membership;
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
    public $day;
    public  $max_top_products;
    public $nameSubYear0, $nameSubYear1, $nameSubYear2, $nameSubYear3;




    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['rangeSelect', 'rangeClear', 'load_data_chart'];



    public function load_data_chart()
    {






        // $this->emit('setDataChart', [
        //     'subYear1' => $valuesSubYear1,
        //     'subYear2' => $valuesSubYear2,
        // ]);


    }

    public function mount()
    {



        $fecha = now();
        $this->day = $fecha->format('Y-m-d');
        $this->monthSelect = $fecha->format('m');
        $this->yearSelect = $fecha->format('Y');
    }



    public function render()
    {

        $day = $this->day;

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

        $this->salesRange = Order::whereBetween('created_at', [$this->rangeStart . " 00:00:00", $this->rangeEnd . " 23:59:59"])
            ->sum('amount');

        $this->setName($this->monthSelect);


        //Obtener todas las ventas del día (productos, paquetes y membresías)
        $this->salesDay = Order::whereBetween('created_at', [$day . " 00:00:00", $day . " 23:59:59"])
            ->sum('amount');


        //Obtener todas las ventas de productos del día con el numero de ventas y la suma de ventas de cada producto
        $this->productsDay = Product::whereHas('orders', function ($query) use ($day) {
            $query->whereBetween('orders.created_at', [$day . " 00:00:00", $day . " 23:59:59"]);
        })
            ->withCount(['sales' => function ($query)  use ($day) {
                $query->whereBetween('created_at', [$day . " 00:00:00", $day . " 23:59:59"]);
            }])
            ->withSum(['sales' => function ($query)  use ($day) {
                $query->whereBetween('created_at', [$day . " 00:00:00", $day . " 23:59:59"]);
            }], 'price')
            ->get();

        //Obtener todas las ventas de paquetes del día con el numero de ventas y la suma de ventas de cada producto
        $this->packagesDay = Package::whereHas('orders', function ($query) use ($day) {
            $query->whereBetween('orders.created_at', [$day . " 00:00:00", $day . " 23:59:59"]);
        })
            ->withCount(['sales' => function ($query)  use ($day) {
                $query->whereBetween('created_at', [$day . " 00:00:00", $day . " 23:59:59"]);
            }])
            ->withSum(['sales' => function ($query)  use ($day) {
                $query->whereBetween('created_at', [$day . " 00:00:00", $day . " 23:59:59"]);
            }], 'price')
            ->get();


        //Obtener todas las ventas de membresías del día con el numero de ventas y la suma de ventas de cada producto
        $this->membershipsDay = Membership::whereHas('orders', function ($query) use ($day) {
            $query->whereBetween('orders.created_at', [$day . " 00:00:00", $day . " 23:59:59"]);
        })
            ->withCount(['sales' => function ($query)  use ($day) {
                $query->whereBetween('created_at', [$day . " 00:00:00", $day . " 23:59:59"]);
            }])
            ->withSum(['sales' => function ($query)  use ($day) {
                $query->whereBetween('created_at', [$day . " 00:00:00", $day . " 23:59:59"]);
            }], 'price')
            ->get();




        $this->topProducts = Product::withCount('sales')
            ->withSum('sales', 'price')
            ->orderBy('sales_count', 'desc')
            ->take(10)
            ->get();


        //enviar data de grafica
        $valuesSubYear0 = [];
        $valuesSubYear1 = [];
        $valuesSubYear2 = [];
        $valuesSubYear3 = [];



        for ($i = 12; $i > 0; $i--) {

            $sumMonthSubYear0 = Order::whereMonth('created_at', Carbon::now()->subMonths($i))
                ->where(function ($query) {
                    $query->whereYear('created_at', '=', Carbon::now()->format("Y"));
                })->sum('amount');

            array_push($valuesSubYear0, $sumMonthSubYear0);

            $sumMonthSubYear1 = Order::whereMonth('created_at', Carbon::now()->subMonths($i))
                ->where(function ($query) {
                    $query->whereYear('created_at', '=', Carbon::now()->subYear(1)->format("Y"));
                })->sum('amount');

            array_push($valuesSubYear1, $sumMonthSubYear1);

            $sumMonthSubYear2 = Order::whereMonth('created_at', Carbon::now()->subMonths($i))
                ->where(function ($query) {
                    $query->whereYear('created_at', '=', Carbon::now()->subYear(2)->format("Y"));
                })->sum('amount');
            array_push($valuesSubYear2, $sumMonthSubYear2);
            $sumMonthSubYear3 = Order::whereMonth('created_at', Carbon::now()->subMonths($i))
                ->where(function ($query) {
                    $query->whereYear('created_at', '=', Carbon::now()->subYear(3)->format("Y"));
                })->sum('amount');

            array_push($valuesSubYear3, $sumMonthSubYear3);
        }

        $this->nameSubYear0 = Carbon::now()->format("Y");
        $this->nameSubYear1 = Carbon::now()->subYear(1)->format("Y");
        $this->nameSubYear2 = Carbon::now()->subYear(2)->format("Y");
        $this->nameSubYear3 = Carbon::now()->subYear(3)->format("Y");




      


        return view('livewire.dashboard-render', compact('orders', 'valuesSubYear1', 'valuesSubYear2', 'valuesSubYear3', 'valuesSubYear0'));
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
