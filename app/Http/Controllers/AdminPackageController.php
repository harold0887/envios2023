<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

class AdminPackageController extends Controller
{

    public function index()
    {
        return view('admin.packages.index');
    }


    public function create()
    {
        return view('admin.packages.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'price' => 'required',
            'itemMain' => 'required|image',
        ]);
        try {
            Package::create([
                'title' => request('title'),
                'price' => request('price'),
                'itemMain' => request()->file('itemMain')->store('public'),
                'status' => true,
                'codeSend' => 'Package'
            ]);
            return back()->with('success', 'Registro exitoso');
        } catch (QueryException $e) {
            return back()->with('error', 'Error al guardar el paquete - ' . $e->getMessage());
        }
    }



    public function edit($id)
    {
        $package = Package::findOrFail($id);
        return view('admin.packages.edit', compact('package'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'price' => 'required',
        ]);

        $product = Package::findOrFail($id);
        $newItemMain = request()->file('itemMain');
        if (isset($newItemMain)) {
            Storage::delete($product->itemMain);
            $itemMain = $newItemMain->store('public');
        } else {
            $itemMain = $product->itemMain;
        }
        try {
            Package::findOrFail($id)->update([
                'title' => request('title'),
                'itemMain' => $itemMain,
                'price' => request('price')
            ]);
            return back()->with('success', 'El paquete se actualizo de manera correcta');
        } catch (QueryException $e) {
            return back()->with('error', 'Error al actualizar el paquete - ' . $e->getMessage());
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
        try {
            $object = Package::findOrFail($id);
            Package::destroy($id);
            if ($object->itemMain) {
                Storage::delete($object->itemMain);
            }
            return back()->with('success', 'El producto se elimino de manera correcta');
        } catch (QueryException $e) {

            if ($e->getCode() == 23000) {
                $messageError = 'Uno o mas clientes han comprado el paquete';
            } else {
                $messageError = $e->getMessage();
            }
            return back()->with('error', 'Error al eliminar el registro - ' . $messageError);
        }
    }
}
