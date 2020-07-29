<label for="">Название</label>
<input type="text" class="form-control" name="title" placeholder="Название темы" value="{{$lesson->title ?? ''}}" required>

<label for="">Краткое описание</label>

<textarea name="description" id="description" cols="30" rows="10" class="form-control summernote">{{$lesson->description ?? ''}}</textarea>



<label for="">Принадлежит курсу</label>
<select name="course_id" id="" class="form-control">
@foreach($courses as $course_list)
<option value="{{$course_list->id}}" 
@isset($course->id)
    @if($course_list->id == $course->id)
        selected=""
    @endif
    @endisset
    > {{$course_list->title}} </option>

@endforeach 
</select>
@include('admin.lessons.partials.filemanager')


<input type="hidden" name="slug"  class="form-control" value="{{$lesson->slug ?? ''}}" readonly>


<label for="">Статус</label>
<select name="published" class="form-control" id="">
@if(isset($lesson->id))
<option value="0" @if($lesson->published == 0) selected="true" @endif>Не опубликована</option>
<option value="1" @if($lesson->published == 1) selected="true" @endif>Опубликована</option>
@else
<option value="0" >Не опубликована</option>
<option value="1" selected="true" >Опубликована</option>
@endif
</select>

<input type="submit" class="btn btn-primary mt-4" value="Сохранить">
