<label for="">Название</label>
<input type="text" class="form-control" name="title" placeholder="Название курса" value="{{$course->title ?? ''}}" required>

<label for="">Краткое описание</label>
<textarea name="description" id="description" cols="30" rows="10" class="form-control summernote">{{$course->description ?? ''}}</textarea>

<label for="">Уникальный тег</label>
<input type="text" name="slug"  class="form-control" value="{{$course->slug ?? ''}}" readonly>

<label for="">Категории</label>
<select name="categories[]" id="" class="form-control" multiple style="height:300px;">
<option value="0">-- без категории --</option>
@include('admin.courses.partials.categories-list', ['categories' => $categories])
</select>

<label for="">Статус</label>
<select name="published" class="form-control" id="">
@if(isset($course->id))
<option value="0" @if($course->published == 0) selected="true" @endif>Не опубликована</option>
<option value="1" @if($course->published == 1) selected="true" @endif>Опубликована</option>
@else
<option value="0" >Не опубликована</option>
<option value="1" selected="true" >Опубликована</option>
@endif
</select>

<input type="submit" class="btn btn-primary mt-4" value="Сохранить">