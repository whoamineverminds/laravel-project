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

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            if (!$model->complete) {
                $model->getList->increment('undone');
            }
        });
    }
}
