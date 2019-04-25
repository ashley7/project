<?php

namespace App\Http\Controllers;

use App\PostCategory;
use Illuminate\Http\Request;
use Validator;

class PostCategoryController extends Controller
{
     
    public function __construct()
    {
        $this->middleware('permission:category-list');
        $this->middleware('permission:category-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:category-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:category-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['categories'] = PostCategory::all();
        return view('categories.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
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
            'name' => ['required', 'string', 'max:32'],
        ])->validate();
        $success = PostCategory::create([
            'name' => $request->name,
        ]);
        if ($success) {
            return redirect('news-categories')->with('success', 'record has been captured successfully');
        }
        return back()->with('error', 'Oops error has occurried please try again');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PostCategory  $postCategories
     * @return \Illuminate\Http\Response
     */
    public function show(PostCategory $postCategories)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PostCategory  $postCategories
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['category'] = PostCategory::findOrfail($id);
        return view('categories.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PostCategory  $postCategories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:32'],
        ])->validate();
        $success = PostCategory::where('id', $id)->update([
            'name' => $request->name,
        ]);
        if ($success) {
            return redirect('news-categories')->with('success', 'record has been updated successfully');
        }
        return back()->with('error', 'Oops error has occurried please try again');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PostCategory  $postCategories
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $success = PostCategory::where('id', $id)->delete();
        if ($success) {
            return redirect('news-categories')->with('success', 'record has been deleted successfully');
        }
        return back()->with('error', 'Oops error has occurried please try again');

    }
}
