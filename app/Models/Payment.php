<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Colocation;
use App\Models\User;

class Payment extends Model
{
    protected $fillable = ['amount','payer_id','receiver_id','colocation_id','paid_at'];
    protected $casts = ['amount' => 'decimal:2','paid_at' => 'datetime'];
    public function colocation(){
        return $this->belongsTo(Colocation::class);
    }
    public function payer(){
        return $this->belongsTo(User::class, 'payer_id');
    }
    public function receiver(){
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
