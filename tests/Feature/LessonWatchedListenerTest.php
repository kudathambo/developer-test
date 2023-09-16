<?php

namespace Feature;

use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use App\Events\LessonWatched;
use App\Listeners\AchievementUnlockedListener;
use App\Listeners\BadgeUnlockedListener;
use App\Listeners\LessonWatchedListener;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class LessonWatchedListenerTest extends TestCase
{

    public function testAchievementUnlockedListening(): void
    {
        Event::fake();
        Event::assertListening(AchievementUnlocked::class, AchievementUnlockedListener::class);
    }

    public  function testLessonIsWatched(){
        Event::fake();
        $user = User::factory()->create();
        $lesson = Lesson::factory()->create();
        $listener = new LessonWatchedListener();
        $event = new LessonWatched($lesson, $user);
        $listener->handle($event);
        $this->assertDatabaseHas('lesson_user', [
            'user_id' => $user->id,
            'lesson_id' => $lesson->id
        ]);
    }
}
