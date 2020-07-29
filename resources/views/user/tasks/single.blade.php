@extends('layouts.app')

@section('content')

@component('user.components.breadcrumb')
@slot('title') {{$task->title}} @endslot
@slot('parent') <a href="/student/course/{{$task->lesson->course->id ?? ''}}">{{$task->lesson->course->title ?? ''}}</a> @endslot
@slot('active') {{$task->title}} @endslot
@endcomponent
{!!$task->description!!}
@foreach ($task->attachments as $attachment)
<li><a href="{{$attachment->url}}">{{$attachment->name}}</a></li>
@endforeach
<hr>
@if($task->answerType != null)
@include('user.answers.edit')
@else
<h5>Ответ не требуется</h5>
@endif

@endsection
