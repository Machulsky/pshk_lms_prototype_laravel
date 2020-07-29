@extends('layouts.app')

@section('content')

@component('admin.components.breadcrumb')
@slot('title') {{$course->title ?? 'Новая тема'}}: {{$lesson->title ?? 'новая тема' }} @endslot
@slot('parent') Главная @endslot
@slot('active') Курсы @endslot
@endcomponent

<form action="{{route('admin.lesson.store')}}" method="post">
    <input type="hidden" name="redirects_to" value="{{URL::previous()}}">
@csrf
@include('admin.lessons.partials.form')
<input type="hidden" name="created_by" value="{{Auth::id()}}">
<input type="hidden" name="course_id" value="{{$course->id ?? 0}}">
</form>

@endsection
