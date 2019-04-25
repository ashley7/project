<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Discussion;
use App\NewsPost;
use App\Publication;
use App\User;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('permission:dashboard-index');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['blogs_count'] = Blog::count();
        $data['discussions_count'] = Discussion::count();
        $data['publications_count'] = Publication::count();
        $data['news_count'] = NewsPost::count();

        //activity logs

        $data['blogs_log'] = DB::table('laravel_logger_activity')->where('description', 'viewed blog')->count();

        $data['news_log'] = DB::table('laravel_logger_activity')->where('description', 'viewed news')->count();

        $data['discussion_log'] = DB::table('laravel_logger_activity')->where('description', 'viewed discussions')->count();

        $data['publications_log'] = DB::table('laravel_logger_activity')->where('description', 'viewed publications')->count();
        $data['recent_registrations'] = User::OrderBy('created_at', 'desc')->limit(5)->get();
        $data['users_count'] = User::count();

        //blogs category performance

        //   $data['blogs_permance']=
        $test = DB::table('blogs')->select(DB::raw('count(*) as user_count, name'))->join('post_categories', 'post_categories.id', '=', 'blogs.category_id')
        ->groupBy('category_id')->get();
        //  foreach ($variable as $key => $value) {
        //      # code...
        //  }
        //   return $test;

        return view('home')->with($data);
    }
}
