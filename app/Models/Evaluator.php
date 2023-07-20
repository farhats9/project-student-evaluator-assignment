<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Evaluator extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'password', 'domain_id'];

    protected $hidden = ['password', 'remember_token'];

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }
}
