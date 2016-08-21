<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\TaskRepository;

class TaskController extends Controller
{
    //

    protected $tasks;
    function __construct(TaskRepository $tasks)
    {
        $this->middleware('auth');
        $this->tasks = $tasks;
    }

    public function index(Request $request)
    {
//        $task = $request->user()->tasks()->get();
        return view('tasks.index', array(
            'tasks' => $this->tasks->forUser($request->user())
    ));


    }

    public function store(Request $request)
    {
        $this->validate($request, array(
            'name' => 'required|max:255'
        ));
//        dd($request->user()->tasks());
        $request->user()->tasks()->create(array(
            'name' => $request->name
        ));
        return redirect('/tasks');
    }
    public function destroy(Request $request,Task $task){
        $this->authorize('destroy',$task);

        $task->delete();

        return redirect('/tasks');
    }
}