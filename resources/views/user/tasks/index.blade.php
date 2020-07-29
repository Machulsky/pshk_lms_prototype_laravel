@extends('layouts.app')

@section('content')

@component('admin.components.breadcrumb')
@slot('title') Задания без вашего ответа @endslot
@slot('parent') Главная @endslot
@slot('active') Новые задания @endslot
@endcomponent



<table class="table table-striped mt-4">
<thead>

    <th>Задание</th>
    <th>Дисциплина</th>
    <th>Тема</th>
    <th>Преподаватель</th>
    <th>Добавлено</th>
</thead>
<tbody>
@forelse ($tasks as $task)
<tr>

    <td><a href="/student/task/{{$task->id}}" style="font-size:1.2rem" target="_blank">{{$task->title}}</a>

    </td>
    <td>
        {{$task->lesson->course->title}}
    </td>
    <td>
        {{$task->lesson->title}}
    </td>
<td>{{$task->lesson->course->user->lastname}} {{$task->lesson->course->user->firstname}} {{$task->lesson->course->user->patronym}}</td>
<td>{{$task->created_at}}</td>

</tr>
@empty
    <tr>
    <td colspan="5" class="text-center">Нет заданий</td>
    </tr>
@endforelse

</tbody>
<tfoot>
<tr>
    <td colspan="5">
        @if($tasks != [])
        <ul class="pagination pull-right">
        {{-- {{$tasks->links()}} --}}
        </ul>
        @endif

    </td>
</tr>
</tfoot>
</table>

@endsection
