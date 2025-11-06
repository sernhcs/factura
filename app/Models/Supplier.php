<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $fillable=[
        'identity_id',
        'document_number',
        'name',
        'address',
        'phone',
        'email',
    ];
    
    // realcioin uno a muchos inversa
    public function identity()
    {
        return $this->belongsTo(Identity::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
    public function purchaseOrders()
    {
        return $this->hasMany(Purchase::class);
    }
}
