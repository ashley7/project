<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PublicationDownload extends Model
{
    protected $fillable = ['id_post', 'slug', 'session_id', 'ip', 'agent'];

    public static function createViewLog($post)
    {
        if (self::userIPAdress($post->id)) {

            $postsViews = new PublicationDownload();
            $postsViews->id_post = $post->id;
            $postsViews->slug = $post->slug;
            $postsViews->session_id = \Request::getSession()->getId();
            $postsViews->ip = \Request::getClientIp();
            $postsViews->agent = \Request::header('User-Agent');
            $postsViews->save();
        }
    }

    //check if the user has never downloaded the document

    public static function userIPAdress($id)
    {
        $result = PublicationDownload::where('ip', '=', \Request::getClientIp())->where('id_post', '=', $id)->count();
        if ($result <= 0) {
            return true;
        }
        return false;
    }
}
