@extends('layouts.app')

@section('content')

@component('admin.components.breadcrumb')
@slot('title') {{$task->title}} @endslot
@slot('parent') <a href="/course/{{$task->lesson->course->id}}">{{$task->lesson->course->title}}</a> @endslot
@slot('active') {{$task->title}} @endslot
@endcomponent
{!!$task->description!!}
@foreach ($task->attachments as $attachment)
<li><a href="{{$attachment->url}}">{{$attachment->name}}</a></li>
@endforeach
<hr>
@if($task->answerType != null)

@else
<h5>Ответ не требуется</h5>
@endif
@if(Auth::user()->hasRole('teacher') or Auth::user()->hasRole('admin') )
@include('admin.answers.index')
@endif
@endsection
