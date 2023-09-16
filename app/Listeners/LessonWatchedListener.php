<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Events\LessonWatched;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Event;

class LessonWatchedListener
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
    public function handle(LessonWatched $event): void
    {
        $lesson = $event->lesson;
        $user = $event->user;
        $lessonsCount = $user->watched->count();
        $achievementUnlocked = "";
        switch ($lessonsCount){
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
            case 25:
                $achievementUnlocked = '20 Lessons Watched';
                break;
            case 50:
                $achievementUnlocked = '50 Lessons Watched';
                break;
        }

        if(!empty($achievementUnlocked)){
            Event::dispatch(new AchievementUnlocked($achievementUnlocked, $user));
        }
    }
}
