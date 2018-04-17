<?php

namespace App\Http\Controllers;

use App\Vote;
use Auth;
use Illuminate\Http\Request;
use App\Idea;
use App\User;

class VoteController extends Controller
{
    /**
     * Check if the the user is auth else fo function about vote
     * VoteController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['getVotesUp', 'getVotesDown', 'checkIfAlreadyVote']]);
    }

    /**
     * Return the number of vote containing 1 for the idea with id => $id
     * @param $id
     * @return int
     */
     public static function getVotesUp($id){
        $votes = New Vote();
        $upVote = $votes->where('vote',"=","1")->where('idea',"=",$id)->count();

        return $upVote;
    }
    /**
     * Return the number of vote containing -1 for the idea with id => $id
     * @param $id
     * @return int
     */
    public static function getVotesDown($id){
        $votes = New Vote();
        $downVote = $votes->where('vote',"=","-1")->where('idea',"=",$id)->count();
        return $downVote;
    }

    /**
     * This function check if the user already vote for this idea. Return true of false
     * @param $user
     * @param $idea
     * @return bool|mixed
     */
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

    /**
     * This function is execute when a user click on ThumbUp button for an idea
     * Check all possibilities like if user already vote for ThumUp etc..
     * @param $idea
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public static function changeVoteUp($idea){
        $user = Auth::user()->id;

        //! If user already vote we delete his vote
         if (self::checkIfAlreadyVote($user,$idea)==1){
             Vote::where(['user'=>$user,'idea'=>$idea])->delete();
         }
         //! If user vote for ThumbDown before we delete -1 and add +1 vote in DB
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
             //! If user didn't vote we just add +1 in DB
            Vote::create([
                'vote' => +1,
                'date_vote' => date('Y-m-d'),
                'user' => $user,
                'idea' => $idea,
            ]);
        }
         return redirect()->route('idea',$idea);

    }
    /**
     * Function work as changeVoteUP above
     * @param $idea
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
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
