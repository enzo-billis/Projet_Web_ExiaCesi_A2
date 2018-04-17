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

/**
 * IdeaController control every objects idea.
 */

class IdeaController extends Controller
{
    public function __construct()
    {
    }

    /**
     * Allow you the possibilitie to create a new idea.
     * @param $request
     * @return view->back
     */
    function newIdea(Request $request)
    {

        //! We continue the function only if the $request content match with these rules
        $validator = Validator::make($request->all(), [

            //! Name is required as string variable and max lenght is 5000
            'name' => 'required|string|max:5000',
            'description' => 'required|string|max:5000',
            'photo' => 'max:5000',

        ]);

        //! If the rules are not respect, we return an error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //! We verify if the request contain a picture for the idea
        if ($request->file('photo')) {

            //! We put in an object the request picture file
            $image = $request->file('photo');

            //! We define a unique name with time
            $filename = time() . '.' . $image->getClientOriginalExtension();

            //! We define twice $path different because the path where to save and the path where to load are different
            //! This is relative path
            $path = "storage/manifestationCoverPics/" . $filename;
            $pathToDb = "/storage/manifestationCoverPics/" . $filename;

            //! We resize the image to fix size and save it
            Image::make($image->getRealPath())->fit(400, 280)->save($path);
        }
        //! If the request doesn't contain picture we define one as default
        else {
            $path = "storage/manifestationCoverPics/default.jpg";
            $pathToDb = "/storage/manifestationCoverPics/default.jpg";
            Image::make("https://cloud.netlifyusercontent.com/assets/344dbf88-fdf9-42bb-adb4-46f01eedd629/68dd54ca-60cf-4ef7-898b-26d7cbe48ec7/10-dithering-opt.jpg")->fit(400, 280)->save($path);
        }


//        $path = $request->file('photo')->store('/public/manifestationPics');
//        $path = substr($path,7);

        //! We create a new idea in the database with $pathToDb as image
        $ideaObj = New Idea();
        $ideaObj::create([
            'name' => $request->input('name'),
            'image' => $pathToDb,
            'description' => $request->input('description'),
            'user' => Auth::user()->id,
        ]);

        //! We return to the back with a success message
        return redirect()->back()->with('success', ['Bravo ! ']);
    }

    /**
     *
     * Allow you to print an idea.
     * @param $id -> id of the idea
     * @return view->idea
     */

    function index($id)
    {
        //! We use findOrFail to get the Idea Object with the ID. If not found, return error 500
        $idea = Idea::findOrFail($id);

        //! Same as above for User object
        $userSource = User::findOrFail($idea->user);

        //! We use getVotesUp to get the number of vote Up on an Idea (With parameter id)
        $upVotes = VoteController::getVotesUp($id);
        //! Same as above for vote down
        $downVotes = VoteController::getVotesDown($id);

        //! If user is connected
        if (isset(Auth::user()->id)) {

            //! checkIfAlreadyVote return false or true if user vote
            if (VoteController::checkIfAlreadyVote(Auth::user()->id, $id) == false) {
                //! If user didn't vote we set button light
                $buttonStyleUp = "btn btn-light";
                $buttonStyleDown = "btn btn-light";
            }
            //! Else if user vote
            elseif (VoteController::checkIfAlreadyVote(Auth::user()->id, $id) !== false) {
                //! If he vote down we define button down as danger and up as light
                if (VoteController::checkIfAlreadyVote(Auth::user()->id, $id) == -1) {
                    $buttonStyleUp = "btn btn-light";
                    $buttonStyleDown = "btn btn-danger";

                }
                //! If he vote up we define button up as primary and down as light
                else {
                    $buttonStyleUp = "btn btn-primary";
                    $buttonStyleDown = "btn btn-light";

                }
            }
        }
        //! If user is not connected we define button light
        else {
            $buttonStyleUp = "btn btn-light";
            $buttonStyleDown = "btn btn-light";
        }

        //! We return the view idea with all idea informations and button styles
        return view('idea', compact('idea'),
            ['lastname' => $userSource->lastname,
                'firstname' => $userSource->firstname,
                'upVotes' => $upVotes,
                'downVotes' => $downVotes,
                'buttonStyleUp' => $buttonStyleUp,
                'buttonStyleDown' => $buttonStyleDown,
            ]);
    }

    /**
     * Give all ideas in DB in sort by descending from column created_at
     * @param nothing
     * @return view->ideas
     */
    function allIdeas()
    {
        $ideas = Idea::all()->sortByDesc('created_at');
        return view('ideas', compact('ideas'));

    }
}
