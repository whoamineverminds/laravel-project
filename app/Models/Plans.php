<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plans extends Model
{
    use HasFactory;
    const CREATED_AT = 'date_create';
    const UPDATED_AT = 'date_change';
    protected $fillable = ['title', 'description', 'priority', 'complete'];

    public function getList()
    {
        return $this->belongsTo('App\Models\Lists', 'list_id');
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
