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
            'photo' => 'max:5000',
        ]);
        if ($validator->fails()) {
//            dd($request);
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if($request->file('photo')){
            $image = $request->file('photo');
            $filename  = time() . '.' . $image->getClientOriginalExtension();

            $path = "storage/manifestationCoverPics/". $filename;
            $pathToDb = "/storage/manifestationCoverPics/". $filename;


            Image::make($image->getRealPath())->fit(400, 280)->save($path);
        }
        else{
            $path = "storage/manifestationCoverPics/default.jpg";
            $pathToDb = "/storage/manifestationCoverPics/default.jpg";
            Image::make("https://cloud.netlifyusercontent.com/assets/344dbf88-fdf9-42bb-adb4-46f01eedd629/68dd54ca-60cf-4ef7-898b-26d7cbe48ec7/10-dithering-opt.jpg")->fit(400, 280)->save($path);
        }



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
