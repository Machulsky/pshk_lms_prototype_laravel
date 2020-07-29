<?php

namespace App\Http\Controllers;

use App\Task;
use App\Course;
use App\Lesson;
use App\AnswerType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        $task= Task::create($request->all());

        return redirect('/task/'.$task->id.'/edit')->with('success', ['Задание успешно создано!']);
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
        return view('admin.tasks.single', [
            'task' => $task,
            'lesson'=>$task->lesson,
            'course'=>$task->lesson->course,
            'answers' =>$task->answers()->orderBy('locked', 'asc')->paginate(10),
            'myAnswer' => $task->answers()->where('user_id', Auth::id())->first()
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
        if(Auth::user()->hasRole('admin')){
            return view('admin.tasks.edit', [
                'lesson' => $task->lesson()->first(),
                'task' => $task,

                 ]);

        }elseif(Auth::id() == Course::find($task->lesson()->first()->course_id)->created_by){
            return view('admin.tasks.edit', [
                'lesson' => $task->lesson()->first(),
                'task' => $task,
                'answer_type' => $task->answerType
                 ]);
             }
        return redirect()->route('admin.course.index')->with('error', ['Недостаточно прав для редактирования задания!']);
        //
    }

    public function updateAnswerType(Request $request, Task $task){
        switch ($request->input('answer_type')){
            case 'text':
                $task->answerType()->update([
                    'name'=>'text',
                    'displayname'=>'Текстовый ответ',
                    'max_symbols'=>$request->input('max_symbols'),

                    ]);

            break;
            case 'file':
                $task->answerType()->update([
                    'name'=>'file',
                    'displayname'=>'Ответ файлом',
                    'max_files'=>$request->input('max_files'),

                    ]);

            break;
            case 'textfile':
                $task->answerType()->update([
                    'name'=>'textfile',
                    'displayname'=>'Ответ текстом с файлами',
                    'max_files'=>$request->input('max_files'),
                    'max_symbols'=>$request->input('max_symbols'),

                    ]);
            break;
            case 'null':
                $task->answerType()->delete();
        }
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

        if(Auth::user()->hasRole('admin') or Auth::id() == Course::find($task->lesson()->first()->course_id)->created_by){
            $task->update($request->all());
            if($task->answerType == null){
                switch ($request->input('answer_type')){
                    case 'text':
                        $answerType = AnswerType::create([
                            'name'=>'text',
                            'displayname'=>'Текстовый ответ',
                            'max_symbols'=>$request->input('max_symbols'),
                            'task_id'=>$task->id
                            ]);
                        $task->update(['answer_type_id' => $answerType->id]);
                    break;
                    case 'file':
                        $answerType = AnswerType::create([
                            'name'=>'file',
                            'displayname'=>'Ответ файлом',
                            'max_files'=>$request->input('max_files'),
                            'task_id'=>$task->id
                            ]);
                        $task->update(['answer_type_id' => $answerType->id]);
                    break;
                    case 'textfile':
                        $answerType = AnswerType::create([
                            'name'=>'textfile',
                            'displayname'=>'Ответ текстом с файлами',
                            'max_files'=>$request->input('max_files'),
                            'max_symbols'=>$request->input('max_symbols'),
                            'task_id'=>$task->id
                            ]);
                        $task->update(['answer_type_id' => $answerType->id]);
                    break;
                }
            }else{
                $this->updateAnswerType($request, $task);
            }

            return redirect('/course/'.$task->lesson()->first()->course_id)->with('success', ['Изменения успешно сохранены!']);
        }
        return redirect()->route('admin.course.index')->with('error', ['Недостаточно прав для редактирования темы!']);
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
        if(Auth::user()->hasRole('admin') or Auth::id() == Course::find($task->lesson()->first()->course_id)->created_by){
            $cid = $task->lesson->course_id;
            $task->answerType()->delete();
            $task->answers()->delete();
            $task->delete();
            $task->attachments()->delete();
            return redirect('/course/'.$cid)->with('success', ['Задание успешно удалено!']);
            }

            return redirect()->route('admin.course.index')->with('error', ['Недостаточно прав для удаления задания!']);
            //

        //
    }
}
