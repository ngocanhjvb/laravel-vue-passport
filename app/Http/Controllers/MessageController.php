<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use Redis;
use Illuminate\Support\Facades\Auth;
use App\Events\MessagePosted;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }


    public function index()
    {
//        if ($messages = Redis::get('messages.all')) {
//            return json_decode($messages);
//        }
        $messages = Message::with('user')->get();
        Redis::set('messages.all', $messages);
        return json_decode($messages);
    }

    public function store()
    {
        $user = Auth::user();
        $message = Message::create(['message' => request()->get('message'), 'user_id' => Auth::id()]);
        broadcast(new MessagePosted($message, $user))->toOthers();

        return $message;
    }
}
