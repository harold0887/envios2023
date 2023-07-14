<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\Payment;
use Livewire\Component;

class Balance extends Component
{
    public $year = '';
    public $month = '';
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
                $this->mesEsp = 'Diciembre';
                break;
            default:
                $this->mesEsp = '';
                break;
        }
        $ingresos = Order::selectRaw('SUM(amount) as Total')
            ->get();
        $egresos = Payment::selectRaw('SUM(cantidad) as Total')
            ->where('tipo_egreso', 1)
            ->get();

        if ($this->month !== '') {
            $ingresos = Order::selectRaw('SUM(amount) as Total')
                ->where(function ($query) {
                    $query->whereMonth('orders.created_at', '=', $this->month)
                        ->whereYear('orders.created_at', '=', date("Y"));
                })
                ->get();
            $egresos = Payment::selectRaw('SUM(cantidad) as Total')
                ->where('tipo_egreso', 1)
                ->where(function ($query) {
                    $query->whereMonth('movimientos.created_at', '=', $this->month)
                        ->whereYear('movimientos.created_at', '=', date("Y"));
                })->get();
        }
        if ($this->year !== '') {
            $ingresos = Order::selectRaw('SUM(amount) as Total')
                ->where(function ($query) {
                    $query->whereYear('orders.created_at', '=', $this->year);
                })
                ->get();
            $egresos = Payment::selectRaw('SUM(cantidad) as Total')
                ->where('tipo_egreso', 1)
                ->where(function ($query) {
                    $query->whereYear('movimientos.created_at', '=', $this->year);
                })->get();
        }

        if ($this->month !== '' && $this->year !== '') {
            $ingresos = Order::selectRaw('SUM(amount) as Total')
                ->where(function ($query) {
                    $query->whereMonth('orders.created_at', '=', $this->month)
                        ->whereYear('orders.created_at', '=', $this->year);
                })
                ->get();
            $egresos = Payment::selectRaw('SUM(cantidad) as Total')
                ->where('tipo_egreso', 1)
                ->where(function ($query) {
                    $query->whereMonth('movimientos.created_at', '=', $this->month)
                        ->whereYear('movimientos.created_at', '=', $this->year);
                })->get();
        }

        return view('livewire.balance', compact('ingresos', 'egresos'))
            ->extends('layouts.app', [
                'class' => 'off-canvas-sidebar',
                'classPage' => 'login-page',
                'activePage' => 'balance',
                'title' => "Balance",
                'pageBackground' => asset("material") . '/img/login.jpg',
                'navbarClass' => 'text-primary',
                'background' => '#eee !important'
            ])

            ->section('content');
    }
    public function clearFilters()
    {
        $this->month = '';
        $this->year = '';
    }
}
