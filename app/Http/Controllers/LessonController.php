<?php

namespace App\Http\Controllers;

use App\Lesson;
use App\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class LessonController extends Controller
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
    public function create(Request $request)
    {
        if(Auth::user()->hasRole('admin')){
            return view('admin.lessons.create', [
                'lesson' => [],
                'count' => Lesson::all()->last()->id,
                'course' => Course::find($request->input('course')),
                'courses' => Course::all()
                 ]);

        }else{
            return view('admin.lessons.create', [
                'lesson' => [],
                'course' => Course::find($request->input('course')),
                'courses' => Course::all()->where('created_by', Auth::id())
                 ]);

        }

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


        $lesson= Lesson::create($request->all());

        if($request->input('course')){
            $lesson->course()->attach($request->input('course_id'));
        }

        return redirect('/lesson/'.$lesson->id.'/edit')->with('success', ['Тема успешно создана!']);
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function show(Lesson $lesson)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function edit(Lesson $lesson)
    {
        if(Auth::user()->hasRole('admin')){
            return view('admin.lessons.edit', [
                'lesson' => $lesson,
                'course' => Course::find($lesson->course_id),
                'courses' => Course::all()
                 ]);

        }elseif(Auth::id() == Course::find($lesson->course_id)->created_by){
            return view('admin.lessons.edit', [
                'lesson' => $lesson,
                'course' => Course::find($lesson->course_id),
                'courses' => Course::all()->where('created_by', Auth::id())
                 ]);
             }
        return redirect()->route('admin.course.index')->with('error', ['Недостаточно прав для редактирования темы!']);
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lesson $lesson)
    {


        if(Auth::user()->hasRole('admin') or Auth::id() == Course::find($lesson->course_id)->created_by){
            $lesson->update($request->except('slug'));

            return redirect('/course/'.$request->input('course_id'))->with('success', ['Изменения успешно сохранены!']);
        }
        return redirect()->route('admin.course.index')->with('error', ['Недостаточно прав для редактирования темы!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lesson $lesson)
    {
        if(Auth::user()->hasRole('admin') or Auth::id() == Course::find($lesson->course_id)->created_by){
        $cid = $lesson->course_id;
        foreach($lesson->tasks as $task){
            $task->attachments()->delete();
            $task->answers()->delete();
            $task->answerType()->delete();
        }
        $lesson->tasks()->delete();


        $lesson->attachments()->delete();
        $lesson->delete();
        return redirect('/course/'.$cid)->with('success', ['Тема успешно удалена!']);
        }

        return redirect()->route('admin.course.index')->with('error', ['Недостаточно прав для удаления темы!']);
        //
    }
}
