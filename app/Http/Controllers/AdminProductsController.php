<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

class AdminProductsController extends Controller
{
   
    public function index()
    {
        return view('admin.products.index');
    }

   
    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'price' => 'required',
            'document' => 'required|mimes:pdf,ppt,pptx',
            'itemMain' => 'required|image',
        ]);

      

        try {
            if (Product::where('title', '=', $request->get('title'))->exists()) {
                return back()->with('exists', 'El producto ' . $request->get('title') . ' ya existe');
            } else {
                Product::create([
                    'title' => request('title'),
                    'price' => request('price'),
                    'itemMain' => request()->file('itemMain')->store('public'),
                    'document' => request()->file('document')->store('public'),
                    'name' => request()->file('document')->getClientOriginalName(),
                    'format' => request()->file('document')->getClientOriginalExtension(),
                    'status' => true,
                    'codeSend' => 'Product'
                ]);
                return back()->with('success', 'Registro exitoso');
            }
        } catch (QueryException $e) {
            return back()->with('error', 'Error al guardar el registro - ' . $e->getMessage());
        }
    }

 
   
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'price' => 'required',
        ]);

        $product = Product::findOrFail($id);
        $newDocument = request()->file('document');
        $newItemMain = request()->file('itemMain');
        if (isset($newItemMain)) {
            Storage::delete($product->itemMain);
            $itemMain = $newItemMain->store('public');
        } else {
            $itemMain = $product->itemMain;
        }
        if (isset($newDocument)) {
            Storage::delete($product->document);
            $document = $newDocument->store('public');
            $name = $newDocument->getClientOriginalName();
            $ext = $newDocument->getClientOriginalExtension();
        } else {
            $document = $product->document;
            $name = $product->name;
            $ext = $product->format;
        }
        try {
            Product::findOrFail($id)->update([
                'title' => request('title'),
                'itemMain' => $itemMain,
                'document' => $document,
                'name' => $name,
                'format' => $ext,
                'price' => request('price'),
            ]);
            return back()->with('success', 'El registro se actualizo de manera correcta');
        } catch (QueryException $e) {
            return back()->with('error', 'Error al actualizar el registro - ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $object = Product::findOrFail($id);
            Product::destroy($id);
            ($object->itemMain != 'default.png') ? Storage::delete($object->itemMain) : '';
            Storage::delete($object->document);
            return back()->with('success', 'El producto se elimino de manera correcta');
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                $messageError = 'Uno o mas clientes han comprado el producto';
            } else {
                $messageError = $e->getMessage();
            }
            return back()->with('error', 'Error al eliminar el registro - ' . $messageError);
        }
    }

   
}
