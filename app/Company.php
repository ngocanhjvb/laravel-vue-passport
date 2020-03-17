<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name', 'address', 'founders',
    ];


    public function jobs()
    {
        return $this->morphedByMany(Job::class, 'companyable');
    }

    /**
     * Get all of the videos that are assigned this tag.
     */
    public function users()
    {
        return $this->morphedByMany(User::class, 'companyable');
    }

    public function employees()
    {
        return $this->hasMany(User::class, 'company_id', 'id');
    }
}
