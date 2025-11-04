<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable=[
        'voucher_type',
        'serie',
        'correlative',
        'date',
        'purchase_order_id',
        'supplier_id',
        'warehouse_id',
        'total',
        'observation',
    ];
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    // realcion muchos a muchos polimorfica
    public function products()
    {
        return $this->morphToMany(Product::class,'productable')
            ->withPivot('quantity','price','subtotal')
            ->withTimeStamps();
    }
}
