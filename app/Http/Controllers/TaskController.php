<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
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
        $task = new Task();

        // Set the attributes 
        $task->name = $request->name;
        $task->completed = false;

        // Store the Task
        $task->save();
    }

    /**
     * Get a Task by ID or get all Tasks.
     *
     * @param Request
     * @return Task
     */
    public function read(Request $request) 
    {
        // Check if an ID was provided 
        if (isset($request->id)) {
            // Get and return the Task
            return json_encode(Task::find($request->id));
        }

        // Otherwise get and return all Tasks
        return json_encode(Task::all());
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

        // Otherwise delete the Task by ID
        Task::destroy($request->id);
    }
}
