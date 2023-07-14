<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\Package;
use App\Models\Product;
use Livewire\Component;
use App\Models\Shipment;
use App\Models\Membership;
use Illuminate\Support\Facades\Request;

class SalesEdit extends Component
{
    public $patch, $ids, $order, $idPackage, $count = 0;




    public function mount()
    {
        $patch = Request::fullUrl();
        $this->patch = Request::fullUrl();
        $div = explode("/", $patch);
        $this->ids = $div[5];
        $this->order = Order::findOrFail($this->ids);
        $this->idPackage = 1000;
    }
    public function render()
    {
        $products = Product::where('status', true)
            ->orderBy('title')
            ->get();


        $packages = Package::where('status', true)
            ->orderBy('title')
            ->get();



        $memberships = Membership::where('status', true)
            ->orderBy('title')
            ->get();

        $productsIncluded = Shipment::join('orders', 'shipments.id_order', '=', 'orders.id')
            ->join('products', 'shipments.idProduct', '=', 'products.id')
            ->where('shipments.id_order', $this->ids)
            ->orderBy('products.title')
            ->select(
                'products.id',
                'products.itemMain',
                'shipments.price',
                'products.title',
            )->get();



        $PackagesIcluded = Package::join('shipments', 'shipments.idPackage', '=', 'packages.id')
            ->join('orders', 'shipments.id_order', '=', 'orders.id')
            ->where('shipments.id_order', $this->ids)
            ->orderBy('packages.title')
            ->get();

     


        $MembershipsIcluded = Shipment::join('orders', 'shipments.id_order', '=', 'orders.id')
            ->join('memberships', 'shipments.idMembership', '=', 'memberships.id')
            ->where('shipments.id_order', $this->ids)
            ->orderBy('memberships.title')
           ->get();

        $sumaProductos = Shipment::join('products', 'shipments.idProduct', 'products.id')
            ->where('shipments.id_order', $this->order->id)
            ->sum('shipments.price');





        $sumaPackages = Shipment::join('packages', 'shipments.idPackage', 'packages.id')
            ->where('shipments.id_order', $this->order->id)
            ->sum('shipments.price');




        $sumaMembresias = Shipment::join('memberships', 'shipments.idMembership', 'memberships.id')
            ->where('shipments.id_order', $this->order->id)
            ->sum('shipments.price');



        $suma = $sumaProductos + $sumaMembresias + $sumaPackages;
        return view('livewire.sales-edit', compact('products', 'packages', 'memberships', 'suma', 'productsIncluded', 'MembershipsIcluded', 'PackagesIcluded'));
    }

    public function addProduct($id)
    {
        $product = Product::findOrFail($id);
        $this->order->products()->attach($id, [
            'price' => $product->price,
            'folio' => $this->order->folio,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
    public function removeProduct($id)
    {
        $this->order->products()->detach($id);
    }


    public function addPackage($id)
    {
        $package = Package::findOrFail($id);
        $this->order->Packages()->attach($id, [
            'price' => $package->price,
            'folio' => $this->order->folio,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
    public function removePackage($id)
    {
        $this->order->Packages()->detach($id);
    }


    public function addMembership($id)
    {
        $membership = Membership::findOrFail($id);
        $this->order->Memberships()->attach($id, [
            'price' => $membership->price,
            'folio' => $this->order->folio,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
    public function removeMembership($id)
    {
        $this->order->Memberships()->detach($id);
    }
}
