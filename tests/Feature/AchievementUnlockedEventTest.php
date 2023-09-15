<?php

namespace Tests\Feature;

use App\Events\AchievementUnlocked;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class AchievementUnlockedEventTest extends TestCase
{
    public function testAchievementUnlockedIsDispatched(){
        Event::fake();
        \event(new AchievementUnlocked('First Comment Written', User::factory()->create()));
        Event::assertDispatched(AchievementUnlocked::class, function ($e){
          return  $e->achievement = 'First Comment Written';
        });
    }
}
