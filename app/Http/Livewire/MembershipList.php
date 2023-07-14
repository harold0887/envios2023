<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Shipment;
use App\Models\Membership;
use Illuminate\Database\QueryException;

class MembershipList extends Component
{
    public $membresias;
    protected $listeners = [
        'udateData' => 'udateData',
        'updateAgenda' => 'updateAgenda',
        'updateTarjet', 'updateTarjet',
        'sendNotification' => 'sendNotification'
    ];


    public $membershipSelect = '', $search = '', $shipments = '';

    public $url, $nameMembership, $numberDocument = '';
    protected $rules = [
        'numberDocument' => 'required|numeric',
    ];
    public function mount()
    {
        $this->membresias = Membership::where('status', true)
            ->get();

        $this->shipments = Shipment::join('orders', 'shipments.id_order', 'orders.id')
            ->orderBy('shipments.created_at', 'desc')
            ->where('idMembership', $this->membershipSelect)
            ->select('shipments.*', 'orders.folio')
            ->where(function ($query) {
                $query
                    ->where('orders.folio', 'like', '%' . $this->search . '%')
                    ->orWhere('orders.email', 'like', '%' . $this->search . '%')
                    ->orWhere('orders.socialNetwork', 'like', '%' . $this->search . '%');
            })
            ->get();
    }
    public function render()
    {
        if ($this->membershipSelect != '') {
            $this->reset(['shipments']);
            $this->shipments = Shipment::join('orders', 'shipments.id_order', 'orders.id')
                ->orderBy('shipments.created_at', 'desc')
                ->select('shipments.*', 'orders.folio', 'orders.socialNetwork', 'orders.email')
                ->where('idMembership', $this->membershipSelect)
                ->where(function ($query) {
                    $query
                        ->where('orders.folio', 'like', '%' . $this->search . '%')
                        ->orWhere('orders.email', 'like', '%' . $this->search . '%')
                        ->orWhere('orders.socialNetwork', 'like', '%' . $this->search . '%');
                })
                ->get();
        }

        switch ($this->membershipSelect) {
            case '2004':
                $this->url = "https://www.facebook.com/groups/658785861928629/";
                $this->nameMembership = "PREESCOLAR VIP MACA 2022-2023";
                break;

            default:
                # code...
                break;
        }
        return view('livewire.membership-list')
            ->extends('layouts.app', [
                'class' => 'off-canvas-sidebar',
                'classPage' => 'login-page',
                'activePage' => 'membership',
                'title' => "Membresías",
                'pageBackground' => asset("material") . '/img/login.jpg',
                'navbarClass' => 'text-primary',
                'background' => '#eee !important'
            ])

            ->section('content');;
    }

    public function udateData($id,  $nota)
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



    public function updateAgenda($id)
    {
        try {
            Shipment::findOrFail($id)->update([
                'agenda' => 1
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

    public function updateTarjet($id)
    {
        try {
            Shipment::findOrFail($id)->update([
                'tarjeta' => 1
            ]);
            $this->emit('success-auto-close', [
                'message' => 'La entrega de la tarjeta fue actualizada con éxito',
            ]);
        } catch (QueryException $e) {
            $this->emit('error', [
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function clearFilters()
    {
        $this->reset(['search']);
    }

    //confirmar datos antes de enviar notificacion
    public function confirmNotification()
    {
        $this->validate();


        $this->emit('confirmNotification', [
            'number' => $this->numberDocument,
            'nameMembership' => $this->nameMembership,
        ]);
    }


    public function sendNotification()
    {

        $count = 0;
        try {
            $UserMemberships = Shipment::join('orders', 'shipments.id_order', 'orders.id')
                ->orderBy('shipments.created_at', 'desc')
                ->where('idMembership', $this->membershipSelect)
                ->select('email')
                ->get();


            foreach ($UserMemberships as $user) {
                Notification::send($user, new MembershipNotification($this->url, $this->nameMembership, $this->numberDocument));
                $count++;
            }

            Notification::route('mail', 'materiales.maca57@gmail.com')
                ->notify(new MembershipNotification($this->url, $this->nameMembership, $this->numberDocument));

            Notification::route('mail', 'jazmincv1247@gmail.com')
                ->notify(new MembershipNotification($this->url, $this->nameMembership, $this->numberDocument));
            Notification::route('mail', 'arnulfoacosta0887@gmail.com')
                ->notify(new MembershipNotification($this->url, $this->nameMembership, $this->numberDocument));

            $this->emit('sendSuccess', 'Se han enviado ' . $count . ' notificaciones.');
        } catch (\Throwable $e) {
            $this->emit('error', [
                'message' => 'Error al enviar el las notificaciones - ' . $e->getMessage(),
            ]);
        }


        //$toUser = User::findOrFail(54);

        //Notification::send($toUser, new MembershipNotification($this->url, $this->nameMembership, $this->numberDocument, $this->nameDocument));

        //  User::all()->each(function(User $user) use ($product){
        //     $user->notify(new PruebaMessage($product));
        // });


        //   User::all()->each(function(User $user)use($url,$membership){
        //     $user->notify(new PruebaMessage($user,$url, $membership));
        // });





        // $UserMemberships->each(function(User $UserMemberships)use($this->url,$this->nameMembershi,$this->numberDocument,$this->nameDocument){
        //     Notification::send($user, new PruebaMessage($user,$url,$membership));
        // });


    }
}
