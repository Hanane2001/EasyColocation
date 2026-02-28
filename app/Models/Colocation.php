<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Invitation;
use App\Models\Expense;
use App\Models\Category;
use App\Models\Payment;

class Colocation extends Model
{
    protected $fillable = ['name', 'owner_id', 'statusColocation'];
    public function owner(){
        return $this->belongsTo(User::class, 'owner_id');
    }
    public function users(){
        return $this->belongsToMany(User::class, 'membership')->withPivot(['joined_at', 'left_at'])->withTimestamps();
    }
    public function activeUsers(){
        return $this->users()->wherePivotNull('left_at');
    }
    public function invitations(){
        return $this->hasMany(Invitation::class);
    }
    public function expenses(){
        return $this->hasMany(Expense::class);
    }
    public function categories(){
        return $this->hasMany(Category::class);
    }
    public function payments(){
        return $this->hasMany(Payment::class);
    }

    public function calculateUserBalance(User $user){
        $users = $this->activeUsers()->get();
        $totalExpenses = $this->expenses()->sum('amount');
        $memberCount = $users->count();
        $share = $memberCount > 0 ? $totalExpenses / $memberCount : 0;
        $paid = $this->expenses()->where('user_id', $user->id)->sum('amount');
        $received = $this->payments()->where('receiver_id', $user->id)->sum('amount');
        $sent = $this->payments()->where('payer_id', $user->id)->sum('amount');
        return $paid - $share + $received - $sent;
    }
}
