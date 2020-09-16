<?php

use Illuminate\Support\Facades\Route;
use App\Set;

use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\Http;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('dhp', "PreventionPage")->name("dhp");



Route::group(['middleware' => ['auth']], function() {

    Route::get('/home', function () {
        $sets=App\User::find(Auth::id())->sets;

        if (Auth::user()->hasRole('admin')) {
            return view("home.admin");
        }
        return view("home.index")->with('sets', $sets);
    })->name('home');

});



Route::group(['middleware' => ['auth', 'role:admin']], function () {
    //
    Route::resource('set', 'SetController');
    Route::resource('qs', 'QuestionController');

    // notify user by mail
    Route::post('notify', 'NotifyController');
    //set relaunch
    Route::post('/launch/{id}','SetController@launch');

    Route::get('questions/{setID}', function ($setID) {
        $set = Set::find($setID);
        $qs  = null;
        return view('qs.add', compact('set','qs'));
    })->name('qs.set');


    

    // all student score according to setID
    Route::get('score/{setID}', function ($setID) {

        $set_qs             = App\Question::where('set_id', $setID)->get();
        $set_users          = App\Set::find($setID)->users;
        
        $set = App\Set::find($setID);

        $table              = [];

        foreach ($set_users as $user) {
            $temp           = new stdClass();
            $temp->userid   = $user->id;
            $temp->username = $user->name;
            $temp->result   = [];
            //$temp->result['q_id'][]      =[];
            //$temp->result['status'][]      =[];
            foreach($set_qs as $q):
               
                try {
                    $answer         = App\Answer::where('question_id', $q->id)
                                         ->where('user_id', $user->id)
                                         ->firstOrFail();
                    
                    $temp->result["status"][] = $answer->result;
                }
                catch (ModelNotFoundException $e) {
                    $temp->result["status"][] = "Not attempted !!";
                }
                //assign question id
                $temp->result["q_id"][]     = $q->id;
            endforeach;
            
            
            $temp->total    = App\Answer::where('user_id', $user->id)
                                        ->where('set_id', $setID)
                                        ->where("result", 'right')
                                        ->count();
            array_push($table, $temp);
        }

        $table = (object) $table;

        //dd($table);


        return view("set.score")
                ->with('set', $set)
                ->with('set_qs', $set_qs)
                ->with('results', $table); 

    })->name('set.score');

    // route for manual marking the result
    Route::get('judgement/{userID}/{questionID}', 'JudgeController')->name('judge');

    Route::post('judgement', 'JudgeController@updateResult')->name('judge.update');

});




Route::group(['middleware' => ['auth', 'role:student']], function () {

    Route::get('join-set', function(){
        
        return view('set.join');
    })->name("join.set");

    Route::post('/joining', 'JoinSetController@joined')
    ->name('joining');


    //question view agains set
    Route::get('/set-questions/{id}', 'StudentQuestionController')
    ->name("sq");


    //student set score page
    Route::get('/set-score/{setID}', function($setID) {
        $right = App\Answer::where('set_id', $setID)
                        ->where('user_id', Auth::id())
                        ->where('result', 'right')->count();

        $wrong = App\Answer::where('set_id', $setID)
                        ->where('user_id', Auth::id())
                        ->where('result', 'wrong')->count();
        
        $pending = App\Answer::where('set_id', $setID)
                        ->where('user_id', Auth::id())
                        ->where('result', 'pending')->count();
        
        $total = App\Question::where('set_id', $setID)->count();


        $student_answers     = DB::table('answers')
            ->join('questions', 'questions.id', '=', 'answers.question_id')
            ->where('answers.user_id', Auth::id())
            ->where('answers.set_id', $setID)
            ->get();
        
        return view('student.score',compact('right', 'wrong' ,'pending', 'total'))
                ->with('student_answers', $student_answers);

    })->name("score");

    // answer-page/{question id}
    Route::match(['get','post'],'/answer-page/{questionId}', function($questionId) {

        $question            = App\Question::find($questionId);
        // check if answer exist
        $if_answer_submitted = App\Answer::where('user_id', Auth::id())
                    ->where('question_id', $question->id)
                    ->first();
        
        // answer instance
        $request             = request();
        
        
        if ( $request->isMethod('post') && $if_answer_submitted == null ) {
            
            $judge_by = "manual";
            $result  = "pending";

            

           
                
            if (strcmp($question->set->judge_by, "automatic" ) == 0) {
               
                $response = Http::asForm()->post(env('COMPILER_API_LOC'), [
                    'code' => $request->code,
                    'input' => $question->test_input,
                ]);
                $response = json_decode($response->getBody());
                $judge_by = "automatic";

                if ($response->code === $question->test_output ){
                    
                    $result  = "right";
                }
                else {
                    $result  = "wrong";
                }
            }
            else{

            }
            
            
            //
                $answer      = App\Answer::firstOrCreate(
                [
                    'question_id' => $question->id,
                    'user_id'     => Auth::id()
                ],
                [
                    'answer_body' => $request->code,
                    'judge_by'    => $judge_by,
                    'result'      => $result,

                    //$answer->user_id=Auth::id();
                    'set_id'      => $question->set_id,
                    'question_id' => $question->id,
                    'user_id'     => Auth::id()
                     //$answer->question_id=$question->id;
                ]
        
            );
            
            $answer->save();
            return response()->json($answer);
        }
       
        return view("student.answer-page")->with('question', $question)
                ->with('answer', $if_answer_submitted);

    })->name('ap');

});