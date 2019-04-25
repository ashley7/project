<?php

namespace App\Http\Controllers;

use App\Country;
use App\Discussion;
use App\DiscussionComment;
use App\Notifications\SendNotification;
use App\User;
use App\Visitor;
use Auth;
use DB;
use Illuminate\Http\Request;
use Validator;

class DiscussionController extends Controller
{

    public function __construct()
    {
        // $this->middleware('permission:discussion-list');
        $this->middleware('permission:discussion-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:discussion-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:discussion-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['discussion'] = Discussion::where('status', 'Published')->orderby('created_at', 'desc')->paginate(5);
        return view('frontend.discussion.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['countries'] = Country::all();
        return view('frontend.discussion.create')->with($data);
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
            'country' => ['required'],
        ])->validate();

        $success = Discussion::create([
            'topic' => $request->title,
            'description' => $request->description,
            'country_id' => $request->country,
            'user_id' => Auth::User()->id,
        ]);

        //get user
        $user = User::findOrfail(Auth::User()->id);
        //send notificaton
        $user->notify(new SendNotification($user, "ICWEA Notification", "Thank you for submitting a discussion topic on the ICWEA Connect platform. Our moderator will review your post and if it satisfies our editorial and community policy, it should be published on this platform in 24hours. You will get an email notification once this is done. If you have any questions, please contact the moderator on connect@icwea.org"));
        if ($success) {
            return redirect('discussion')->with('success', 'record has been captured successfully');
        }
        return back()->with('error', 'Oops error has occurried please try again');
    }

    //comment on the discussion
    public function parent_comment(Request $request)
    {
        Validator::make($request->all(), [
            'comment' => ['required', 'string'],
            'discussion_id' => ['required', 'string'],
        ])->validate();

        $success = DiscussionComment::create([
            'description' => $request->comment,
            'discussion_id' => $request->discussion_id,
            'user_id' => Auth::User()->id,
        ]);
        //get the discussion
        $discussion = Discussion::findOrfail($request->discussion_id);
        //send and email to the discussion owner
        $user= User::findOrfail($discussion->user_id);

        $user = User::findOrfail(Auth::User()->id);
        //send notificaton
        $user->notify(new SendNotification($user, "ICWEA Discussion topic " . $discussion->topic, " Here is the new reply on your dicussion topic ".$request->comment));

        if ($success) {
            return response()->json(['data' => $success, 'message' => 'comment has been sent successfully', 'status' => true]);
        }
        return response()->json(['message' => 'Oops error has occurried please try again', 'status' => false]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Discussion  $discussion
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $discussion = Discussion::where('slug', $slug)->first();
        Visitor::createViewLog($discussion, 'discussion');
        //comment counts
        $data['comment_count'] = DiscussionComment::where('discussion_id', $discussion->id)->count();
        $data['discussion'] = $discussion;
        $data['highly_related_discussion'] = DB::table('visitors')
            ->select('discussions.*', 'surname', 'othername', DB::raw('count(visitors.id) as total'))
            ->join('discussions', 'visitors.id_post', '=', 'discussions.id')
            ->join('users', 'discussions.user_id', '=', 'users.id')
            ->where('category', '=', 'discussion')
            ->groupBy('id_post')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();
        return view('frontend.discussion.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Discussion  $discussion
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['discussion'] = Discussion::findOrfail($id);
        return view('frontend.discussion.edit')->with($data);
    }
    public function dash_edit($id)
    {
        $data['discussion'] = Discussion::findOrfail($id);
        return view('discussions.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Discussion  $discussion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
        ])->validate();

        $success = Discussion::where('id', $id)->update([
            'topic' => $request->title,
            'description' => $request->description,
        ]);
        if ($success) {
            return redirect('discussion')->with('success', 'record has been upadated successfully');
        }
        return back()->with('error', 'Oops error has occurried please try again');

    }
    public function dash_update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
        ])->validate();

        $success = Discussion::where('id', $id)->update([
            'topic' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
        ]);
        $discussion = Discussion::findOrfail($id);
        //get user
        $user = User::findOrfail($discussion->user_id);
        //send notificaton
        $user->notify(new SendNotification($user, "ICWEA Notification", "Your Discussion topic " . $discussion->topic . "  has been " . $request->status . ". If you have any questions, please contact the moderator on connect@icwea.org "));

        if ($success) {
            return redirect('dash-discussion')->with('success', 'record has been upadated successfully');
        }
        return back()->with('error', 'Oops error has occurried please try again');
        //may
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Discussion  $discussion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $success = Discussion::where('id', $id)->delete();
        if ($success) {
            return redirect('discussion')->with('success', 'record has been deleted successfully');
        }
        return back()->with('error', 'Oops error has occurried please try again');

    }
    public function dash_delete($id)
    {
        $success = Discussion::where('id', $id)->delete();
        if ($success) {
            return redirect('dash-discussion')->with('success', 'record has been deleted successfully');
        }
        return back()->with('error', 'Oops error has occurried please try again');

    }

    public function dash_discussions()
    {
        $data['discussions'] = Discussion::all();
        return view('discussions.index')->with($data);
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
}
