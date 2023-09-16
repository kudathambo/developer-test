<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use App\Models\Achievement;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

class AchievementUnlockedListener
{
    /**
     * Handle the event.
     */
    public function handle(AchievementUnlocked $event)
    {
        $availableBadges = badgesAvailable();
        $user = $event->user;
        $achievement = $event->achievement;
        $data = ['name' => $achievement];
        $user->achievements()->create($data);
        $countAchievements = $user->achievements()->count();
        if(isset($availableBadges[$countAchievements])){
            Event::dispatch(new BadgeUnlocked($availableBadges[$countAchievements], $user));
        }
    }
}
