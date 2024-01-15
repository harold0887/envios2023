<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

class IndexProducts extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $sortDirection = 'desc';
    public $sortField = 'created_at';
    protected $listeners = [
        'delete' => 'delete',
    ];
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $products = Product::where(function ($query) {
            $query->where('title', 'like', '%' . $this->search . '%');
        })->withCount('sales')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(50);
        return view('livewire.index-products', compact('products'));
    }

    public function changeStatus($id, $status)
    {
        try {
            Product::findOrFail($id)->update([
                'status' => $status == 0 ? true : false
            ]);

            $this->emit('success-auto-close', [
                'message' => 'El cambio se realizo con éxito',
            ]);
        } catch (QueryException $e) {
            $this->emit('error', [
                'message' => $e->getMessage(),
            ]);
        }
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

    public function downloadOriginalDocument($id)
    {
        try {
            $document = Product::findOrFail($id);
            return Storage::download($document->document, $document->title);
        } catch (\Throwable $th) {
            $this->emit('error', [
                'message' => 'Error al descargar el documento - ' . $th->getMessage(),
            ]);
        }
    }


    public function changeFolio($id, $status)
    {
        try {
            Product::findOrFail($id)->update([
                'folio' => $status == 0 ? true : false
            ]);
            $this->emit('success-auto-close', [
                'message' => 'El cambio se realizo con éxito',
            ]);
        } catch (QueryException $e) {
            $this->emit('error', [
                'message' => $e->getMessage(),
            ]);
        }
    }
}
