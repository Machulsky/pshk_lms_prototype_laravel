@extends('layouts.app')

@section('content')

@component('admin.components.breadcrumb')
@slot('title') Список пользователей @endslot
@slot('parent') Главная @endslot
@slot('active') Пользователи @endslot
@endcomponent



<a href="{{route('admin.user.create')}}" class="btn btn-primary"><i class="fa fa-plus-square-o"></i> Создать пользователя</a>
<a href="{{route('admin.user.create.multiple')}}" class="btn btn-success"><i class="fa fa-plus-square-o"></i> Создать много пользователей</a>
<table class="table table-striped mt-4">
<thead>
    <th>ID</th>
    <th>ФИО</th>
    <th>Логин</th>
    <th>Роль</th>
    <th class="text-right">Действие</th>
</thead>
<tbody>
@forelse ($users as $user)
<tr>
    <td>{{$user->id}}</td>
<td>{{$user->lastname}} {{$user->firstname}} {{$user->patronym}}</td>
    <td>{{$user->username}}</td>
<td>{{$user->role()->first()->displayname ?? ''}}</td>

    <td>

    <form onsubmit="if(confirm('Удалить пользователя {{$user->username}}?') ){return true}else{return false}" action="{{route('admin.user.destroy', $user)}}" method="post">
        @csrf
        <input type="hidden" name="_method" value="DELETE">
        <a class="btn btn-sm" href="{{route('admin.user.edit', $user)}}" style="color:green"><i class="fa fa-edit"></i></a>
        <button class="btn btn-sm " style="color:red"><i class="fa fa-times"></i></button>
    </form>

    </td>
</tr>
@empty
    <tr>
    <td colspan="5" class="text-center">Нет пользователей</td>
    </tr>
@endforelse

</tbody>
<tfoot>
<tr>
    <td colspan="5">
        <ul class="pagination pull-right">
        {{$users->links()}}
        </ul>

    </td>
</tr>
</tfoot>
</table>

@endsection
