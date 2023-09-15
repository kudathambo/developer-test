<?php

namespace Tests\Feature;

use App\Events\CommentWritten;
use App\Listeners\CommentListener;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class CommentsEventTest extends TestCase
{

    public function testListening(): void
    {
        Event::fake();
        Event::assertListening(CommentWritten::class, CommentListener::class);
    }
    public  function testCommentWritten(){
        Event::fake();
        $comment =Comment::factory()->create();
        \event(new CommentWritten($comment));
        Event::assertDispatched(CommentWritten::class, function($e) use($comment){
            return $e->comment->id == $comment->id;
        });
    }
}
