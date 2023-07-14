<?php

namespace App\Http\Livewire;

use App\Models\Payment;
use Livewire\Component;
use App\Models\Category;

class Egresos extends Component
{
    public $year = '';
    public $month = '';
    public $mesEsp = '';

    public function mount()
    {
        $this->month = date("m");
        $this->mesEsp = date("m");
        $this->year = date("Y");
    }
    public function render()
    {
        switch ($this->month) {
            case 1:
                $this->mesEsp = 'Enero';
                break;
            case 2:
                $this->mesEsp = 'Febrero';
                break;
            case 3:
                $this->mesEsp = 'Marzo';
                break;
            case 4:
                $this->mesEsp = 'Abril';
                break;
            case 5:
                $this->mesEsp = 'Mayo';
                break;
            case 6:
                $this->mesEsp = 'Junio';
                break;
            case 7:
                $this->mesEsp = 'Julio';
                break;
            case 8:
                $this->mesEsp = 'Agosto';
                break;
            case 9:
                $this->mesEsp = 'Septiembre';
                break;
            case 10:
                $this->mesEsp = 'Octubre';
                break;
            case 11:
                $this->mesEsp = 'Noviembre';
                break;
            case 12:
                $this->mesEspañol = 'Diciembre';
                break;
            default:

                break;
        }
        $categories = Category::orderBY('name', 'asc')->get();
        $payments = Payment::join('categories', 'movimientos.categories_id', 'categories.id')
            ->where('tipo_egreso', 1)
            ->where(function ($query) {
                $query->whereMonth('movimientos.created_at', '=', $this->month)
                    ->whereYear('movimientos.created_at', '=', $this->year);
            })
            ->select('movimientos.*','categories.name as category')
            ->orderBy('movimientos.created_at', 'asc')
            ->get();

        $presupuesto = Payment::selectRaw('SUM(cantidad) as Total')
            ->where('tipo_egreso', 0)
            ->where(function ($query) {
                $query->whereMonth('movimientos.created_at', '=', $this->month)
                    ->whereYear('movimientos.created_at', '=', $this->year);
            })
            ->get();

        $egresos = Payment::selectRaw('SUM(cantidad) as Total')
            ->where('tipo_egreso', 1)
            ->where(function ($query) {
                $query->whereMonth('movimientos.created_at', '=', $this->month)
                    ->whereYear('movimientos.created_at', '=', $this->year);
            })->get();

        $presupuestoCategorias = Payment::where('tipo_egreso', 0)
            ->where(function ($query) {
                $query->whereMonth('movimientos.created_at', '=', $this->month)
                    ->whereYear('movimientos.created_at', '=', $this->year);
            })->get();
        return view('livewire.egresos', compact('categories', 'payments', 'presupuesto', 'egresos', 'presupuestoCategorias'));
    }


    public function setMont($month)
    {
        $this->emit('prueba');
    }


    public function clearFilters()
    {
        $this->month = date("m");
        $this->year = date("Y");
    }
}
