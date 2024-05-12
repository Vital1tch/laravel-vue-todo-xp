<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(Task $task, Habit $habit)
    {
        return Inertia::render('Home',[
            'tasks' => $task->all(),
            'habits' => $habit->all(),
        ]);
    }

    public function addTask(Request $request)
    {
        $task = new Task();
        $task->name =$request->input('name');
        $task->save();

        return redirect()->route('Home');
    }
}
