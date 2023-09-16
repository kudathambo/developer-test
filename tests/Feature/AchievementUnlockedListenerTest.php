<?php

namespace Tests\Feature;

use App\Events\AchievementUnlocked;
use App\Listeners\AchievementUnlockedListener;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class AchievementUnlockedListenerTest extends TestCase
{

    public function testAchievementUnlockedListening(): void
    {
        Event::fake();
        Event::assertListening(AchievementUnlocked::class, AchievementUnlockedListener::class);
    }
}
