<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'client_id', 'total_amount', 'description', 'status'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    
    public function details()
    {
        return $this->hasMany(BudgetDetail::class);
    }
    
    public function order()
    {
        return $this->hasOne(Order::class);
    }
}
