<?php

namespace App\Http\Resources;

use App\Events\BadgeUnlocked;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;

class AchievementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $unlocked = [];
        $lessonsWatched = [];
        $commentsWritten = [];
        $badgesAvailable = badgesAvailable();
        $commentAchievements = commentsWritten();
        $lessonAchievements = lessonsWatched();
        $achievementsCount = $this->achievements()->count();
        foreach ($this->achievements as $achievement){
                $unlocked[] = $achievement->name;
        }
        foreach ($unlocked as $eventUnlocked){
            if(in_array($eventUnlocked, $commentAchievements)){
                $commentsWritten[] = $eventUnlocked;
            }else if(in_array($eventUnlocked, $lessonAchievements)){
                $lessonsWatched[] = $eventUnlocked;
            }
        }
        $currentBadge = $this->badges->last();
        if($currentBadge == null){
            $currentBadge = $this->badges()->create(['name' => $badgesAvailable[0]]);
        }
        $currentBadgeIndex = array_search($currentBadge->name, $badgesAvailable);
        $nextBadges = array_filter($badgesAvailable, function($badge, $index) use($currentBadgeIndex){
            return $index > $currentBadgeIndex;
         }, ARRAY_FILTER_USE_BOTH);
        $nextBadge = array_shift($nextBadges) ?? '';
        $nextBadgeIndex = (int) array_search($nextBadge, $badgesAvailable);
        $nextCommentAchievement = array_filter($commentAchievements, function($comment) use($commentsWritten){
            return ! in_array($comment, $commentsWritten);
        });
        $nextLessonAchievement = array_filter($lessonAchievements, function($lesson) use($lessonsWatched){
            return ! in_array($lesson, $lessonsWatched);
        });
         return [
                'unlocked_achievements' => $unlocked,
                'next_available_achievements' => array_filter([array_shift($nextCommentAchievement), array_shift($nextLessonAchievement)]),
                'current_badge' => $currentBadge->name,
                'next_badge' => $nextBadge,
                'remaining_to_unlock_next_badge' => ($nextBadgeIndex - $achievementsCount)
        ];
    }
}
