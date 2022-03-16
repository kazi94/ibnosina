<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Http\Controllers\ChatController;

class MessageComposer
{
    /**
     * The user repository implementation.
     *
     * @var ChatController
     */
    protected $chat;

    /**
     * Create a new profile composer.
     *
     * @param  ChatController  $chat
     * @return void
     */
    public function __construct(ChatController $chat)
    {
        // Dependencies automatically resolved by service container...
        $this->chat = $chat;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        // if (Auth::check()) $view->with('messages', $this->chat->getNewMessage());
    }
}