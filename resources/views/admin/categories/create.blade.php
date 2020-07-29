@extends('layouts.app')

@section('content')

@component('admin.components.breadcrumb')
@slot('title') Новая категория @endslot
@slot('parent') Главная @endslot
@slot('active') Категории @endslot
@endcomponent

<form action="{{route('admin.category.store')}}" method="post">
@csrf
@include('admin.categories.partials.form')
</form>

@endsection