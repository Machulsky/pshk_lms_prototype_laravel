@extends('layouts.app')

@section('content')

@component('admin.components.breadcrumb')
@slot('title') Редактирование категории @endslot
@slot('parent') Главная @endslot
@slot('active') Категории @endslot
@endcomponent

<form action="{{route('admin.category.update', $category)}}" method="post">
<input type="hidden" name="_method" value="put">
@csrf
@include('admin.categories.partials.form')
</form>

@endsection