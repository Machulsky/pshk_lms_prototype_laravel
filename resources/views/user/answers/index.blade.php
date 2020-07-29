@extends('layouts.app')

@section('content')

@component('admin.components.breadcrumb')
@slot('title') Мои ответы @endslot
@slot('parent') Главная @endslot
@slot('active') Ответы @endslot
@endcomponent



<table class="table table-striped mt-4">
<thead>
    <th>Дисциплина</th>
    <th>Тема</th>
    <th>Задание</th>
    <th>Преподаватель</th>
    <th>Дата</th>
    <th>Оценка</th>
</thead>
<tbody>
@forelse ($answers as $answer)
<tr>
    <td>{{$answer->task->lesson->course->title ?? ''}}</td>
    <td>{{$answer->task->lesson->title ?? ''}}</td>
    <td>
        <a href="/student/task/{{$answer->task->id ?? ''}}" target="_blank">{{$answer->task->title ?? ''}}</a>
    </td>
    <td>
        {{$answer->task->lesson->course->user->lastname ?? ''}}
        {{$answer->task->lesson->course->user->firstname ?? ''}}
        {{$answer->task->lesson->course->user->patronym ?? ''}}
    </td>
    <td>
        {{$answer->updated_at ?? ''}}
    </td>
<td>{{$answer->mark ?? ''}}</td>



</tr>
@empty
    <tr>
    <td colspan="6" class="text-center">Нет ответов</td>
    </tr>
@endforelse

</tbody>
<tfoot>
<tr>
    <td colspan="5">
        @if($answers != [])
        <ul class="pagination pull-right">
            {{$answers->links() ?? ''}}
        </ul>
        @endif

    </td>
</tr>
</tfoot>
</table>

@endsection
