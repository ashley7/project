<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use Sluggable, SoftDeletes,Notifiable;
    protected $fillable = ['title', 'description', 'attachment', 'category_id','country_id','featured', 'user_id','blog_status'];
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function category()
    {
        return $this->belongsTo('App\PostCategory');
    }
}
