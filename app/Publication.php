<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Publication extends Model
{
    use SoftDeletes, Sluggable;

    protected $fillable = ['title', 'description', 'attachment', 'publication_type', 'user_id', 'country_id','status'];

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

    public function downloads_count()
    {
        return $this->hasMany('App\PublicationDownload', 'id_post')->count();
    }
}
