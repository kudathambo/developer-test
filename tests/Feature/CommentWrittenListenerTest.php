<?php

namespace Tests\Feature;

use App\Events\CommentWritten;
use App\Listeners\CommentListener;
use App\Models\Comment;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class CommentWrittenListenerTest extends TestCase
{
    public function testCommentWrittenListening(): void
    {
        Event::fake();
        Event::assertListening(CommentWritten::class, CommentListener::class);
    }

//    public function testCommentWrittenListenerIsExecuted()
//    {
//        Event::fake();
//        $comment = Comment::factory()->create();
//        $user = $comment->user;
//        \event(new CommentWritten($comment));
//        $this->assertDatabaseHas('achievements', [
//            'user_id' => $user->id
//        ]);
//    }
}
