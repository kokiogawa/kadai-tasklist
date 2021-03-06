<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Tasklist; // 追加


class TasklistsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Auth::check()) {
    $tasklists = \Auth::user()->tasklists;
    return view('tasklists.index',[
        'tasklists' => $tasklists,
        
        ]);
    
    }else{
        return view('welcome');
 
}

}
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
 {
 $tasklist = new Tasklist;
 return view('tasklists.create', [
 'tasklist' => $tasklist,
 ]);
 }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
 {
     
     $this->validate($request, [
 'status' => 'required|max:10', // 追加
 'content' => 'required|max:191',
    ]);
 $tasklist = new Tasklist;
 $tasklist ->status = $request -> status;
 $tasklist ->content = $request -> content;
 $tasklist ->user_id = \Auth::user()->id;
 $tasklist ->save();
 
 return redirect('/');
 }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
 {
 $tasklist = Tasklist::find($id);
 if($tasklist->user_id == \Auth::user()->id){
     return view('tasklists.show',[
         'tasklist' => $tasklist,
         ]);
 }else{
     return redirect('/');
 }
 

 }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
 {
 $tasklist = Tasklist::find($id);
 if($tasklist->user_id == \Auth::user()->id){
     return view('tasklists.edit',[
         'tasklist' => $tasklist,
         ]);
 }else{
     return redirect('/');
 }
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
     
      $this->validate($request, [
          'status' => 'required|max:10', // 追加
          'content' => 'required|max:191',
 ]);
     
 $tasklist = Tasklist::find($id);
 $tasklist->status = $request->status; // 追加
 $tasklist->content = $request->content;
 $tasklist->save();
 return redirect('/');
 }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
 {
     $tasklist = Tasklist::find($id);
     $tasklist ->delete();
 
 return redirect('/');
 }



}
