<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.products.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create',compact('categories'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function store(Request $request)
    {
        
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);


        $product= Product::create($data) ;
        
        session()->flash('swal',[
            'icon'=>'success',
            'title'=>'Bien hecho!',
            'text'=>'El producto se ha creado correctamente',

        ]);

        return redirect()->route('admin.products.edit',$product); 

    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit',compact('product','categories'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);
        
        $product->update($data) ;
        
        session()->flash('swal',[
            'icon'=>'success',
            'title'=>'Bien hecho!',
            'text'=>'El producto se ha actualizado correctamente',

        ]);

        return redirect()->route('admin.products.edit',$product); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if($product->inventories()->exists()) {
            session()->flash('swal',[
                'icon'=>'error',
                'title'=>'Bien hecho!',
                'text'=>'No se puede eliminar la categoría porque tiene productos asociados'
            ]);
            return redirect()->route('admin.products.index');

        };
        if($product->purchaseOrders()->exists() || $product->quotes()->exists()) {
            session()->flash('swal',[
                'icon'=>'error',
                'title'=>'Bien hecho!',
                'text'=>'No se puede eliminar la categoría porque está asociada a órdenes de compra o cotizaciones'
            ]);
            return redirect()->route('admin.products.index');

        };

        $product->delete();
        session()->flash('swal',[
            'icon'=>'success',
            'title'=>'Bien hecho!',
            'text'=>'El producto se ha eliminado correctamente',

        ]);
        return redirect()->route('admin.products.index');
    }
}
