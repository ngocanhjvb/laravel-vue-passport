<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'name', 'area', 'code',
    ];


    public function users()
    {
        return $this->hasMany(User::class);
    }
}
