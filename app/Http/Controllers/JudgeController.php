<?php

namespace App\Http\Controllers;

use App\Answer;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class JudgeController extends Controller
{
    //
    public function __invoke($userID, $questionID) {
        $answer = null;
        try {
            $answer = Answer::where('user_id', $userID)
                                ->where('question_id', $questionID)
                                ->firstOrFail();
        }
        catch (ModelNotFoundException $e) {
            return "<h4 style='text-align:center'>This student didn't attempt the test, Thank you!! </h4>";
        }
       
        return view('set.judgement')->with('answer',$answer);
    }

    public function updateResult(Request $request) {
        $answer           = Answer::find($request->answer_id)->first();
        $answer->result   = $request->result;
        $answer->judge_by = "manual";
        $answer->save();

        return response()->json($answer);
    }
}
