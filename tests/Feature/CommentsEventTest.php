<?php

namespace Tests\Feature;

use App\Events\CommentWritten;
use App\Listeners\CommentListener;
use App\Models\Comment;
use App\Models\User;
use Database\Factories\CommentFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CommentsEventTest extends TestCase
{

    public  function testCommentWritten(){
        Event::fake();
        $comment =Comment::factory()->create();
        \event(new CommentWritten($comment));
        Event::assertDispatched(CommentWritten::class, function($e) use($comment){
            return $e->comment->id == $comment->id;
        });
    }

    public  function  testThreeCommentsAchieved(){
        $user = User::factory()->create();
        for ( $i = 0 ; $i <=3 ; $i++ ){
           $this->writeComment($user->id);
        }
        $response = $this->get("/users/{$user->id}/achievements");
        $response->assertJson(function (AssertableJson $json) {
        return $json->where('data.current_badge', 'Beginner')
            ->where('data.unlocked_achievements', function($u){
                return $u->contains('First Comment Written') && $u->contains('3 Comments Written');
            })
            ->where('data.next_badge', 'Intermediate')
            ->where('data.remaining_to_unlock_next_badge', 2)
            ->etc();
        });
    }

    private function writeComment($uid): void
    {
        $comment = CommentFactory::new(['user_id' => $uid])->create();
        $event = new CommentWritten($comment);
        $listener = new CommentListener();
        $listener->handle($event);
    }

}
