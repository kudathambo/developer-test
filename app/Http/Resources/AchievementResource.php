<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

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
        $achievementsCount = $this->achievements->count();
        foreach ($this->achievements as $achievement){
                $unlocked[] = $achievement->name;
        }
        foreach ($unlocked as $eventUnlocked){
            if(in_array($eventUnlocked,commentsWritten())){
                $commentsWritten[] = $eventUnlocked;
            }else if(in_array($eventUnlocked, lessonsWatched())){
                $lessonsWatched[] = $eventUnlocked;
            }
        }
        $currentBadge = $this->badges->last();
        $nextBadges = array_filter(badgesAvailable(),function($badge) use($currentBadge){
            return $badge != $currentBadge->name;
        });
        $nextBadge = array_shift($nextBadges);
        $nextBadgeIndex = (int) array_search($nextBadge, badgesAvailable());
        $nextCommentAchievement = array_filter(commentsWritten(), function($comment) use($commentsWritten){
            return ! in_array($comment, $commentsWritten);
        });
        $nextLessonAchievement = array_filter(lessonsWatched(), function($lesson) use($lessonsWatched){
            return ! in_array($lesson, $lessonsWatched);
        });
         return [
                'unlocked_achievements' => $unlocked,
                'next_available_achievements' => [array_shift($nextCommentAchievement), array_shift($nextLessonAchievement)],
                'current_badge' => $currentBadge->name,
                'next_badge' => $nextBadge,
                'remaining_to_unlock_next_badge' => ($nextBadgeIndex - $achievementsCount)
        ];
    }
}
