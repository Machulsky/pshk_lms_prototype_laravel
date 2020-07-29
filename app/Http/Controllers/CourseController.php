<?php

namespace App\Http\Controllers;

use App\Course;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->hasRole('admin'))
        return view('admin.courses.index', [
            'courses' => Course::orderBy('created_at', 'desc')->paginate(10)
        ]);

        return view('admin.courses.index', [
            'courses' => Course::where('created_by', Auth::id())->orderBy('created_at', 'desc')->paginate(10)
        ]);
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.courses.create', [
            'course' => [],
            'categories' => Category::with('children')->where('parent_id', 0)->get(),
            'delimiter' => ''
             ]);
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
        $course = Course::create($request->all());

        if($request->input('categories')){
            $course->categories()->attach($request->input('categories'));

        }
        return redirect()->route('admin.course.index')->with('success', ['Курс успешно создан! <a href="/course/'.$course->id.'">Добавить темы</a>']);
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        if(Auth::user()->hasRole('admin') or $course->created_by == Auth::id())
        return view('admin.courses.single', ['course'=>$course, 'lessons'=>$course->lessons()->paginate(100)]);


            return redirect()->route('admin.course.index')->with('error', ['У вас нет доступа к управлению курсом!']);

    }

    public function clean($id)
    {
        $course = Course::find($id);
        $course->lessons()->where('title', NULL)->where('created_by', Auth::id())->delete();
        foreach($course->lessons as $lesson){
            $lesson->tasks()->where('title', NULL)->where('created_by', Auth::id())->delete();
        }

        return redirect('/course/'.$course->id)->with('success', ['Пустые темы и задания очищены!']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        if(Auth::user()->hasRole('admin') or $course->created_by == Auth::id())
        return view('admin.courses.edit', [
            'course' => $course,
            'categories' => Category::with('children')->where('parent_id', 0)->get(),
            'delimiter' => ''
        ]);


            return redirect()->route('admin.course.index')->with('error', ['У вас нет доступа к редактированию этого курса!']);
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        if(Auth::user()->hasRole('admin') or Auth::id() == $course->created_by){
            $course->update($request->except('slug'));
            $course->categories()->detach();
            $course->categories()->attach($request->input('categories'));

            return redirect()->route('admin.course.index')->with('success', ['Изменения успешно сохранены!']);
        }else{
            return redirect()->route('admin.course.index')->with('error', ['У вас нет доступа к редактированию курса!']);
        }

        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        if(Auth::user()->hasRole('admin') or Auth::id() == $course->created_by){
        $course->categories()->detach();
            foreach($course->lessons as $lesson){

                $lesson->tasks()->delete();
                DB::table('tasks')->where('lesson_id', $lesson->id)->delete();
                foreach($lesson->tasks as $task){
                    $task->answers->attachments->delete();
                    $task->answers->delete();
                    $task->answerType->delete();
                    $task->attachments->delete();
                }
            }
            $course->followers()->detach();
            $course->lessons()->delete();
            $course->delete();
        return redirect()->route('admin.course.index')->with('success', ['Курс успешно удален!']);
        }else{
            return redirect()->route('admin.course.index')->with('error', ['У вас нет доступа к удалению курса!']);
        }
        //
    }
}
