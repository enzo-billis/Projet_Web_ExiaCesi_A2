<?php

namespace App\Http\Controllers;

use App\Http\Controllers\VoteController;
use App\Vote;
use Illuminate\Http\Request;
use App\Idea;
use App\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class IdeaController extends Controller
{
    public function __construct()
    {
    }

    function newIdea(Request $request){

        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:5000',
            'description' => 'required|string|max:5000',
            'photo' => 'required|max:5000',
        ]);
        if ($validator->fails()) {
//            dd($request);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $image = $request->file('photo');
        $filename  = time() . '.' . $image->getClientOriginalExtension();

        $path = "storage/manifestationCoverPics/". $filename;
        $pathToDb = "manifestationCoverPics/". $filename;


        Image::make($image->getRealPath())->fit(400, 280)->save($path);


//        $path = $request->file('photo')->store('/public/manifestationPics');
//        $path = substr($path,7);

        $ideaObj = New Idea();
        $ideaObj::create([
            'name' => $request->input('name'),
            'image' => $pathToDb,
            'description' => $request->input('description'),
            'user' => Auth::user()->id,
        ]);

        return redirect()->back()->with('success', ['Bravo ! ']);
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
        $ideas = Idea::all()->sortByDesc('created_at');
        return view('ideas',compact('ideas'));

    }
}
