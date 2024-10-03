<?php

namespace App\Http\Livewire;

use App\Models\Payment;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;

class Egresos extends Component
{


    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $sortDirection = 'desc';
    public $sortField = 'created_at';


    public $filters = [
        'month' => '',
        'year' => '',
        'category' => '',
    ];

    public function mount()
    {
        $this->filters['month'] = date("m");
        $this->filters['year'] = date("Y");
    }
    public function render()
    {

        $categories = Category::orderBY('name', 'asc')->get();

        $gastos = Payment::filter($this->filters)
            ->orderBy($this->sortField, $this->sortDirection)
            ->where('tipo_egreso', 1)
            ->get();

        $presupuesto = Payment::filter($this->filters)
            ->where('tipo_egreso', 0)
            ->sum('cantidad');


        $egresos = Payment::filter($this->filters)
            ->where('tipo_egreso', 1)
            ->sum('cantidad');

        return view('livewire.egresos', compact('categories', 'presupuesto', 'egresos', 'gastos'));
    }

    public function clear()
    {
        $this->filters['category'] = '';
    }
    public function clearYear()
    {
        $this->filters['year'] = date("Y");
    }

    public function clearMonth()
    {
        $this->filters['month'] = date("m");
    }



    //sort
    public function setSort($field)
    {

        $this->sortField = $field;

        if ($this->sortDirection == 'desc') {
            $this->sortDirection = 'asc';
        } else {
            $this->sortDirection = 'desc';
        }
    }
}
