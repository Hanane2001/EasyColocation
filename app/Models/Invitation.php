<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Colocation;

class Invitation extends Model
{
    protected $fillable = ['email', 'token', 'status', 'sender_id', 'colocation_id', 'expires_at'];
    public function colocation(){
        return $this->belongsTo(Colocation::class);
    }
    public function sender(){
        return $this->belongsTo(User::class, 'sender_id');
    }
}
