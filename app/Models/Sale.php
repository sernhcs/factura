<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
        protected $fillable=[
        'voucher_type',
        'serie',
        'correlative',
        'date',
        'quote_id',
        'customer_id',
        'warehouse_id',
        'total',
        'observation',
    ];

    // realcion yuno amuchos inversa
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // realcion muchos a muchos polimorfica
    public function products()
    {
        return $this->morphToMany(Product::class,'productable')
            ->withPivot('quantity','price','subtotal')
            ->withTimeStamps();
    }

}
