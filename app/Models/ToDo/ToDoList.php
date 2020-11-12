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

    public function getPlans()
    {
        return $this->hasMany('App\Models\to_do\ToDoPlan', 'list_id');
    }
}
