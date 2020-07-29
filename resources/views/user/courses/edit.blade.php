@extends('layouts.app')

@section('content')

@component('admin.components.breadcrumb')
@slot('title') Редактировать курс @endslot
@slot('parent') Главная @endslot
@slot('active') Курсы @endslot
@endcomponent

<form action="{{route('admin.course.update', $course)}}" method="post">

@csrf
<input type="hidden" name="_method" value="put">
@include('admin.courses.partials.form')
<input type="hidden" name="modified_by" value="{{Auth::id()}}">
</form>

@endsection
