<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = ['id_post', 'titleslug', 'category', 'url', 'session_id', 'ip', 'agent'];

    public static function createViewLog($post, $category)
    {

        if (self::userIPAdress($post->id, $category)) {
            $postsViews = new Visitor();

            $postsViews->id_post = $post->id;
            $postsViews->titleslug = $post->slug;
            $postsViews->category = $category;
            $postsViews->url = \Request::url();
            $postsViews->session_id = \Request::getSession()->getId();
            $postsViews->ip = \Request::getClientIp();
            $postsViews->agent = \Request::header('User-Agent');
            $postsViews->save();
        }
    }

    public static function userIPAdress($id, $category)
    {
        $result = Visitor::where('ip', '=', \Request::getClientIp())->where('id_post', '=', $id)->where('category', '=', $category)->count();
        if ($result <= 0) {
            return true;
        }
        return false;
    }
}
