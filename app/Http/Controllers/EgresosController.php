<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class EgresosController extends Controller
{
    
    public function index()
    {
        return view('admin.egresos.index');
    }

   
    public function create()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        return view('admin.egresos.create', compact('categories'));
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'concept' => 'required',
            'amount' => 'required',
            'category' => 'required',
        ]);

    

        try {
            Payment::create([
                'concepto' => request('concept'),
                'cantidad' => request('amount'),
                'categories_id' => request('category'),
                'tipo_egreso' => 1,
            ]);
            return back()->with('success', 'Registro exitoso');
        } catch (QueryException $e) {
            return back()->with('error', 'Error al guardar el registro - ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
