<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = DB::table('sections')->select('*')->get();
        return view('sections.sections' , compact('sections'));
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
        $request->validate([
            'section_name' =>  'required|max:50|unique:sections,section_name',
            'description' =>  'required',
        ],[
            'section_name.required' => 'يرجى ادخال اسم القسم',
            'section_name.max' => 'يرجى ادخال اسم القسم بحد اقصى 50 حرف',
            'section_name.unique' => 'اسم القسم مسجل سابقا   ',
            'description.required' => 'يرجى ادخال  وصف المنتج'
        ]);
        Sections::create([
            'section_name' =>  $request->section_name,
            'description' =>  $request->description,
            'created_by' => (Auth::user()->name),
        ]);
        session()->flash('add' , "تم اضافة القسم بنجاح");
        return redirect('/sections');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function show(sections $sections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function edit(sections $sections)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * * @param  \Illuminate\Http\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $request->validate([
            'section_name' =>  'required|max:50|unique:sections,section_name,'.$id,
            'description' =>  'required',
        ],[
            'section_name.required' => 'يرجى ادخال اسم القسم',
            'section_name.max' => 'يرجى ادخال اسم القسم بحد اقصى 50 حرف',
            'section_name.unique' => 'اسم القسم مسجل سابقا   ',
            'description.required' => 'يرجى ادخال  وصف المنتج'
        ]);
        $sections = Sections::find($id);
        $sections->update([
            'section_name' =>  $request->section_name,
            'description' =>  $request->description,
        ]);
        session()->flash('edit',"تم تعديل القسم بنجاح");
        return redirect("/sections");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $sections = Sections::find($id)->delete();
        session()->flash('delete' , 'تم حذف القسم بنجاح');
        return redirect("/sections");
    }
}
