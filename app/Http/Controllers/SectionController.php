<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Section::all();
        return view('sections.sections')->with(['sections'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'section_name'=>'required|string|unique:sections,section_name',
            'section_notes'=>'required|max:200'
        ]);
       
            Section::create([
                'section_name'=>$request->section_name,
                'description'=>$request->section_notes,
                'created_by'=>Auth::user()->name
            ]);
            session()->flash('section_add_success',"Section added successfully");
            return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $section = Section::findOrFail($id);
        $data = $request->validate([
         'section_name_update'=>'required|unique:sections,section_name,'.$section->id,
         'section_notes_update'=>'string|max:200'
        ]);
        $section->update(['section_name'=>$request->section_name_update,
        'description'=>$request->section_notes_update]);
 
                          
                          
     session()->flash('section_update_success',"Section Updated successfully");
 
     return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {
        //
    }
    public function delete($id){
        $section = Section::findOrFail($id);
        $section->delete();
        session()->flash('section_delete_success',"Section Deleted successfully");
        return redirect()->back();
    }
}
