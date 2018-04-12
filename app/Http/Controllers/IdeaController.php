<?php

namespace App\Http\Controllers;

use App\Http\Controllers\VoteController;
use App\Vote;
use Illuminate\Http\Request;
use App\Idea;
use App\User;

use Illuminate\Support\Facades\Auth;

class IdeaController extends Controller
{
    public function __construct()
    {
    }

    function index($id)
    {
        $idea = Idea::findOrFail($id);
        $userSource = User::findOrFail($idea->user);
        $upVotes = VoteController::getVotesUp($id);
        $downVotes = VoteController::getVotesDown($id);
        if (isset(Auth::user()->id)){


            if (VoteController::checkIfAlreadyVote(Auth::user()->id,$id)==false){
                $buttonStyleUp = "btn btn-light";
                $buttonStyleDown = "btn btn-light";
            }
            elseif(VoteController::checkIfAlreadyVote(Auth::user()->id,$id)!==false){
                if (VoteController::checkIfAlreadyVote(Auth::user()->id,$id) == -1){
                    $buttonStyleUp = "btn btn-light";
                    $buttonStyleDown = "btn btn-danger";

                }
                else{
                    $buttonStyleUp = "btn btn-primary";
                    $buttonStyleDown = "btn btn-light";

                }
            }
        }
        else{
            $buttonStyleUp = "btn btn-light";
            $buttonStyleDown = "btn btn-light";
        }

        return view('idea', compact('idea'),
            ['lastname' => $userSource->lastname,
                'firstname' => $userSource->firstname,
                'upVotes' => $upVotes,
                'downVotes' => $downVotes,
                'buttonStyleUp' => $buttonStyleUp,
                'buttonStyleDown' => $buttonStyleDown,
            ]);
    }

    function allIdeas(){
        $ideas = Idea::all()->sortBy('created_at');
        return view('ideas',compact('ideas'));

    }
}
