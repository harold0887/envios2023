<?php

namespace App\Http\Livewire;

use App\Models\Package;
use App\Models\Product;

use Illuminate\Support\Facades\Request;

use Livewire\Component;

class EditPackages extends Component
{
    public $patch, $ids, $package, $search = '';
    protected $listeners = ['some-event' => '$refresh'];
    public function mount()
    {
        $patch = Request::fullUrl();
        $this->patch = Request::fullUrl();
        $div = explode("/", $patch);
        $this->ids = $div[5];
        $this->package = Package::findOrFail($this->ids);
    }
    public function render()
    {
        $products = Product::where(function ($query) {
            $query->where('title', 'like', '%' . $this->search . '%');
        })
            ->orderBy('name', 'asc')->get();


        return view('livewire.edit-packages', compact('products'));
    }
    public function addToPackage($id)
    {
        try {

            $products_in_package = $this->package->products;
            $exist = false;

            //recorrer los productos y solo si no existe el producto, agregarlo
            foreach ($products_in_package as $product) {
                if ($product->id == $id) {
                    $this->emit('error', [
                        'message' => 'Este documento ya esta incluido en - ' . $this->package->title,
                    ]);
                    $exist = true;
                    break;
                }
            }

            if (!$exist) {
                $this->package->products()->attach($id);
                $this->emit('some-event');
                $this->emit('success-auto-close', [
                    'message' => 'Archivo agregado correctamente.',
                ]);
            }
        } catch (\Throwable $e) {
            $this->emit('error', [
                'message' => 'Error al eliminar el registro - ' . $e->getMessage(),
            ]);
        }
    }
    public function removeToPackage($id)
    {
        try {
            $this->package->products()->detach($id);
            $this->emit('some-event');
            $this->emit('success-auto-close', [
                'message' => 'Archivo eliminado correctamente.',
            ]);
        } catch (\Throwable $e) {
            $this->emit('error', [
                'message' => 'Error al eliminar el archivo - ' . $e->getMessage(),
            ]);
        }
    }
    public function clearSearch()
    {
        $this->reset(['search']);
    }
}
