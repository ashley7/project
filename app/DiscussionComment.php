<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiscussionComment extends Model
{
  protected $fillable=['discussion_id','parent_id','description','user_id'];
}
