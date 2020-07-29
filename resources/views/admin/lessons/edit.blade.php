@extends('layouts.app')

@section('content')

@component('admin.components.breadcrumb')
@slot('title') {{$course->title}}: {{$lesson->title ?? 'новая тема' }} @endslot
@slot('parent') Главная @endslot
@slot('active') Курсы @endslot
@endcomponent

<form action="{{route('admin.lesson.update', $lesson)}}" method="post">

    <input type="hidden" name="redirects_to" value="{{URL::previous()}}">
<input type="hidden" name="_method" value="put">
@csrf
@include('admin.lessons.partials.form')
<input type="hidden" name="created_by" value="{{Auth::id()}}">

</form>

@endsection
