<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Events\CommentWritten;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
        $comment = $event->comment;
        $user = $comment->user;
        $commentsCount = $user->comments->count();
        $achievementUnlocked = "";
        switch ($commentsCount){
            case 1:
                $achievementUnlocked = 'First Comment Written';
                break;
            case 3:
                $achievementUnlocked = '3 Comments Written';
                break;
            case 5:
                $achievementUnlocked = '5 Comments Written';
                break;
            case 10:
                $achievementUnlocked = '10 Comments Written';
                break;
            case 20:
                $achievementUnlocked = '20 Comments Written';
                break;
        }

        if(!empty($achievementUnlocked)){
            event(new AchievementUnlocked($achievementUnlocked, $user));
        }
    }
}
