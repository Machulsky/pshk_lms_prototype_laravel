<?php

namespace App\Http\Controllers;

use App\Course;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Auth::user()->categories()->first();
        if($category != null)
        return view('user.courses.index', [
            'courses' => $category->courses()->orderBy('created_at', 'desc')->paginate(10)
        ]);
        return view('user.courses.index', [
            'courses' => []
        ]);



        //
    }

    public function enroll($course_id)
    {

        $user = Auth::user();
        $course = $user->categories()->first()->courses()->where('id', $course_id)->first();
        if($course != null){
            $user->courses()->attach($course_id);
            return redirect()->back()->with('success', ['Вы подписались на новые задания курса '.$course->title]);
        }else{
            return redirect()->back()->with('error', ['Вам недоступен этот курс!']);
        }
    }

    public function unenroll($course_id)
    {
        $user = Auth::user();
        $user->courses()->detach($course_id);
        return redirect()->back()->with('success', ['Вы отписались от заданий курса']);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        if(Auth::user()->categories()->first() != null){
            $cid = Auth::user()->categories()->first()->id;

            $check = $course->categories()->where('id', $cid)->first();

        }else{
            $check = null;
        }


        if($check != null)
        return view('user.courses.single', ['course'=>$course, 'lessons'=>$course->lessons()->paginate(15)]);

        return redirect('/student/course')->with('error', ['У вас нет доступа к этому курсу!']);

        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
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
        //
    }
}
