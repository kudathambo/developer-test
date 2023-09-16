<?php

namespace Tests\Feature;

use App\Events\AchievementUnlocked;
use App\Listeners\AchievementUnlockedListener;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class AchievementUnlockedEventTest extends TestCase
{
    public function testIsListening(){
        Event::fake();
        Event::assertListening(AchievementUnlocked::class, AchievementUnlockedListener::class);
    }
    public function testAchievementUnlockedIsDispatched(){
        Event::fake();
        \event(new AchievementUnlocked('First Comment Written', User::factory()->create()));
        Event::assertDispatched(AchievementUnlocked::class, function ($e){
          return  $e->achievement = 'First Comment Written';
        });
    }
    public  function testAchievementIsUnlocked(){
        Event::fake();
        $user = User::factory()->create();
        $listener = new AchievementUnlockedListener();
        $event = new AchievementUnlocked('First Comment Written', $user);
        $listener->handle($event);
        $this->assertDatabaseHas('achievements', [
            'user_id' => $user->id
        ]);
    }
}
