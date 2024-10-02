<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\Enviado;
use App\Models\Package;
use App\Models\Product;
use Livewire\Component;
use App\Models\Shipment;
use App\Models\Membership;
use Livewire\WithFileUploads;
use App\Models\PackageAsProduct;
use App\Http\Controllers\AddLicense;

class CartRender extends Component
{
    use WithFileUploads;
    public $payment;
    public $productSend, $membershipSend;

    public $name, $email, $socialNetwork, $fop;
    public $web;

    public $lastOrder;
    public $folio;
    public $count = 0;
    protected $rules = [
        'email' => 'required|string|email',
        'socialNetwork' => 'required|string',
        //'fop' => 'required',
        //'payment' => 'required|image',

    ];
    protected $messages = [
        'email.required' => 'El correo electrónico no puede estar vacío.',
        'socialNetwork.required' => 'El WhatsApp o Facebook no puede estar vacío',
        //'fop.required' => 'Seleccione una opcion correcta',
        //'payment.required' => 'Debe cargar el comprobante de pago',
    ];
    public function mount()
    {
        $this->web = false;
    }

    public function render()
    {

        return view('livewire.cart-render')
            ->extends('layouts.app', [
                'class' => 'off-canvas-sidebar',
                'classPage' => 'login-page',
                'activePage' => 'cart',
                'title' => "Carrito",
                'navbarClass' => 'text-primary',
                'background' => '#eee !important'
            ])

            ->section('content');
    }
    public function remove($id, $model)
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

        \Cart::remove($product->id);
        $this->emit('cart:update');
        $this->emit('deleteCartAlert', [
            'message' => $product->title . " se ha eliminado del carrito"
        ]);
    }
    public function submit()
    {





        if ($this->web == false) {
            $this->validate();
        } else {
            $this->validate([
                'email' => 'required|string|email',
                'socialNetwork' => 'required|string',
                //'fop' => 'required',
            ]);
        }


        try {
            $newOrder = Order::create([
                'amount' => \Cart::getTotal(),
                'socialNetwork' => $this->socialNetwork,
                'email' => $this->email,
                'receiptPayment' => isset($this->payment) ? $this->payment->store('public/payments') : '',
                'fop' => '-',
            ]);
            $this->folio = "MACA-" . $newOrder->id;
            $newOrder->update([
                'folio' => $this->folio
            ]);



            $enviados = array(); //iniciar enviados vacio
            foreach (\Cart::getContent() as $item) {

                if ($item->associatedModel->codeSend == 'Product') {
                    $this->productSend = Product::find($item->id);
                    array_push($enviados, '<br>' . $this->productSend->title); //llenar el array con un procudto


                    //agregar licencia al documento y enviar correo
                    $sendMailToLicensed = new AddLicense($this->productSend, $newOrder);

                    //Si se envio se agrega ashipment y a envidos
                    if ($sendMailToLicensed->sendDocumento()) {
                        //guardar detalle de venta
                        Shipment::create([
                            'idProduct' => $item->id,
                            'folio' => $this->folio,
                            'id_order' => $newOrder->id,
                            'price' => $item->price,
                        ]);

                        //guardar envio en base de datos de productos
                        Enviado::create([
                            'emal' => $this->email,
                            'order_id' => $newOrder->id,
                            'product_id' => $item->id,
                        ]);
                    }
                }

                if ($item->associatedModel->codeSend == 'Package') {
                    $packageSend = Package::find($item->id);
                    //guardar detalle de venta
                    Shipment::create([
                        'idPackage' => $item->id,
                        'folio' => $this->folio,
                        'id_order' => $newOrder->id,
                        'price' => $item->price,
                    ]);


                    foreach ($packageSend->products as $product) {

                        $this->productSend = Product::find($product->id);
                        array_push($enviados, '<br>' . $this->productSend->title); //agregar los produecto del paquete al array

                        //agregar licencia al documento
                        $sendMailToLicensed = new AddLicense($this->productSend, $newOrder);


                        //Si se envio se agrega ashipment y a envidos
                        if ($sendMailToLicensed->sendDocumento()) {

                            //guardar envio en base de datos de productos
                            Enviado::create([
                                'emal' => $this->email,
                                'order_id' => $newOrder->id,
                                'product_id' => $this->productSend->id,
                            ]);
                        }
                    }
                }
                if ($item->associatedModel->codeSend == 'Membership') {


                    $this->membershipSend = Membership::find($item->id);




                    //guardar detalle de venta
                    Shipment::create([
                        'idMembership' => $item->id,
                        'folio' => $this->folio,
                        'id_order' => $newOrder->id,
                        'price' => $item->price,
                    ]);
                    array_push($enviados, '<br>' . $this->membershipSend->title); //agregar solo informacion
                }
            };
            if ($this->count == 1) {
                $note = 'Se ha enviado correctamente a: ';
            } else {

                $note = 'Se han enviado correctamente a: ';
            }
            \Cart::clear();
            $this->emit('cart:update');
            $this->emit('sendSuccessHtml', [
                'note' => $note,
                'enviados' => $enviados,
                'email' => $this->email
            ]);
        } catch (\Throwable $e) {
            $this->emit('error', [
                'message' => 'Error al enviar el email - ' . $e->getMessage(),
            ]);
        }
    }

    public function changeWeb()
    {

        $this->web == false ? $this->web = true : $this->web = false;
        $this->web == false ? $this->fop = '' : $this->fop = 'Mercado Pago';
    }
}
