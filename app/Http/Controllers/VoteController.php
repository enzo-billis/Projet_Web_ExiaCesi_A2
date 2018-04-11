<?php

namespace App\Http\Controllers;

use App\Vote;
use Auth;
use Illuminate\Http\Request;
use App\Idea;
use App\User;

class VoteController extends Controller
{
     public static function getVotesUp($id){
        $votes = New Vote();
        $upVote = $votes->where('vote',"=","1")->where('idea',"=",$id)->count();

        return $upVote;
    }
    public static function getVotesDown($id){
        $votes = New Vote();

        $downVote = $votes->where('vote',"=","-1")->where('idea',"=",$id)->count();
        return $downVote;
    }
    public static function checkIfAlreadyVote($user,$idea){
         $votes = New Vote();
         $querry = $votes->where('user',"=","$user")->where('idea',"=",$idea)->value('vote');
         if (null !== ($votes->where('user',"=","$user")->where('idea',"=",$idea)->first())){

             return ($querry);
         }
         else{

             return false;
         }
    }

    public static function changeVoteUp($idea){
        $user = Auth::user()->id;

         if (self::checkIfAlreadyVote($user,$idea)==1){
             Vote::where(['user'=>$user,'idea'=>$idea])->delete();
         }
        elseif(self::checkIfAlreadyVote($user,$idea) == -1) {
            Vote::where(['user'=>$user,'idea'=>$idea])->delete();
            Vote::create([
                'vote' => +1,
                'date_vote' => date('Y-m-d'),
                'user' => $user,
                'idea' => $idea,
            ]);
        }
        else{
            Vote::create([
                'vote' => +1,
                'date_vote' => date('Y-m-d'),
                'user' => $user,
                'idea' => $idea,
            ]);
        }
         return redirect()->route('idea',$idea);

    }
    public static function changeVoteDown($idea){
         $user = Auth::user()->id;
        if (self::checkIfAlreadyVote($user,$idea)==-1){
            Vote::where(['user'=>$user,'idea'=>$idea])->delete();
        }
        elseif(self::checkIfAlreadyVote($user,$idea) == 1){
            Vote::where(['user'=>$user,'idea'=>$idea])->delete();
            Vote::create([
                'vote'=>-1,
                'date_vote'=>date('Y-m-d'),
                'user'=>$user,
                'idea'=>$idea,
            ]);
        }
        else{
            Vote::create([
                'vote' => -1,
                'date_vote' => date('Y-m-d'),
                'user' => $user,
                'idea' => $idea,
            ]);
        }

        return redirect()->route('idea',$idea);
    }
}
