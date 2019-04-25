<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discussion extends Model {

	use Sluggable, SoftDeletes;
	protected $fillable = ['topic', 'description', 'country_id', 'user_id', 'status'];

	public function sluggable() {
		return [
			'slug' => [
				'source' => 'topic',
			],
		];
	}
	public function user() {
		return $this->belongsTo('App\User');
	}

	public function comments() {
		return $this->hasMany('App\DiscussionComment');
	}

	// public function visits()
	// {
	//     return blog_views('App\Post')->count();
	// }

}
