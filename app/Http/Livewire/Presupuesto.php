<?php

namespace App\Http\Livewire;

use App\Models\Payment;
use Livewire\Component;
use App\Models\Category;

class Presupuesto extends Component
{
    public $year = '';
    public $month = '';


    //public $expenses = '';
    public $amount = '';
    public $category = '';


    public function mount()
    {
        $this->month = date("m");

        $this->year = date("Y");
    }
    public function render()
    {
        $categories = Category::orderBy('categories.name', 'asc')->get();

        $payments = Payment::where(function ($query) {
            $query->whereMonth('movimientos.created_at', '=', $this->month)
                ->whereYear('movimientos.created_at', '=', $this->year);
        })
            ->get();

        $sumPresupuesto = Payment::where('tipo_egreso', 0)
            ->where(function ($query) {
                $query->whereMonth('movimientos.created_at', '=', $this->month)
                    ->whereYear('movimientos.created_at', '=', $this->year);
            })
            ->sum('cantidad');



        $sumGastos = Payment::where('tipo_egreso', 1)
            ->where(function ($query) {
                $query->whereMonth('movimientos.created_at', '=', $this->month)
                    ->whereYear('movimientos.created_at', '=', $this->year);
            })
            ->sum('cantidad');




        return view(
            'livewire.presupuesto',
            compact('payments', 'categories', 'sumPresupuesto', 'sumGastos')
        )
            ->extends('layouts.app', [
                'class' => 'off-canvas-sidebar',
                'classPage' => 'login-page',
                'activePage' => 'presupuesto',
                'title' => "Presupuesto",
                'pageBackground' => asset("material") . '/img/login.jpg',
                'navbarClass' => 'text-primary',
                'background' => '#eee !important'
            ])

            ->section('content');
    }

    public function submit()
    {

        $this->validate([
            'amount' => 'required|numeric',
            'category' => 'required| numeric|min:1',
        ]);



        $categoryName = Category::findOrFail($this->category);


        switch (date("m")) {
            case 1:
                $mesEsp = 'Enero';
                break;
            case 2:
                $mesEsp = 'Febrero';
                break;
            case 3:
                $mesEsp = 'Marzo';
                break;
            case 4:
                $mesEsp = 'Abril';
                break;
            case 5:
                $mesEsp = 'Mayo';
                break;
            case 6:
                $mesEsp = 'Junio';
                break;
            case 7:
                $mesEsp = 'Julio';
                break;
            case 8:
                $mesEsp = 'Agosto';
                break;
            case 9:
                $mesEsp = 'Septiembre';
                break;
            case 10:
                $mesEsp = 'Octubre';
                break;
            case 11:
                $mesEsp = 'Noviembre';
                break;
            case 12:
                $mesEsp = 'Diciembre';
                break;
            default:

                break;
        }

        try {
            Payment::create([
                'cantidad' => $this->amount,
                'concepto' => 'Presupuesto ' . $categoryName->name . ' ' . $mesEsp . ' ' . date("Y"),
                'categories_id' => $this->category,
                'tipo_egreso' => 0,
            ]);
            $this->emit('success-auto-close', [
                'message' => 'El presupuesto se creo con éxito',
            ]);

            $this->reset('amount', 'category');
        } catch (\Throwable $e) {
            $this->emit('error', [
                'message' => 'Error al guardar el presupuesto - ' . $e->getMessage(),
            ]);
        }
    }

    public function clearFilters()
    {
        $this->month = date("m");

        $this->year = date("Y");
    }
}
