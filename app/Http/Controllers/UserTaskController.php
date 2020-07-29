<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Auth::user()->categories()->first();
        $courses = $category->courses()->orderBy('created_at', 'desc')->get();
        $tasks = collect();
        foreach($courses as $course){
            if($course->followers()->where('id', Auth::id())->first() != null){
                foreach($course->lessons as $lesson){
                    foreach($lesson->tasks as $task){

                            if($task->answers()->where('user_id', Auth::id())->first() == null){
                                if($task->answer_type_id != null)
                                $tasks->add($task);
                            }

                    }
                }
            }
        }

        return view('user.tasks.index', ['tasks' => $tasks->all()]);
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return view('user.tasks.single', [
            'task' => $task,
            'lesson'=>$task->lesson ?? '',
            'course'=>$task->lesson->course ?? '',
            'answers' =>$task->answers()->paginate(10) ?? '',
            'myAnswer' => $task->answers()->where('user_id', Auth::id())->first() ?? ''
            ]);
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }
}
