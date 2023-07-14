<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

class AdminMembershipController extends Controller
{


    public function index()
    {
        return view('admin.memberships.index');
    }


    public function create()
    {
        return view('admin.memberships.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'itemMain' => 'required|image',
            'price' => 'required',
        ]);


        $price = number_format((float)request('price'), 2, '.', '');

        try {
            Membership::create([
                'title' => request('title'),
                'price' => $price,
                'itemMain' => request()->file('itemMain')->store('public/membership'),
                'status' => true,
                'codeSend' => 'Membership',
            ]);
            return back()->with('success', 'Registro exitoso');
        } catch (QueryException $e) {

            return back()->with('error', 'Error al guardar el registro - ' . $e->getMessage());
        }
    }




    public function edit($id)
    {
        $membership = Membership::findOrFail($id);
        return view('admin.memberships.edit', compact('membership'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'price' => 'required',
        ]);

        $newItemMain = request()->file('itemMain');
        $membership = Membership::findOrFail($id);
        if (isset($newItemMain)) {
            Storage::delete($membership->itemMain);
            $itemMain = request()->file('itemMain')->store('public/membership');
        } else {
            $itemMain = $membership->itemMain;
        }
        $price = number_format((float)request('price'), 2, '.', '');


        try {
            Membership::findOrFail($id)->update([
                'title' => request('title'),
                'price' => $price,
                'itemMain' => $itemMain,
                'status' => true,
            ]);
            return back()->with('success', 'El registro se actualizó de manera correcta');
        } catch (\Throwable $e) {
            if ($e->getCode() == 23000) {
                $messageError = 'La membresia ' . $request->get('title') . ' ya existe';
            } else {
                $messageError = $e->getMessage();
            }
            return back()->with('error', 'Error al actualizar el registro - ' . $messageError);
        }
    }

    public function destroy($id)
    {
        try {
            $object = Membership::findOrFail($id);
            Membership::destroy($id);
            Storage::delete($object->itemMain);
            return back()->with('success', 'La membresía se elimino de manera correcta');
         
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                $messageError = 'Uno o mas clientes han comprado la membresia';
            } else {
                $messageError = $e->getMessage();
            }
            return back()->with('error', 'Error al eliminar el registro - ' . $messageError);
        }
    }
}
