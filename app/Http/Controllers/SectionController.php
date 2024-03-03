<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections= Section::all();
        return view('sections.sections', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData= $request->validate([
            'section_name'=>'required|unique:sections|max:255',
            'description'=>'required',

        ],[
            'section_name.required'=>'يرجى إدخال اسم القسم',
            'section_name.unique'=>'اسم القسم موجود مسبقاً',
            'description.required'=>'يرجى ادخال الوصف',
        ]);
        $input= $request->all();
        $b_exists= Section::where('section_name','=', ($input['section_name']))->exists();
        if($b_exists){
            session()->flash('error', 'القسم موجود مسبقاً');
            return redirect('/sections');
        }else{
            Section::create([
                'section_name'=>$request->section_name,
                'description'=>$request->description,
                'created_by'=> (Auth::user()->name)

            ]);
            session()->flash('add','تم إضافة القسم بنجاح');
            return redirect('/sections');


        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
       $id= $request->id;
       $this->validate($request,[
        'section_name'=>'required|max:255|unique:sections,section_name,'.$id,
        'description'=>'required',
       ],[
        'section_name.required'=>'يرجى إدخال اسم القسم',
        'section_name.unique'=>'اسم القسم موجود مسبقاً',
        'description'=>'يرجى ادخل وصف القسم'

       ]);
       $sections=Section::findOrFail($id);
       $sections->update([
        'section_name'=> $request->section_name,
        'description'=>$request->description
       ]);

       session()->flash('edit', 'تم تعديل القسم بنجاح');
       return redirect('/sections');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id= $request->id;
        Section:: find($id)->delete();
        session()->flash('delete', 'تم حذف القسم بنجاح');
        return redirect('/sections');



    }
}
