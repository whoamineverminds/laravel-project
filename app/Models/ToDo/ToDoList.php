<?php

namespace App\Models\ToDo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToDoList extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'undone'
    ];

    public function getUser()
    {
        return $this->belongsTo('App\Models\Auth\User', 'user_id');
    }

    public function getPlans()
    {
        return $this->hasMany('App\Models\ToDo\ToDoPlan', 'list_id');
    }
}
