@extends('layouts.app')

@section('content')

@component('admin.components.breadcrumb')
@slot('title') Список категорий @endslot
@slot('parent') Главная @endslot
@slot('active') Категории @endslot
@endcomponent



<a href="{{route('admin.category.create')}}" class="btn btn-primary"><i class="fa fa-plus-square-o"></i> Создать категорию</a>

<table class="table table-striped mt-4">
<thead>
    <th>ID</th>
    <th>Название</th>
    <th>Уникальный тег</th>
    <th>Опубликована</th>
    <th class="text-right">Действие</th>
</thead>
<tbody>
@forelse ($categories as $category)
<tr>
    <td>{{$category->id}}</td>
    <td>{{$category->title}}</td>
    <td>{{$category->slug}}</td>
    <td>{{$category->published}}</td>
    <td>
  
    <form onsubmit="if(confirm('Удалить категорию {{$category->title}}?') ){return true}else{return false}" action="{{route('admin.category.destroy', $category)}}" method="post">
        @csrf
        <input type="hidden" name="_method" value="DELETE">
        <a class="btn btn-sm" href="{{route('admin.category.edit', $category)}}" style="color:green"><i class="fa fa-edit"></i></a>
        <button class="btn btn-sm " style="color:red"><i class="fa fa-times"></i></button>
    </form>
   
    </td>
</tr>
@empty
    <tr>
    <td colspan="5" class="text-center">Нет категорий</td>
    </tr>
@endforelse

</tbody>
<tfoot>
<tr>
    <td colspan="5">
        <ul class="pagination pull-right">
        {{$categories->links()}}
        </ul>
    
    </td>
</tr>
</tfoot>
</table>

@endsection