<?php

namespace App\Http\Controllers;

use App\Country;
use App\Notifications\SendNotification;
use App\Publication;
use App\PublicationDownload;
use App\Visitor;
use Auth;
use Illuminate\Http\Request;
use Response;
use Validator;
use App\User;

class PublicationController extends Controller
{

    public function __construct()
    {
        // $this->middleware('permission:publication-list');
        $this->middleware('permission:publication-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:publication-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:publication-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['publications'] = Publication::where('status','Published')->orderby('created_at', 'desc')->paginate(5);
        return view('frontend.publication.index')->with($data);
    }

    public function download($id)
    {
        $data = Publication::where('id', $id)->first();
        PublicationDownload::createViewLog($data);
    }

    public function file_download($slug)
    {
        $data = Publication::where('slug', $slug)->first();

        $destinationPath = public_path() . '/uploads/publications/' . $data->attachment;
        //now insert the download
        PublicationDownload::createViewLog($data);
        return Response::download($destinationPath);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['countries'] = Country::all();
        return view('frontend.publication.create')->with($data);
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
            'publication_type' => ['required', 'string'],
            'country' => ['required'],
            'file' => ['required', 'mimes:doc,pdf,docx,ppt'],
        ])->validate();

        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move('uploads/publications', $filename);

        $success = Publication::create([
            'title' => $request->title,
            'description' => $request->description,
            'attachment' => $filename,
            'publication_type' => $request->publication_type,
            'country_id' => $request->country,
            'user_id' => Auth::User()->id,
        ]);

        //get user
        $user = User::findOrfail(Auth::User()->id);
        //send notificaton
        $user->notify(new SendNotification($user, "ICWEA Notification", "Thank you for submitting a publication on the ICWEA Connect platform. Our moderator will review your post and if it satisfies our editorial and community policy, it should be published on this platform in 24hours. You will get an email notification once this is done. If you have any questions, please contact the moderator on connect@icwea.org"));
        if ($success) {
            return redirect('publications')->with('success', 'record has been captured successfully');
        }
        return back()->with('error', 'Oops error has occurried please try again');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $publication = Publication::where('slug', $slug)->first();
        $data['publication'] = $publication;
        Visitor::createViewLog($publication, 'publication');
        $data['related'] = Publication::where('publication_type', $publication->publication_type)
            ->where('id', '!=', $publication->id)->limit(5)->get();
        return view('frontend.publication.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['publication'] = Publication::findOrfail($id);
        return view('frontend.publication.edit')->with($data);
    }

    public function dash_edit($id)
    {
        $data['publication'] = Publication::findOrfail($id);
        return view('publications.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'publication_type' => ['required', 'string'],
        ])->validate();

        $file = $request->file('file');
        if ($file != null) {
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move('uploads/publications', $filename);
        } else {
            $file_name = Publication::findOrfail($id);
            $filename = $file_name->attachment;
        }

        $success = Publication::where('id', $id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'attachment' => $filename,
            'publication_type' => $request->publication_type,
        ]);
        if ($success) {
            return redirect('publications')->with('success', 'record has been updated successfully');
        }
        return back()->with('error', 'Oops error has occurried please try again');

    }
    public function dash_update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'publication_type' => ['required', 'string'],
        ])->validate();

        $success = Publication::where('id', $id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'status'=>$request->status,
            'publication_type' => $request->publication_type,
        ]);

        $publication = Publication::findOrfail($id);
        //get user
        $user = User::findOrfail($publication->user_id);
        //send notificaton
        $user->notify(new SendNotification($user, "ICWEA Notification", "Your publication " . $publication->title."  has been ". $request->status . ". If you have any questions, please contact the moderator on connect@icwea.org "));

        if ($success) {
            return redirect('dash-publications')->with('success', 'record has been updated successfully');
        }
        return back()->with('error', 'Oops error has occurried please try again');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $success = Publication::where('id', $id)->delete();
        if ($success) {
            return redirect('publications')->with('success', 'record has been deleted successfully');
        }
        return back()->with('error', 'Oops error has occurried please try again');

    }

    public function dash_delete($id)
    {
        $success = Publication::where('id', $id)->delete();
        if ($success) {
            return redirect('dash-publications')->with('success', 'record has been deleted successfully');
        }
        return back()->with('error', 'Oops error has occurried please try again');

    }

    public function dash_publications()
    {
        $data['publications'] = Publication::all();
        return view('publications.index')->with($data);
    }
}
