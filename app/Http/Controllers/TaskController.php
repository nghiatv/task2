<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use Gate;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\TaskRepository;
use Illuminate\Support\Facades\Auth;

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

    public function destroy(Request $request, $id)
    {
//        dd($request->user());
        $task = Task::findOrFail($id);

//        dd($task->user_id);
//        dd($request->user()->id);

        dd(Auth::user());

        if (Gate::denies('delete-task', $task)) {
            abort(403);
        }

        $task->delete();

        return redirect('/tasks');
    }
}