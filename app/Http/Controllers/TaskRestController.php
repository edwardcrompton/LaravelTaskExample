<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Repositories\TaskRepository;

class TaskRestController extends Controller
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
        $this->tasks = $tasks;
    }

    /**
     * Add a Task over RESTful API
     */
    public function add(Request $request) {
        $task = new Task;
        $task->name = $request->get('name');
        $task->user_id = 1;
        $task->save();

        return response()->json([
            'error' => false,
            'task' => (array)$task,
            200,
        ]);
    }
}
