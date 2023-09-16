<?php

namespace Feature;

use App\Events\LessonWatched;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
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
}
