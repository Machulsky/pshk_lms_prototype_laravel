@extends('layouts.app')

@section('content')

@component('admin.components.breadcrumb')
@slot('title') Новый пользователь @endslot
@slot('parent') Главная @endslot
@slot('active') Пользователи @endslot
@endcomponent

<form action="{{route('admin.user.store')}}" method="post">
@csrf
@include('admin.users.partials.form')

</form>

@endsection
