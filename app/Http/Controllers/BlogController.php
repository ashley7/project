<?php

namespace App\Http\Controllers;

use App\Blog;
use App\BlogComment;
use App\Country;
use App\Notifications\SendNotification;
use App\Notifications\UserRegisteredSuccessfully;
use App\PostCategory;
use App\User;
use App\Visitor;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class BlogController extends Controller
{

    public function __construct()
    {
        // $this->middleware('permission:blog-list');
        $this->middleware('permission:blog-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:blog-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:blog-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['popular_blogs'] = DB::table('visitors')
            ->select('blogs.*', 'surname', 'othername', \DB::raw('count(visitors.id) as total'))
            ->join('blogs', 'visitors.id_post', '=', 'blogs.id')
            ->join('users', 'blogs.user_id', '=', 'users.id')
            ->where('category', '=', 'blog')
            ->groupBy('id_post')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();
        $data['blogs'] = Blog::where('blog_status', 'Published')->Orderby('id', 'desc')->paginate(5);
        return view('frontend.blog.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['countries'] = Country::all();
        $data['categories'] = PostCategory::all();
        return view('frontend.blog.create')->with($data);
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
            'description' => ['required', 'string', 'max:1000'],
            'category' => ['required'],
            'country' => ['required'],
            'image' => ['required', 'mimes:jpeg,bmp,png,jpg'],
        ])->validate();

        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move('uploads/blog', $filename);

        $success = Blog::create([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category,
            'country_id' => $request->country,
            'attachment' => $filename,
            'featured' => 'yes',
            'user_id' => Auth::User()->id,
        ]);

        //get user
        $user = User::findOrfail(Auth::User()->id);
        //send notificaton
        $user->notify(new SendNotification($user, "ICWEA Notification", "Thank you for submitting a Blog on the ICWEA Connect platform. Our moderator will review your post and if it satisfies our editorial and community policy, it should be published on this platform in 24hours. You will get an email notification once this is done. If you have any questions, please contact the moderator on connect@icwea.org"));
        //ANY command denied to user '
        if ($success) {
            return redirect('blog')->with('success', 'record has been captured successfully');
        }
        return back()->with('error', 'Oops error has occurried please try again');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {

        $blog = Blog::where('slug', $slug)->first();
        $data['blog'] = $blog;
        Visitor::createViewLog($blog, 'blog');
        $data['comment_count'] = BlogComment::where('blog_id', $blog->id)->count();
        //comment counts
        // $data['comment_count'] = DiscussionComment::where('blog_id', $id)->count();
        $data['popular_blogs'] = Blog::where('blog_status', 'Published')->get()->sortByDesc('blog_views')->take(4);
        return view('frontend.blog.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['categories'] = PostCategory::all();
        $data['blog'] = Blog::findOrfail($id);
        return view('frontend.blog.edit')->with($data);
    }
    public function dash_edit($id)
    {
        $data['categories'] = PostCategory::all();
        $data['blog'] = Blog::findOrfail($id);
        return view('blogs.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
            'category' => ['required'],
        ])->validate();

        $file = $request->file('image');
        if ($file != null) {
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move('uploads/blog', $filename);
        } else {
            $blog = Blog::findOrfail($id);
            $filename = $blog->attachment;
        }

        $success = Blog::where('id', $id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category,
            'attachment' => $filename,
        ]);
        if ($success) {
            return redirect('blog')->with('success', 'record has been updated successfully');
        }
        return back()->with('error', 'Oops error has occurried please try again');

    }

    public function dash_update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
            'category' => ['required'],
        ])->validate();

        $file = $request->file('image');
        if ($file != null) {
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move('uploads/blog', $filename);
        } else {
            $blog = Blog::findOrfail($id);
            $filename = $blog->attachment;
        }

        $success = Blog::where('id', $id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category,
            'attachment' => $filename,
            'featured' => $request->featured,
            'blog_status' => $request->status,
        ]);
        $blog = Blog::findOrfail($id);
        //get user
        $user = User::findOrfail($blog->user_id);
        //send notificaton
        $user->notify(new SendNotification($user, "ICWEA Notification", "Your Blog post " . $blog->title."  has been ". $request->status . ". If you have any questions, please contact the moderator on connect@icwea.org "));

        if ($success) {
            return redirect('blogs')->with('success', 'record has been updated successfully');
        }
        return back()->with('error', 'Oops error has occurried please try again');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $success = Blog::where('id', $id)->delete();
        if ($success) {
            return redirect('blog')->with('success', 'record has been deleted successfully');
        }
        return back()->with('error', 'Oops error has occurried please try again');

    }

    public function dash_delete($id)
    {
        $success = Blog::where('id', $id)->delete();
        if ($success) {
            return redirect('blogs')->with('success', 'record has been deleted successfully');
        }
        return back()->with('error', 'Oops error has occurried please try again');

    }
    public function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function comment(Request $request)
    {

        Validator::make($request->all(), [
            'comment' => ['required', 'string'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ])->validate();
        //check if the user exists
        $user = User::where('email', $request->email)->first();
        if ($user == null) {
            //create account
            $name = explode(" ", $request->name);

            $password = $this->generateRandomString(7);
            $user = User::create([
                'surname' => $name[0],
                'othername' => $name[1],
                'email' => $request->email,
                'password' => Hash::make($password),
            ]);
            //send account creation email
            $user->notify(new UserRegisteredSuccessfully($user));
        }

        //  now insert the comment
        BlogComment::create([
            'description' => $request->comment,
            'blog_id' => $request->blog_id,
            'user_id' => $user->id,
        ]);
        return redirect('blog/' . $request->slug)->with('success', 'record has been captured successfully');

    }

    public function dash_blogs()
    {
        $data['blogs'] = Blog::all();
        return view('blogs.index')->with($data);
    }

}
