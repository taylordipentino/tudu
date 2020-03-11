<?php

namespace App\Http\Controllers;

use App\Task;
use App\Repositories\TaskRepository;
use Illuminate\Http\Request;

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
     * @param  TaskRepository  $tasks
     * @return void
     */
    public function __construct(TaskRepository $tasks)
    {
        $this->middleware('auth');

        $this->tasks = $tasks;
    }
    
    /**
     * Create a new Task. 
     *
     * @param Request
     * @return void
     */
    public function create(Request $request) 
    {
        // Only continue if a task name was provided
        if (!isset($request->name)) {
            return;
        }

        // Create the new task 
        $request->user()->tasks()->create([
            'name' => $request->name, 
            'completed' => false
        ]);
    }

    /**
     * Get all Tasks belonging to the User.
     *
     * @param Request
     * @return Task
     */
    public function read(Request $request) 
    {
        // Get and return all Tasks belonging to the User
        return json_encode($this->tasks->forUser($request->user()));
    }

    /**
     * Update an existing Task. 
     *
     * @param Request
     * @return void
     */
    public function update(Request $request) 
    {
        // Only continue if an ID and name were provided
        if (!isset($request->id) || !isset($request->name)) {
            return;
        }

        // Get the task 
        $task = Task::find($request->id);

        // Set the attributes 
        $task->name = $request->name;
        $task->completed = $request->completed;

        // Store the Task
        $task->save();
    }

    /**
     * Delete a Task by ID. 
     *
     * @param Request
     * @return void
     */
    public function delete(Request $request) 
    {
        // Only continue if an ID was provided 
        if (!isset($request->id)) {
            return;
        }

        // Get the task 
        $task = Task::find($request->id);

        // Make sure the User owns the Task being deleted 
        $this->authorize('delete', $task);

        // Delete the Task
        $task->delete();
    }
}
