<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\Enviado;
use App\Models\Package;
use App\Models\Product;
use Livewire\Component;
use App\Models\Shipment;

use App\Models\PackageAsProduct;
use App\Http\Controllers\AddLicense;
use setasign\Fpdi\Fpdi; // Like this
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Request;

class ShowSales extends Component
{
    public $patch, $ids, $order, $idPackage, $count = 0;

    protected $listeners = [
        'resend' => 'resend',
        'udateData1' => 'udateData1',
    ];



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
        $purchases = Shipment::join('orders', 'shipments.id_order', '=', 'orders.id')
            ->join('products', 'shipments.idProduct', '=', 'products.id')
            ->where('shipments.id_order', $this->ids)
            ->orderBy('products.title')
            ->select(
                'products.id',
                'products.itemMain',
                'shipments.price',
                'products.title',
            )->get();

        $packages = Package::join('shipments', 'shipments.idPackage', '=', 'packages.id')
            ->join('orders', 'shipments.id_order', '=', 'orders.id')
            ->where('shipments.id_order', $this->ids)
            ->orderBy('packages.title')
            ->select('packages.id', 'packages.codeSend', 'packages.itemMain', 'packages.price', 'packages.title')
            ->get();



        $memberships = Shipment::join('orders', 'shipments.id_order', '=', 'orders.id')
            ->join('memberships', 'shipments.idMembership', '=', 'memberships.id')
            ->where('shipments.id_order', $this->ids)
            ->orderBy('memberships.title')
            ->select(
                'memberships.id',
                'memberships.itemMain',
                'shipments.price',
                'memberships.title',
                'shipments.agenda',
                'shipments.nota',
                'shipments.tarjeta',
                'shipments.id as idOrder'
            )->get();

        $productsPackagesOrder = PackageAsProduct::join('products', 'package_product.product_id', 'products.id')
            ->where('package_product.package_id', $this->idPackage)
            ->select('products.title', 'products.id', 'products.itemMain', 'products.price', 'products.status')
            ->orderBy('title')
            ->get();


        $enviados = Enviado::where('order_id', $this->order->id)
            ->orderBy('created_at', 'desc')
            ->get();



        return view('livewire.show-sales', compact('purchases', 'enviados', 'packages', 'memberships', 'productsPackagesOrder'));
    }


    public function showPackages($idPackage)
    {
        $this->idPackage = $idPackage;
    }

    // public function confirmResend($id, $codeSend, $name)
    // {
    //     $this->emit('confirmResend', [
    //         'message' => 'Error al reenviar el email',
    //         'id' => $id,
    //         'condeSend' => $codeSend,
    //         'name' => $name

    //     ]);
    // }

    public function resend($id, $codeSend)
    {
        $enviados = array(); //iniciar enviados vacio

        //reenvio de email
        try {

            if ($codeSend == 'Product') {
                $this->count++;
                $productSend = Product::find($id);

                $addLicense = new AddLicense($productSend, $this->order);

                //Si el correo se envia de manera correcta, llenar array y registrar envio
                if ($addLicense->sendDocumento()) {
                    array_push($enviados, $productSend->title); //llenar el array con un producto
                    //guardar envio en base de datos de productos
                    Enviado::create([
                        'emal' => $this->order->email,
                        'order_id' => $this->order->id,
                        'product_id' => $productSend->id,
                    ]);
                }
            }
            if ($codeSend == 'Package') {


                $productsIcluded = Package::findOrFail($id);




                foreach ($productsIcluded->products as $product) {
                    $this->count++;
                    $productSend = Product::find($product->id);

                    $addLicense = new AddLicense($productSend, $this->order);

                    //Si el correo se envia de manera correcta, llenar array y registrar envio
                    if ($addLicense->sendDocumento()) {
                        array_push($enviados, $productSend->title); //llenar el array con un producto
                        //guardar envio en base de datos de productos
                        Enviado::create([
                            'emal' => $this->order->email,
                            'order_id' => $this->order->id,
                            'product_id' => $productSend->id,
                        ]);
                    }
                }
            }
            if ($this->count == 1) {
                $note = 'Se ha reenviado correctamente a: ';
            } else {

                $note = 'Se han reenviado correctamente a: ';
            }

            $this->emit('sendSuccessHtml', [
                'note' => $note,
                'enviados' => $enviados,
                'email' => $this->order->email
            ]);
            $this->count = 0;
        } catch (\Throwable $e) {
            $this->emit('error', [
                'message' => 'Error al reenviar el email - ' . $e->getMessage(),
            ]);
        }
    }


    public function download(Product $product)
    {

        try {
            if ($product->format == 'pdf') {

                $addLicense = new AddLicense($product, $this->order);

                if ($addLicense->download()) {
                    $file = "pdf/newpdf.pdf";

                    return response()->download($file, $this->order->folio . ' - ' . $product->title . ".pdf");
                }
            } else {
                $this->emit('error', [
                    'message' => 'Error al descargar el documento -  No es un PDF',
                ]);
            }
        } catch (\Throwable $th) {
            $this->emit('error', [
                'message' => 'error al descargar el documento - ' . $th->getMessage(),
            ]);
        }
    }
    public function updateAgenda1($id)
    {
        try {
            $venta = Shipment::findOrFail($id);
            $status = $venta->agenda;

            $venta->update([
                'agenda' => $status == 0 ? true : false
            ]);
            $this->emit('success-auto-close', [
                'message' => 'La entrega de la agenda fue actualizada con éxito',
            ]);
        } catch (QueryException $e) {
            $this->emit('error', [
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function updateTarjet1($id)
    {
       
        try {
            $venta = Shipment::findOrFail($id);

            $status = $venta->tarjeta;

            $venta->update([
                'tarjeta' => $status == 0 ? true : false
            ]);
            $this->emit('success-auto-close', [
                'message' => 'El registro web fue actualizado con éxito',
            ]);
        } catch (QueryException $e) {
            $this->emit('error', [
                'message' => $e->getMessage(),
            ]);
        }
    }
    public function udateData1($id,  $nota)
    {
        
        try {
            Shipment::findOrFail($id)->update([
                'nota' => $nota
            ]);
            $this->emit('success-auto-close', [
                'message' => 'La membresia fue actualizada con éxito',
            ]);
        } catch (\Throwable $e) {
            $this->emit('error', [
                'message' => 'Error al actualizar la membresia - ' . $e->getMessage(),
            ]);
        }
    }
}
