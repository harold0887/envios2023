<?php

namespace App\Http\Controllers;

use App\Models\Envio;
use App\Models\Order;
use App\Models\Enviado;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class AdminSalesControler extends Controller
{

    public function index()
    {
        return view('admin.sales.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    
    public function show($id)
    {
        

        return view('admin.sales.show');
    }

   
    public function edit($id)
    {
        $order=Order::findOrFail($id);
        return view('admin.sales.edit',compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => 'required',
            'socialNetwork' => 'required',
            'price' => 'required',
            'date' => 'required|date',
    
        ]);

        
        try {

            Order::findOrFail($id)->update([
                'email' => request('email'),
                'socialNetwork' => request('socialNetwork'),
                'amount' => request('price'),
                'created_at'=>request('date')
            ]);

         
            return back()->with('success', 'Registro exitoso');
        } catch (QueryException $e) {
            return back()->with('error', 'Error al actualizar el registro - ' .  $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
