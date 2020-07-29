@extends('layouts.app')

@section('content')

@component('admin.components.breadcrumb')
@slot('title') {{$lesson->title}}: {{$task->title ?? 'новое задание' }} @endslot
@slot('parent') Главная @endslot
@slot('active') Курсы @endslot
@endcomponent

<form action="{{route('admin.task.update', $task)}}" method="post">
    <input type="hidden" name="redirects_to" value="{{URL::previous()}}">
<input type="hidden" name="_method" value="put">
@csrf
@include('admin.tasks.partials.form')
<input type="hidden" name="created_by" value="{{Auth::id()}}">

</form>

@endsection
