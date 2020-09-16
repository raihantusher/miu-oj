<?php

namespace App\Http\Controllers;

use App\Set;
use App\Question;
use App\Answer;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class SetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('set.index')->with("sets", Set::where("user_id", Auth::id())->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view("set.add");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validatedData = Validator::make($request->all(), [
            'name'                     => 'required',
            'number_of_question'       => 'required',
            'uuid'                     => 'required | unique:sets',
            'expire_after'             => 'required',
            'judge_by'                 => 'required'
        ]);
        
        if ($validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData)->withInput();
        }
        $set                  = new Set;
        $set->name            = $request->name;
        $set->n_o_q           = $request->number_of_question;
        $set->uuid            = $request->uuid;
        $set->expire_after    = $request->expire_after;
        $set->judge_by        = $request->judge_by;

        $set->user_id = Auth::id();
        $set->save();

        $request->session()->flash("success" , "New set has been created!!");
        return redirect("/set");
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
        $qs = Question::where("set_id", $id)->get();
        return view('set.question')->with('questions',$qs)->with("set_id",$id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
       

        $set = Set::find($id);
        
        return view('set.add')->with('set' ,$set);
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
        //
        //
        $validatedData = Validator::make($request->all(), [
            'name'         => 'required',
            'number_of_question'        => 'required',
            'uuid'         => 'required | unique:sets',
            'expire_after' => 'required',
            'judge_by'     => 'required'
        ]);
        
        if ($validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData)->withInput();
        }

        $set                  = Set::find($id);
        $set->name            = $request->name;
        $set->n_o_q           = $request->number_of_question;
        $set->uuid            = $request->uuid;
        $set->expire_after    = $request->expire_after;
        $set->judge_by        = $request->judge_by;

        $set->user_id = Auth::id();
        $set->save();

        $request->session()->flash("success" , "Set has been updated!!");
        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function launch($id){

        $now=Carbon::now();

        $set             = Set::find($id);
        $set->created_at = $now;

        //remove user joined
        $set->users()->detach();
        $set->save();

        //soft delete answer
        $answers         = Answer::find($id);
        
        if($answers)
            $answers->delete();

        request()->session()->flash("success" , "Set has been relaunched !!");
        return redirect()->back();
    }
}
