<?php

namespace Feature;

use App\Events\CommentWritten;
use App\Events\LessonWatched;
use App\Listeners\CommentListener;
use App\Listeners\LessonWatchedListener;
use App\Models\Lesson;
use App\Models\User;
use Database\Factories\CommentFactory;
use Database\Factories\LessonFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class LessonWatchedEventTest extends TestCase
{

    public  function testLessonWatched(){
        Event::fake();
        $lesson = Lesson::factory()->create();
        $user = User::factory()->create();
        \event(new LessonWatched($lesson, $user));
        Event::assertDispatched(LessonWatched::class, function($e) use($lesson){
            return $e->lesson->id == $lesson->id;
        });
    }

    public  function  testFiftyLessonsWatchedAchieved(){
        $user = User::factory()->create();
        for ( $i = 0 ; $i < 50 ; $i++ ){
            $this->watchLesson($user, Lesson::factory()->create());
        }
        $response = $this->get("/users/{$user->id}/achievements");
        $response->assertJson(function (AssertableJson $json) {
            return $json->where('data.current_badge', 'Intermediate')
                ->where('data.unlocked_achievements', function($u){
                    return $u->contains('50 Lessons Watched');
                })
                ->where('data.next_badge', 'Advanced')
                ->where('data.next_available_achievements', function($next){
                    return $next->contains('First Comment Written');
                })
                ->where('data.remaining_to_unlock_next_badge', 3)
                ->etc();
        });
    }

    private function watchLesson($user, $lesson): void
    {
        $event = new LessonWatched($lesson, $user);
        $listener = new LessonWatchedListener();
        $listener->handle($event);

    }
}
