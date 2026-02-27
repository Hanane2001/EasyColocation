<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

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
}
