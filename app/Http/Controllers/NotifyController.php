<?php

namespace App\Http\Controllers;

use App\Set;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Mail\NotifyUser;

class NotifyController extends Controller
{
    //
    public function __invoke(Request $request) {

        $sets = Set::find($request->id);
        foreach($sets->users as $user){
            Mail::to($user->email)->send(new NotifyUser($sets,$user));
        }
        //$request->session()->flash('success', 'Users have been successfully notified!!');
        return response()->json(['status' => 1]);
    }
}
