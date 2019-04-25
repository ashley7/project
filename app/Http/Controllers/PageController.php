<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;
use Validator;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['pages'] = Page::all();
        return view('pages.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.create');
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
        ])->validate();

        $success = Page::create([
            'title' => $request->title,
            'description' => $request->description,
            'position' => $request->featured,
        ]);
        if ($success) {
            return redirect()->route('pages.index')->with('success', 'record has been upadated successfully');
        }
        return back()->with('error', 'Oops error has occurried please try again');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        $data['page'] = Page::where('id', $page->id)->first();
        return view('pages.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
        ])->validate();

        $success = Page::where('id',$page->id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'position' => $request->featured,
        ]);
        if ($success) {
            return redirect()->route('pages.index')->with('success', 'record has been Updated successfully');
        }
        return back()->with('error', 'Oops error has occurried please try again');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        $success = Page::where('id', $page->id)->delete();
        if ($success) {
            return redirect()->route('pages.index')->with('success', 'record has been deleted successfully');
        }
        return back()->with('error', 'Oops error has occurried please try again');

    }
}
