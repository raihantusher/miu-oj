<?php

namespace App\Http\Controllers;

use App\SetJoin;
use App\Set;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
class JoinSetController extends Controller
{
    //
    public function joined(Request $request){
      
        $setJoin = null;    
        $set     = Set::where('uuid', $request->uuid)
                        ->first();
        
       

        if ($set) {
            $now = Carbon::now();

            $launched_at = Carbon::parse($set->created_at); 
            $length = $launched_at->diffInDays($now);
            
            $setJoin = SetJoin::firstOrCreate(
                ['user_id' => Auth::id(), "set_id" => $set->id],
                ['user_id' => Auth::id(), "set_id" => $set->id ]
            );
        }

        if ($setJoin && ($length <= $set->expire_after) ) {
            session()->flash("success","Joining set is successfully done! ");
        } 
        else {
            session()->flash("success","Joining for this set is expired, thanks! " );
        }
        
        
         return redirect()->back();
    }



    
}
