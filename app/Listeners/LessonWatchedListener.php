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
        $lessonAchievements = lessonsWatched();
        $lesson = $event->lesson;
        $user = $event->user;
        $user->watched()->attach([
            $lesson->id => [
                'watched' => true
            ]
        ]);
        $lessonsCount = $user->watched->count();
        $achievementUnlocked = "";
        if(isset($lessonAchievements[$lessonsCount])){
            $achievementUnlocked = $lessonAchievements[$lessonsCount];
        }
        if(!empty($achievementUnlocked)){
            Event::dispatch(new AchievementUnlocked($achievementUnlocked, $user));
        }
    }
}
