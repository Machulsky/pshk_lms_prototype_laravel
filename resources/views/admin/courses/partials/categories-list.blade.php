@foreach($categories as $course_list)
<option value="{{$course_list->id ?? ''}}"
@isset($course->id)
    @foreach($course->categories as $category_course)
        @if($course_list->id == $category_course->id)
            selected="selected"
        @endif
    @endforeach
@endisset
@if(count($course_list->children) > 0)
disabled
@endif
>
{!! $delimiter ?? "" !!}{{$course_list->title ?? ""}}

@if(count($course_list->children) > 0)
    @include('admin.courses.partials.categories-list', [
        'categories' => $course_list->children,
        'delimiter' => ' - '. $delimiter
    ])
@endif

</option>

@endforeach
