<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Colocation;
use App\Models\User;

class Expense extends Model
{
    protected $fillable = [
        'title',
        'amount',
        'user_id',
        'colocation_id',
        'category_id',
        'expense_date'
    ];

    protected $casts = [
        'expense_date' => 'date',
        'amount' => 'decimal:2'
    ];


    public function colocation(){
        return $this->belongsTo(Colocation::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
}