<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;

class StudentQuestionController extends Controller
{
    //
    public function __invoke($id){

        $questions = Question::where("set_id", $id)->get();
        return view("student.question")->with('questions', $questions);
    }
}
