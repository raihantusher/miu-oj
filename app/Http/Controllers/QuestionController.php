<?php

namespace App\Http\Controllers;

use App\Set;
use App\Question;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view("qs.add");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // get limit of question
        $validatedData = Validator::make($request->all(), [
            'title' => ['required'],
            'body' => ['required'],
            'answer_code' => ['required']
        ]);

        if ($validatedData->fails()) {
            return response()->json(['status' => 3]);
        }

        $set= Set::find($request->set_id)->first();

        // count question according to set id
        $q_number = Question::where('set_id', $request->set_id)->count();
        if ($set->n_o_q != $q_number) {
               //
               $q        = new Question;
               $q->title = $request->title;
               $q->body  = $request->body;
               
               $q->answer_code = $request->answer_code;
               $q->test_input = $request->dummyInput;
               $q->test_output = $request->dummyOutput;
               $q->user_id = Auth::id();
               $q->set_id  = $request->set_id;
               $q->save();
    
            //$request->session()->flash("success" , "New question has been created!!");
           // return redirect()->back();
           //api response
           $q->status      =  0;
           if ($set->n_o_q == ($q_number+1)) {
               $q->status = 2;
           }
           
           return response()->json($q);
        }

        return response()->json(['status'=>1]);
         
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
        //
        $question       = Question::find($id);
        return view('qs.add')->with("qs", $question);
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
         // get limit of question
         $validatedData = Validator::make($request->all(), [
            'title' => ['required'],
            'body' => ['required'],
            'answer_code' => ['required']
        ]);

        if ($validatedData->fails()) {
            return response()->json(['status' => 3]);
        }

        $question        = Question::find($id);
        $question->title = $request->title;
        $question->body  = $request->body;
               
        $question->answer_code = $request->answer_code;
        $question->test_input = $request->dummyInput;
        $question->test_output = $request->dummyOutput;
       // $q->user_id = Auth::id();
        //$q->set_id  = $request->set_id;

        $question->save();
        return response()->json(['status' => 4]);
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
        $question = Question::find($id);
        $question->delete();

        return back()->with("success", "Successfully Deleted!!");
    }
}
