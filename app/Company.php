<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name', 'address', 'founders',
    ];


    public function users()
    {
        return $this->hasMany(User::class);
    }
}
