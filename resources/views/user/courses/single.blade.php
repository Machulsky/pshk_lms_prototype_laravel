@extends('layouts.app')

@section('content')

@component('admin.components.breadcrumb')
@slot('title') {{$course->title}} @endslot
@slot('parent') Главная @endslot
@slot('active') Курсы @endslot
@endcomponent

{{-- <div>
    @if($course->followers()->where('id', Auth::id())->first() == null)
    <a href="/student/course/{{$course->id}}/enroll" class="btn btn-primary btn-sm">Подписаться</a>
    @else
    <a href="/student/course/{{$course->id}}/unenroll" class="btn btn-secondary btn-sm">Отписаться</a>
    @endif
</div> --}}

@foreach ($lessons as $lesson)
<span style="font-size: 1.640625rem;">{{$lesson->title}}</span>








{!! $lesson->description !!}


@foreach($lesson->attachments as $attachment)
    <li class="m-1"><a href="{{$attachment->url}}" target="_blank">{{$attachment->name}}</a></li>
@endforeach




<!-- <a href="{{route('admin.task.create', ['lesson'=>$lesson])}}" class="btn btn-primary mb-4 btn-sm">Добавить задание</a> -->

<table class="table-striped tasks" style="">

<tbody>
@foreach($lesson->tasks as $task)
<tr>
<td class="table-cell p-1"><i class="fa fa-graduation-cap"></i></td>
<td class="table-cell p-1" style="min-width:200px !important; font-size:.9375rem;"><a href="/student/task/{{$task->id}}">{{$task->title}}</a> </td>
</tr>
@endforeach
</tbody>
</table>


<hr>
@endforeach
<ul class="pagination pull-right mt-2">
    {{$lessons->links()}}
    </ul>
@endsection
