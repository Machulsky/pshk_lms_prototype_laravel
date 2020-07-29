@extends('layouts.app')

@section('content')

@component('admin.components.breadcrumb')
@slot('title') {{$course->title}} @endslot
@slot('parent') Главная @endslot
@slot('active') Курсы @endslot
@endcomponent
<form action="{{route('admin.lesson.store')}}" method="post">
@csrf
<input type="hidden" name="created_by" value="{{Auth::id()}}">
<input type="hidden" name="course_id" value="{{$course->id ?? 0}}">
<input type="hidden" name="slug"  class="form-control" value="{{$lesson->slug ?? ''}}" readonly>
<button class="btn btn-primary mb-4">Добавить тему</button>
<a href="/course/{{$course->id ?? 0}}/clean" class="btn btn-secondary mb-4">Очистить пустые</a>
<ul class="pagination pull-right mt-2">
    {{$lessons->links()}}
    </ul>
</form>


@foreach ($lessons as $lesson)
<span style="font-size: 1.640625rem;">{{$lesson->title}}</span>
<form action="{{route('admin.task.store')}}" method="post" style="display:inline-block!important;">
    @csrf
    <input type="hidden" name="created_by" value="{{Auth::id()}}">
    <input type="hidden" name="lesson_id" value="{{$lesson->id ?? 0}}">
    <button class="btn btn-primary btn-sm"><i class="fa fa-plus-square"></i></button>
</form>
<form style="display:inline-block!important;"  onsubmit="if(confirm('Удалить тему {{$lesson->title}}?') ){return true}else{return false}" action="{{route('admin.lesson.destroy', $lesson)}}" method="post">

    @csrf
    <input type="hidden" name="_method" value="DELETE">
    <a class="btn btn-sm btn-outline-success" href="{{route('admin.lesson.edit', $lesson)}}"><i class="fa fa-edit"></i></a>

    <button class="btn btn-sm btn-outline-danger" ><i class="fa fa-times"></i></button>
</form>







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
<td class="table-cell p-1" style="min-width:100px !important; font-size:.9375rem;"><a href="/task/{{$task->id}}">{{$task->title}}</a> </td>

<td class="table-cell p-1 pull-right">
<form onsubmit="if(confirm('Удалить задание {{$task->title}}?') ){return true}else{return false}" action="{{route('admin.task.destroy', $task)}}" method="post">
        @csrf
        <input type="hidden" name="_method" value="DELETE">
        <a class="btn btn-sm btn-outline-success" href="{{route('admin.task.edit', $task)}}"><i class="fa fa-edit"></i></a>

        <button class="btn btn-sm btn-outline-danger" ><i class="fa fa-times"></i></button>
    </form>
</td>
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
