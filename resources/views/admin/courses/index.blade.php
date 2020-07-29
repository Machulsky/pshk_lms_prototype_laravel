@extends('layouts.app')

@section('content')

@component('admin.components.breadcrumb')
@slot('title') Список курсов @endslot
@slot('parent') Главная @endslot
@slot('active') Курсы @endslot
@endcomponent



<a href="{{route('admin.course.create')}}" class="btn btn-primary"><i class="fa fa-plus-square-o"></i> Создать курс</a>

<table class="table table-striped mt-4">
<thead>
    <th>ID</th>
    <th>Название</th>
    <th>Тем</th>
    <th>Подписок</th>
    <th >Действие</th>
</thead>
<tbody>
@forelse ($courses as $course)
<tr>
    <td>{{$course->id}}</td>
    <td>{{$course->title}}</td>
    <td>{{$course->lessons()->count() ?? ''}}</td>
    <td>{{$course->followers()->count()}}</td>
    <td>

    <form onsubmit="if(confirm('Удалить курс {{$course->title}}?') ){return true}else{return false}" action="{{route('admin.course.destroy', $course)}}" method="post">
        @csrf
        <input type="hidden" name="_method" value="DELETE">
        <a class="btn btn-sm btn-primary" href="{{route('admin.course.show', $course)}}" >Управление</a>
        <a class="btn btn-sm" href="{{route('admin.course.edit', $course)}}" style="color:green"><i class="fa fa-edit"></i></a>

        <button class="btn btn-sm " style="color:red"><i class="fa fa-times"></i></button>
    </form>

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
        <ul class="pagination pull-right">
        {{$courses->links()}}
        </ul>

    </td>
</tr>
</tfoot>
</table>

@endsection
