<?php

namespace App\Http\Controllers;

use App\Country;
use Illuminate\Http\Request;
use Validator;

use Spatie\Permission\Models\Permission;

class CountryController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:country-list');
        $this->middleware('permission:country-create', ['only' => ['create','store']]);
        $this->middleware('permission:country-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:country-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['countries'] = Country::all();
        return view('countries.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('countries.create');
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
        $success = Country::create([
            'name' => $request->name,
        ]);
        if ($success) {
            return redirect('countries')->with('success', 'record has been captured successfully');
        }
        return back()->with('error', 'Oops error has occurried please try again');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['country'] = Country::findOrfail($id);
        return view('countries.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:32'],
        ])->validate();
        $success = Country::where('id', $id)->update([
            'name' => $request->name,
        ]);
        if ($success) {
            return redirect('countries')->with('success', 'record has been updated successfully');
        }
        return back()->with('error', 'Oops error has occurried please try again');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $success = Country::where('id', $id)->delete();
        if ($success) {
            return redirect('countries')->with('success', 'record has been deleted successfully');
        }
        return back()->with('error', 'Oops error has occurried please try again');

    }
}
