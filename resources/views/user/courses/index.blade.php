@extends('layouts.app')

@section('content')

@component('admin.components.breadcrumb')
@slot('title') Список курсов @endslot
@slot('parent') Главная @endslot
@slot('active') Курсы @endslot
@endcomponent



<table class="table table-striped mt-4">
<thead>
    <th>ID</th>
    <th>Название</th>
    <th>Преподаватель</th>
    <th>Новые задания</th>
</thead>
<tbody>
@forelse ($courses as $course)
<tr>
    <td>{{$course->id}}</td>
    <td><a href="/student/course/{{$course->id}}" style="font-size:1.2rem">{{$course->title}}</a>
    {{-- {!! $course->description !!} --}}
    </td>
<td>{{$course->user->lastname}} {{$course->user->firstname}} {{$course->user->patronym}}</td>
<td>
    @if($course->followers()->where('id', Auth::id())->first() == null)
    <a href="/student/course/{{$course->id}}/enroll" class="btn btn-primary btn-sm">Подписаться</a>
    @else
    <a href="/student/course/{{$course->id}}/unenroll" class="btn btn-secondary btn-sm">Отписаться</a>
    @endif
</td>

</tr>
@empty
    <tr>
    <td colspan="5" class="text-center">Нет курсов</td>
    </tr>
@endforelse

</tbody>
<tfoot>
<tr>
    <td colspan="5">
        @if($courses != [])
        <ul class="pagination pull-right">
        {{$courses->links()}}
        </ul>
        @endif

    </td>
</tr>
</tfoot>
</table>

@endsection
