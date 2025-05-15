<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Validator;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pages=Page::query();
        // search
        if($request->get('keyword')){
            $pages->where('Name','like','%'. $request->get('keyword').'%')
            ->orwhere("Slug",'like','%'.$request->get('keyword').'%');
        }
        // apply filters through selected list
        if($request->get('sort')){
            switch ($request->get('sort')) {
                case 'Latest':
                    $pages->orderBy('id', 'desc');
                    break;
                case 'Oldest':
                    $pages->orderBy('id', 'asc');
                    break;
                case 'asc':
                    $pages->orderBy('id', 'asc');
                    break;
                case 'desc':
                    $pages->orderBy('id', 'desc');
                    break;
            }
        }
        $pages=$pages->paginate(10);
        $data["pages"]=$pages;
        return view("AdminPages.Pages.LoadAllPages",$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("AdminPages.Pages.AddPages");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate=$request->validate([
            'name'=>['required','string','max:50'],
            'slug'=>['required','string','max:50','unique:pages,slug'],
            'description'=>['nullable'],
            'status'=>['boolean']
        ]);
        Page::create($validate);
        session()->flash('success','Successfully create page');
        return redirect()->back()->withInput();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $page=Page::find($id);
        $dataUpadate["page"]=$page;
        return view("AdminPages.Pages.UpdatePages",$dataUpadate);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules=[
            'name'=>['required','string','max:50'],
            'slug'=>['required','string','max:50'],
            'description'=>['nullable'],
            'status'=>['boolean']
        ];
        $messages=[];
        $attributes=[];
        $validate=Validator::make($request->all(),$rules,$messages,$attributes);
        if($validate->passes()){
            $page=Page::find($id);
            $page->update($validate->validate());
            return redirect()->back()->with("success","Successfully to update page");
        }
        // $errors=$validate->errors();
        return redirect()->back()->with("fail","Failed to update page")->withErrors($validate)->withInput();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Page::find($id)->delete();
        return redirect()->back()->with('success','Successfully delete the page');
    }
}
