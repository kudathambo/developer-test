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
        \event(new BadgeUnlocked('Beginner: 0 Achievements', User::factory()->create()));
        Event::assertDispatched(BadgeUnlocked::class, function ($e){
          return  $e->badge = 'Beginner: 0 Achievements';
        });
    }
    public  function testBadgeIsUnlocked(){
        Event::fake();
        $user = User::factory()->create();
        $listener = new BadgeUnlockedListener();
        $event = new BadgeUnlocked('Beginner: 0 Achievements', $user);
        $listener->handle($event);
        $this->assertDatabaseHas('badges', [
            'user_id' => $user->id
        ]);
    }
}
