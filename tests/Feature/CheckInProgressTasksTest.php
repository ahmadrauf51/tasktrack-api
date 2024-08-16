<?php
namespace Tests\Feature;
use App\Jobs\CheckInProgressTasks;
use App\Mail\InProgressTaskNotification;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class CheckInProgressTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_sends_email_to_users_with_in_progress_tasks()
    {
        // Prevent actual emails from being sent
        Mail::fake();

        // Create a user
        $user = User::factory()->create();

        // Create a task with status 'in progress'
        $task = Task::factory()->create([
            'user_id' => $user->id,
            'status' => 'in progress',
        ]);

        // Dispatch the job
        CheckInProgressTasks::dispatch();

        // Assert that an email was sent to the user
        Mail::assertSent(InProgressTaskNotification::class, function ($mail) use ($user, $task) {
            return $mail->hasTo($user->email) && $mail->task->id === $task->id;
        });
    }
}
