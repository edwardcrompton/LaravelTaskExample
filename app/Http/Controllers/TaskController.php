<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\TaskRepository;
use Mail;

class TaskController extends Controller
{
    /**
     * The task repository instance.
     *
     * @var TaskRepository
     */
    protected $tasks;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TaskRepository $tasks)
    {
        $this->middleware('auth');
        $this->tasks = $tasks;
    }

    /**
     * Show a list of all of the user's tasks.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        $tasks = $request->user()->tasks()->get();
        return view('tasks.index', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * Show the form for editing the given task.
     *
     * @param  Request  $request
     * @param  Task  $task
     * @return Response
     */
    public function edit(Request $request, Task $task)
    {
        $this->authorize('edit', $task);

        return view('tasks.edit', [
          'task' => $task,
        ]);
    }

    /**
     * Create a new task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
          'name' => 'required|max:255',
        ]);

        $request->user()->tasks()->create([
          'name' => $request->name,
        ]);

        // This is pretty useless functionality but it shows the ability to send
        // an email. It could be improved if tasks had a due date and an email
        // was sent when the date approached.
        $this->sendEmailReminder($request->user(), $request->name);

        return redirect('/tasks');
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request, Task $task)
    {
        $this->validate($request, [
          'name' => 'required|max:255',
        ]);

        $this->authorize('edit', $task);

        $task->name = $request->name;
        $task->save();

        return redirect('/tasks');
    }

    /**
     * Destroy the given task.
     *
     * @param  Request  $request
     * @param  Task  $task
     * @return Response
     */
    public function destroy(Request $request, Task $task)
    {
        $this->authorize('destroy', $task);

        $task->delete();

        return redirect('/tasks');
    }

    /**
     * Send an e-mail reminder to the user.
     *
     * @param  Request  $request
     * @param  int $id
     * @return Response
     */
    public function sendEmailReminder(\App\User $user, $task)
    {
        Mail::send(['text' => 'emails.email'], ['user' => $user->name, 'task' => $task], function ($m) use ($user) {
            $m->from('hello@app.com', 'Hello App');
            $m->to($user->email, $user->name)->subject('A new task has been created');
        });
    }
}
