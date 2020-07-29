<label for="">Название</label>
<input type="text" class="form-control" name="title" placeholder="Название категории" value="{{$category->title ?? ''}}" required>

<label for="">Уникальный тег</label>
<input type="text" name="slug"  class="form-control" value="{{$category->slug ?? ''}}" readonly>

<label for="">Родительская категория</label>
<select name="parent_id" id="" class="form-control">
<option value="0">-- без родительской категории --</option>
@include('admin.categories.partials.categories-list', ['categories' => $categories])
</select>

<label for="">Статус</label>
<select name="published" class="form-control" id="">
@if(isset($category->id))
<option value="0" @if($category->published == 0) selected="true" @endif>Не опубликована</option>
<option value="1" @if($category->published == 1) selected="true" @endif>Опубликована</option>
@else
<option value="0" >Не опубликована</option>
<option value="1" selected="true" >Опубликована</option>
@endif
</select>

<input type="submit" class="btn btn-primary mt-4" value="Сохранить">