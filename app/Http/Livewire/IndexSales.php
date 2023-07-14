<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\QueryException;

class IndexSales extends Component
{
    use WithPagination;
    public $search = '';
    public $order;

    protected $paginationTheme = 'bootstrap';

    public $sortDirection = 'desc';
    public $sortField = 'created_at';
    public function updatingSearch()
    {
        $this->resetPage();
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
        return view('livewire.index-sales',compact('orders'));
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
    public function clearSearch()
    {
        $this->reset(['search']);
    }
    public function deleteOrder($id)
    {

        try {

            Order::destroy($id);

            $this->emit('deleteSuccess', $id);
        } catch (QueryException $e) {

            if ($e->getCode() == 23000) {
                $messageError = 'La orden tene uno o mas productos asignados.';
            } else {
                $messageError = $e->getMessage();
            }
            $this->emit('error', [
                'message' => 'Error al eliminar el registro - ' . $messageError,
            ]);
        }
    }
}
