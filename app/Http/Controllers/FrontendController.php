<?php

namespace App\Http\Controllers;

use App\Blog;
use App\NewsPost;
use App\Page;
use DB;
use Illuminate\Http\Request;
use Newsletter;
use Validator;

class FrontendController extends Controller
{

    public function subscribe(Request $request)
    {
        Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
        ])->validate();
        $success = Newsletter::subscribe($request->email);
        if ($success) {
            return response()->json(['message' => 'You have subscribed succefully', 'status' => true]);
        }
        return response()->json(['message' => 'Oops an error has occurried', 'status' => false]);
    }
    public function index()
    {
        $data['news_categories'] = DB::table('post_categories')
            ->select('post_categories.*', DB::raw('count(post_categories.id) as total'))
            ->join('news_posts', 'news_posts.category_id', '=', 'post_categories.id')
            ->groupBy('category_id')
            ->orderBy('total', 'desc')
            ->limit(4)
            ->get();

        //highly viewed discussions

        $data['highly_related_discussion'] = DB::table('visitors')
            ->select('discussions.*', 'surname', 'othername', DB::raw('count(visitors.id) as total'))
            ->join('discussions', 'visitors.id_post', '=', 'discussions.id')
            ->join('users', 'discussions.user_id', '=', 'users.id')
            ->where('category', '=', 'discussion')
            ->where('status', '=', 'Published')
            ->groupBy('id_post')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();
        $data['page'] = Page::where('position', 'show')->orderBy('created_at', 'desc')->limit(1)->first();
        $data['featured_blog'] = Blog::where('featured', 'yes')->where('blog_status', 'Published')->orderby('created_at', 'desc')->limit(1)->first();
        //featured news
        $data['featured_news'] = NewsPost::where('featured', 'yes')->orderby('created_at', 'desc')->limit(3)->get();
        //latest news
        $data['latest_news'] = NewsPost::orderby('created_at', 'desc')->limit(4)->get();
        return view('welcome')->with($data);
    }

    public function search(Request $request)
    {

        $search_result = DB::table('search_keys_table')->where('key_word', 'like', '%' . $request->search_key . '%')->get();
        return view('content_search', compact('search_result'));
    }
}
