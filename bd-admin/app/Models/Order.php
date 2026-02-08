<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'address',
        'district', 'city', 'postcode', 'notes', 'payment_method',
        'subtotal', 'delivery_charge', 'total', 'status', 'delivery_status' 
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
