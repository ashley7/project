<?php

namespace App\Http\Controllers;

use App\NewsPost;
use App\PostCategory;
use App\Visitor;
use Auth;
use DB;
use Illuminate\Http\Request;
use Validator;

class NewsPostController extends Controller
{

    public function __construct()
    {
        // $this->middleware('permission:news-list');
        $this->middleware('permission:news-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:news-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:news-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['popular_viewed'] = DB::table('visitors')
            ->select('news_posts.*', 'surname', 'othername', \DB::raw('count(visitors.id) as total'))
            ->join('news_posts', 'visitors.id_post', '=', 'news_posts.id')
            ->join('users', 'news_posts.user_id', '=', 'users.id')
            ->where('category', '=', 'news')
            ->groupBy('id_post')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();
        $data['news'] = NewsPost::orderby('created_at', 'desc')->paginate(5);
        // $data['popular_viewed'] = NewsPost::get()->sortByDesc('post_views')->take(4);
        return view('frontend.news_feed.index')->with($data);
    }

    public function filterByCategory($id)
    {
        $data['popular_viewed'] = DB::table('visitors')
            ->select('news_posts.*', 'surname', 'othername', \DB::raw('count(visitors.id) as total'))
            ->join('news_posts', 'visitors.id_post', '=', 'news_posts.id')
            ->join('users', 'news_posts.user_id', '=', 'users.id')
            ->where('category', '=', 'news')
            ->groupBy('id_post')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();
        $data['news'] = NewsPost::where('category_id', $id)->orderby('created_at', 'desc')->paginate(5);
        return view('frontend.news_feed.index')->with($data);
    }

    public function dashboard()
    {
        $data['news'] = NewsPost::orderby('id', 'desc')->get();
        return view('news_feed.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['categories'] = PostCategory::all();
        return view('news_feed.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category' => ['required', 'string'],
            'file' => ['required', 'mimes:jpeg,bmp,png,jpg'],
        ])->validate();

        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move('uploads/news', $filename);

        $success = NewsPost::create([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category,
            'attachment' => $filename,
            'featured' => 'yes',
            'user_id' => Auth::User()->id,
        ]);
        if ($success) {
            return redirect('news-dashboard')->with('success', 'record has been captured successfully');
        }
        return back()->with('error', 'Oops error has occurried please try again');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\NewsPost  $newsPost
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $data['popular_viewed'] = DB::table('visitors')
            ->select('news_posts.*', 'surname', 'othername', \DB::raw('count(visitors.id) as total'))
            ->join('news_posts', 'visitors.id_post', '=', 'news_posts.id')
            ->join('users', 'news_posts.user_id', '=', 'users.id')
            ->where('category', '=', 'news')
            ->groupBy('id_post')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();
        $NewsPost = NewsPost::where('slug', $slug)->first();
        Visitor::createViewLog($NewsPost, 'news');
        $data['news_post'] = $NewsPost;
        return view('frontend.news_feed.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\NewsPost  $newsPost
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['categories'] = PostCategory::all();
        $data['news_feed'] = NewsPost::findOrfail($id);
        return view('news_feed.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\NewsPost  $newsPost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category' => ['required', 'string'],
        ])->validate();

        $file = $request->file('file');
        if ($file != null) {
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move('uploads/news', $filename);
        } else {
            $file_name = NewsPost::findOrfail($id);
            $filename = $file_name->attachment;
        }

        $success = NewsPost::where('id', $id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'attachment' => $filename,
            'category_id' => $request->category,
            'featured' => $request->featured,
        ]);
        if ($success) {
            return redirect('news-dashboard')->with('success', 'record has been updated successfully');
        }
        return back()->with('error', 'Oops error has occurried please try again');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\NewsPost  $newsPost
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $success = NewsPost::where('id', $id)->delete();
        if ($success) {
            return redirect('news-dashboard')->with('success', 'record has been deleted successfully');
        }
        return back()->with('error', 'Oops error has occurried please try again');

    }
}
