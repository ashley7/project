<?php
namespace App\Helpers;

class AppHelper
{


    // most highly viewed blog
    public function popular_blogs(){
        $popular_blogs = \DB::table('visitors')
        ->select('blogs.*','surname','othername', \DB::raw('count(visitors.id) as total'))
        ->join('blogs', 'visitors.id_post', '=', 'blogs.id')
        ->join('users', 'blogs.user_id', '=', 'users.id')
        ->where('category', '=', 'blog')
        ->where('blog_status', '=', 'Published')
        ->groupBy('id_post')
        ->orderBy('total', 'desc')
        ->limit(2)
        ->get();
        return $popular_blogs;
    }

    //blog comments

    public function blog_comments($blog)
    {
        $parent_cmts = \DB::table('blog_comments')
            ->select(\DB::raw('blog_comments.*,users.surname,users.othername'))
            ->join('users', 'blog_comments.user_id', '=', 'users.id')
            ->where('blog_comments.blog_id', $blog)->get();
        return $parent_cmts;
    }

    //view count

    public function view_count($id, $category)
    {
        $parent_cmts = \DB::table('visitors')
            ->select(\DB::raw('COUNT(id) as total_views'))
            ->where("id_post", "=", $id)
            ->where('category', $category)
            ->groupBy("id_post")
            ->first();
        return $parent_cmts;
    }

    // Posts::join("posts_views", "posts_views.id_post", "=", "posts.id")
    //         ->where("created_at", ">=", date("Y-m-d H:i:s", strtotime('-24 hours', time())))
    //         ->groupBy("posts.id")
    //         ->orderBy(DB::raw('COUNT(posts.id)', 'desc'))
    //         ->get(array(DB::raw('COUNT(posts.id) as total_views'), 'posts.*'));
    public function related_news_feed($category_id, $feed_id)
    {
        $related_feed = \DB::table('news_posts')
            ->select(\DB::raw('*'))
            ->where('category_id', $category_id)
            ->where('id', '!=', $feed_id)
            ->limit(10)
            ->get();
        return $related_feed;
    }

    public function discussion_cts_count($discussion_id)
    {
        $parent_cmts = \DB::table('discussion_comments')
            ->select(\DB::raw('*'))
            ->where('discussion_id', $discussion_id)->count();
        return $parent_cmts;

    }

    //discussion parent comments
    public function parent_comments($id)
    {
        $parent_cmts = \DB::table('discussion_comments')
            ->select(\DB::raw('discussion_comments.*,users.surname,users.othername'))
            ->join('users', 'discussion_comments.user_id', '=', 'users.id')
            ->where('discussion_comments.discussion_id',$id)
            ->where('discussion_comments.parent_id', null)
            ->orderby('id','desc')
            ->paginate(5);
        return $parent_cmts;

    }
    public function child_comments($parent_id)
    {
        $parent_cmts = \DB::table('discussion_comments')
            ->select(\DB::raw('discussion_comments.*,users.surname,users.othername'))
            ->join('users', 'discussion_comments.user_id', '=', 'users.id')
            ->where('discussion_comments.parent_id', $parent_id)->get();
        return $parent_cmts;

    }
    public function countries()
    {
        $data = \DB::table('countries')
            ->select(\DB::raw('*'))
            ->get();
        return $data;
    }

    public static function instance()
    {
        return new AppHelper();
    }

}
