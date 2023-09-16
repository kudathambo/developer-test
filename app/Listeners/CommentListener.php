<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Events\CommentWritten;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

class CommentListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CommentWritten $event): void
    {
        $commentsToWrite = commentsWritten();
        $comment = $event->comment;
        $user = $comment->user;
        $commentsCount = $user->comments()->count();
        $achievementUnlocked = "";
        if(isset($commentsToWrite[$commentsCount])){
            $achievementUnlocked = $commentsToWrite[$commentsCount];
        }
        if(!empty($achievementUnlocked)){
            Event::dispatch(new AchievementUnlocked($achievementUnlocked, $user));
        }
    }
}
