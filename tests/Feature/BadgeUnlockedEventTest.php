<?php

namespace Feature;

use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use App\Listeners\AchievementUnlockedListener;
use App\Listeners\BadgeUnlockedListener;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class BadgeUnlockedEventTest extends TestCase
{
    public function testIsListening(){
        Event::fake();
        Event::assertListening(BadgeUnlocked::class, BadgeUnlockedListener::class);
    }
    public function testAchievementUnlockedIsDispatched(){
        Event::fake();
        $available = badgesAvailable();
        \event(new BadgeUnlocked($available[0], User::factory()->create()));
        Event::assertDispatched(BadgeUnlocked::class, function ($e) use($available){
          return  $e->badge = $available[0];
        });
    }
    public  function testBadgeIsUnlocked(){
        Event::fake();
        $user = User::factory()->create();
        $listener = new BadgeUnlockedListener();
        $event = new BadgeUnlocked(badgesAvailable()[0], $user);
        $listener->handle($event);
        $this->assertDatabaseHas('badges', [
            'user_id' => $user->id
        ]);
    }
}
