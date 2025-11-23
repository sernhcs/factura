<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable=[
        'identity_id',
        'document_number',
        'name',
        'address',
        'email',
        'phone',
    ];

    // realcioin uno a muchos inversa
    public function identity()
    {
        return $this->belongsTo(Identity::class);
    }

    // realcion uno a muchos
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }
    
    public function quotes() {
    return $this->hasMany(Quote::class);
    }
    public function sales() {
    return $this->hasMany(Quote::class);
    }

}
