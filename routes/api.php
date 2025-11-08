<?php

use App\Models\Customer;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/suppliers',function(Request $request){
    $suppliers= Supplier::select('id','name')
    ->when($request->search,function($query, $search){
        $query
            ->where('name', 'like', "%{$search}%")
            ->orWhere('document_number', 'like', "%{$search}%");

    })
    ->when(
        $request->exists('selected'),
            fn ( $query) => $query->whereIn('id', $request->input('selected', [])),
            fn ( $query) => $query->limit(10)
        )
    ->get();
    
    return response()->json($suppliers);

})->name('api.suppliers.index');

Route::post('/warehouses',function(Request $request){
    $suppliers= Warehouse::select('id','name','location as description')
    ->when($request->search,function($query, $search){
        $query
            ->where('name', 'like', "%{$search}%")
            ->orWhere('location', 'like', "%{$search}%");

    })
    ->when(
        $request->exists('selected'),
            fn ( $query) => $query->whereIn('id', $request->input('selected', [])),
            fn ( $query) => $query->limit(10)
        )
    ->get();
    
    return response()->json($suppliers);

})->name('api.warehouses.index');

Route::post('/products',function(Request $request){
    $suppliers= Product::select('id','name')
    ->when($request->search,function($query, $search){
        $query
            ->where('name', 'like', "%{$search}%")
            ->orWhere('sku', 'like', "%{$search}%");

    })
    ->when(
        $request->exists('selected'),
            fn ( $query) => $query->whereIn('id', $request->input('selected', [])),
            fn ( $query) => $query->limit(10)
        )
    ->get();
    
    return response()->json($suppliers);

})->name('api.products.index');

Route::get('purchase-orders', function (Request $request) {
   $purchasesOrders = PurchaseOrder::query()
    ->when($request->input('search'), function ($query, $search) {
        $parts = explode('-', $search);

        if (count($parts) == 1) {
                //buscar por nombre de proveedor
            $query->whereHas('supplier', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('document_number', 'LIKE', "%{$search}%");
            }); 
            return;
        }
        if (count($parts) == 2) {
            $serie = $parts[0];
            $correlative = ltrim($parts[1], '0');

            $query->where('serie', $serie)
                ->where('correlative', 'LIKE', "%{$correlative}%");
            return;
        }


    })
     ->when(
        $request->exists('selected'),
            fn ( $query) => $query->whereIn('id', $request->input('selected', [])),
            fn ( $query) => $query->limit(10)
        )
    ->with(['supplier'])
    ->orderBy('created_at', 'desc')
    ->get();
    // ->orderBy('created_at', 'desc')
    // ->paginate($request->input('per_page', 10));

    return  $purchasesOrders->map(function ($purchaseOrder) {
        return [
            'id' => $purchaseOrder->id,
            'name' => "{$purchaseOrder->serie}-" . $purchaseOrder->correlative,
            'description' => $purchaseOrder->supplier->name.'-'.$purchaseOrder->supplier->document_number,
        ];
    });
})
->name('api.purchase-orders.index');


Route::post('/customers',function(Request $request){
    $customers= Customer::select('id','name')
    ->when($request->search,function($query, $search){
        $query
            ->where('name', 'like', "%{$search}%")
            ->orWhere('document_number', 'like', "%{$search}%");

    })
    ->when(
        $request->exists('selected'),
            fn ( $query) => $query->whereIn('id', $request->input('selected', [])),
            fn ( $query) => $query->limit(10)
        )
    ->get();
    
    return response()->json($customers);

})->name('api.customers.index');