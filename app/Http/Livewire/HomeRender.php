<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\Package;
use App\Models\Product;
use Livewire\Component;
use App\Models\Shipment;
use App\Models\Membership;
use Illuminate\Support\Facades\Storage;

class HomeRender extends Component
{
    public $products;
    public $packages;
    public $memberships;
    public $shipmentsProducts;
    public $img, $title, $price;
    public $search = '';


    public function mount()
    {
        $this->products = Product::orderBy('created_at', 'desc')
            ->where('status', true)
            ->get();
        $this->packages = Package::orderBy('title')
            ->where('status', true)
            ->get();
        $this->memberships = Membership::orderBy('title')
            ->where('status', true)
            ->get();
        $this->shipmentsProducts = Shipment::join('products', 'shipments.idProduct', 'products.id')
            ->where('id_order', 8)
            ->select('products.title', 'shipments.price', 'products.itemMain')
            ->get();
        //dd(json_encode($this->shipmentsProducts));
    }
    public function render()
    {
        $orders = Order::where(function ($query) {
            $query->where('socialNetwork', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->orWhere('folio', 'like', '%' . $this->search . '%');
        })->orderBy('created_at', 'desc')
            ->paginate(100);
        return view('livewire.home-render', compact('orders'));
    }

    public function addCart($id, $model)
    {
        if ($model == "Product") {
            $product = Product::find($id);
        }
        if ($model == "Membership") {
            $product = Membership::find($id);
        }
        if ($model == "Package") {
            $product = Package::find($id);
        }
        //dd($product);

        $this->img = Storage::url($product->itemMain);
        $this->title = $product->title;
        $this->price = $product->price;

        \Cart::add(array(
            'id' => $product->id,
            'name' => $product->title,
            'price' => $product->price,
            'quantity' => 1,
            'attributes' => array([]),
            'associatedModel' => $product
        ));
        $this->emit('cart:update');
        $this->emit('addCartAlert', [
            'title' => $this->title,
            'price' => $this->price,
            'image' => $this->img
        ]);
    }


    public function clearSearch()
    {
        $this->reset(['search']);
    }
}
