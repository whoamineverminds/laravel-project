<?php

namespace App\Models\ToDo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToDoPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'priority',
        'complete'
    ];

    public function getList()
    {
        return $this->belongsTo('App\Models\to_do\ToDoList', 'list_id');
    }

    protected static function booted()
    {
        static::created(function (ToDoPlan $plan) {
            if (!$plan->complete) {
                $foundList = $plan->getList()->first();
                ++$foundList->undone;
                $foundList->save();
            }
        });

        static::deleted(function (ToDoPlan $plan) {
            if (!$plan->complete) {
                $foundList = $plan->getList()->first();
                --$foundList->undone;
                $foundList->save();
            }
        });
    }
}
