<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $fillable=[
        'voucher_type',
        'serie',
        'correlative',
        'date',
        'customer_id',
        'total',
        'observation',
    ];

    protected $casts=[
        'date'=>'datetime:d/m/Y',
        'total'=>'decimal:2',
    ];


    // realcuiob yuno amuchos inversa
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
