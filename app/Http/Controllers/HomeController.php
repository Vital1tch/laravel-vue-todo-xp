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

    public function addHabit(Request $request)
    {
        $habit = Habit::create([
            'name' => $request->input('name'),
            'completion_count' => 0,
        ]);

        return redirect()->route('Home');
    }

    public function completeTask($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        // Получаем текущий опыт и уровень из сессии
        $experience = session('experience', 0);
        $level = session('level', 1);

        $experienceGained = 10; // Количество опыта за выполнение задачи
        $experience += $experienceGained;

        // Опыт, необходимый для повышения уровня
        $levelupExperience = 100;

        // Проверка на повышение уровня
        while ($experience >= $levelupExperience)
        {
            $experience -= $levelupExperience;
            $level++;
            $levelupExperience *= 1.5;
        }

        // Сохраняем обновленный опыт и уровень в сессии
        session(['experience' => $experience, 'level' => $level]);

        return redirect()->route('Home');
    }

    public function addExperienceForHabit(Request $request)
    {
        $habitId = $request->input('habitId');
        $experienceGained = $request->input('experienceGained', 10);

        $habit = Habit::findOrFail($habitId);
        $habit->increment('completion_count');

        // Получаем текущий опыт и уровень из сессии
        $experience = session('experience', 0);
        $level = session('level', 1);

        $experience += $experienceGained;

        // Опыт, необходимый для повышения уровня
        $levelupExperience = 30;

        // Проверка на повышение уровня
        while ($experience >= $levelupExperience) {
            $experience -= $levelupExperience;
            $level++;
            $levelupExperience *= 1.5;
        }

        // Сохраняем обновленный опыт и уровень в сессии
        session(['experience' => $experience, 'level' => $level]);

        return response()->json(['experience' => $experience, 'level' => $level, 'completion_count' => $habit->completion_count]);
    }

    public function resetProgress()
    {
        session(['experience' => 0, 'level' => 1]);

        return response()->json(['message' => 'Progress reset successfully']);
    }

    public function destroyTask(Task $task)
    {
        $task->delete();

        return redirect()->back()->with('success', 'Задача успешно удалена');
    }

    public function destroyHabit(Habit $habit)
    {
        $habit->delete();

        return redirect()->back()->with('success', 'Привычка успешно удалена');
    }

    public function updateHabit(Request $request, Habit $habit)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $habit->update($validatedData);

        return redirect()->back()->with('success', 'Habit updated successfully');
    }

    public function updateTask(Request $request, Task $task)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $task->update($validatedData);

        return redirect()->back()->with('success', 'Task updated successfully');
    }
}
