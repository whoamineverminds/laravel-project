<?php

namespace App\Models\to_do_list;

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
        return $this->belongsTo('App\Models\to_do_list\ToDoList', 'list_id');
    }

    protected static function booted()
    {
        static::created(function ($user) {
            if (!$user->complete) {
                $foundList = $user->getList;
                ++$foundList->undone;
                $foundList->save();
            }
        });

        static::deleted(function ($user) {
            if (!$user->complete) {
                $foundList = $user->getList;
                --$foundList->undone;
                $foundList->save();
            }
        });
    }
}
