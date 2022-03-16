<?php

namespace App\Http\Controllers;

use App\Events\ChatEvent;
use App\User;
use DB;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()

    {
        $users = User::where('id', '<>', Auth::id())->get();

        return view('others.chat_room', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    public function update($id, Request $request)
    {
    }

    public function destroy($id)
    {
    }

    public function show($id)
    {
        $messages = Message::where('to_user_id', $id)
            ->where('user', Auth::id())
            ->orWhere('user', $id)
            ->where('to_user_id', Auth::id())
            ->orderBy('time', 'asc')
            ->get();

        return response()->json($messages, 200);
    }

    public function chat()
    {
        return view('chat');
    }

    public function send(Request $request)
    {
        $message = new Message;
        $message->message    = $request->message;
        $message->user    = Auth::id();
        $message->time = $request->time;
        $message->to_user_id = $request->user;
        $message->save();
        //$this->saveToSession($request);
        broadcast(new ChatEvent($request->message, Auth::user(), $request->user))->toOthers();
        // event(new ChatEvent($request->message,$user));
    }
    public function saveToSession(request $request)
    {
        session()->put('chat', $request->chat);
    }
    /**
     * return last messages send by other users to  the auth user
     *
     * @return void
     * @author _KaziWhite**__SALAF4_WebDev**
     **/
    public function getOldMessage()
    {
        $users = DB::select("select *  , users.id as user_id from users, messages

            where 
            users.id = messages.user
            and time in (select max(time) as time from messages group by user)
            and  messages.to_user_id = ?", [Auth::id()]);

        return response()->json($users, 200);
    }


    public function getUsers()
    {
        return User::with('messageMax')/*->where('id','<>',Auth::id())*/->get();
        // return User::
        // where('users.id','<>',Auth::id())
        // ->join('messages' , 'messages.to_user_id' ,'users.id')
        // ->whereIn('time' , function($query){
        //     return $query->selectRaw("Max(time)")->from('messages')->groupBy('to_user_id');
        // })->orderBy('time','desc')->get();
    }
}
// <?php

// namespace App\Http\Controllers;

// use App\Events\ChatEvent;
// use App\User;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

// class ChatController extends Controller
// {
//     /**
//      * Create a new controller instance.
//      *
//      * @return void
//      */
//     public function __construct()
//     {
//         $this->middleware('auth');
//     }

//     public function chat()
//     {
//         return view('chat');
//     }
//     public function index()
//     {
//         return view('chat');
//     }
//     public function send(request $request)
//     {
//         $user = User::find(Auth::id());
//         $this->saveToSession($request);
//         broadcast(new ChatEvent($request->message,$user))->toOthers();
//     }
//     public function saveToSession(request $request)
//     {
//         session()->put('chat',$request->chat);
//     }

//     public function getOldMessage()
//     {
//         return session('chat');
//     }

//     public function deleteSession()
//     {
//         session()->forget('chat');
//     }
//}
