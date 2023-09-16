<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
        foreach ($this->achievements as $achievement){
                $unlocked[] = $achievement->name;
        }
        return [
                'unlocked_achievements' => $unlocked,
                'next_available_achievements' => [],
                'current_badge' => '',
                'next_badge' => '',
                'remaining_to_unlock_next_badge' => 0

        ];
    }
}
