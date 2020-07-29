<?php

namespace App\Http\Controllers;

use App\Course;
use App\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class UserAnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.answers.index', ['answers' => Answer::where('user_id', Auth::id())->paginate(15) ]);
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

        $answer = Answer::create($request->all());
        return redirect()->back()->with('success', ['Ответ создан!']);
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Answer $answer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Answer $answer)
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
    public function update(Request $request, Answer $answer)
    {
        if(!$answer->locked){
            if($answer->user->id == Auth::id()){
                $answer->update($request->all());
                return redirect()->back()->with('success', ['Изменения сохранены']);

            }else{
                return redirect()->back()->with('error', ['Вы не можете удалить чужой ответ!']);
            }

        }else{
            return redirect()->back()->with('error', ['Ответ был заблокирован преподавателем!']);
        }
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Answer $answer)
    {
        if(!$answer->locked){
            if($answer->user->id == Auth::id()){
            $answer->attachments()->delete();
             $answer->delete();
            return redirect()->back()->with('success', ['Ответ удалён']);
         }else{
            return redirect()->back()->with('error', ['Вы не можете удалить чужой ответ!']);
         }
        }else{
            return redirect()->back()->with('error', ['Ответ был заблокирован преподавателем!']);
        }

        //
    }
}
