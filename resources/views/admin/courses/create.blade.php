@extends('layouts.app')

@section('content')

@component('admin.components.breadcrumb')
@slot('title') Новый курс @endslot
@slot('parent') Главная @endslot
@slot('active') Курсы @endslot
@endcomponent

<form action="{{route('admin.course.store')}}" method="post">
@csrf
@include('admin.courses.partials.form')
<input type="hidden" name="created_by" value="{{Auth::id()}}">
</form>

@endsection