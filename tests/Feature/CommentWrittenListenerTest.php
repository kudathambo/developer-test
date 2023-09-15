<?php

namespace Tests\Feature;

use App\Events\CommentWritten;
use App\Listeners\CommentListener;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentWrittenListenerTest extends TestCase
{
    use RefreshDatabase; // If your listener interacts with the database

    public function testCommentWrittenListenerIsExecuted()
    {
        $comment = Comment::factory()->create();

        $listener = new CommentListener();
        $listener->handle(new CommentWritten($comment));

        // Assertions: Check that the listener's logic is executed as expected
        // Replace the assertions with your specific logic to test
        // For example, check if a notification is sent or a database record is updated
        $this->assertTrue(true); // Replace with your actual assertions
    }
}
