<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','Client_id', 'user_aprove', 'total_amount', 'description', 'status','approved_at'];

   
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    
    public function approver()
    {
        return $this->belongsTo(User::class, 'user_aprove');
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }


}
