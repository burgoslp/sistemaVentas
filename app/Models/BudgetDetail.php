<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetDetail extends Model
{
    use HasFactory;
    protected $fillable = ['budget_id', 'article_id', 'amount', 'price_unit'];
    protected $table ="budgets_details";
    
    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }
    
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
