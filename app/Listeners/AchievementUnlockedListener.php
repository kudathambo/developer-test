<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Models\Achievement;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AchievementUnlockedListener
{
    /**
     * Handle the event.
     */
    public function handle(AchievementUnlocked $event)
    {
        $user = $event->user;
        $achievement = $event->achievement;
        $data = ['name' => $achievement];
        $user->achievements()->create($data);
    }
}
