<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lists extends Model
{
    use HasFactory;
    const CREATED_AT = 'date_create';
    const UPDATED_AT = 'date_change';
    protected $fillable = ['title'];

    public function getPlans()
    {
        return $this->hasMany('App\Models\Plans', 'list_id');
    }
}
