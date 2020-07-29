<label for="">Название</label>
<input type="text" class="form-control" name="title" placeholder="Название задания" value="{{$task->title ?? ''}}" required>

<label for="">Краткое описание</label>

<textarea name="description" id="description" cols="30" rows="10" class="form-control summernote">{!! $task->description ?? ''!!}</textarea>

@include('admin.tasks.partials.filemanager')
<label for="">Тип ответа</label>
<select name="answer_type" class="form-control">
    @if(isset($task->answerType))
    <option value="null">Не требует ответа</option>
    <option @if($task->answerType->name  == 'text') selected @endif  value="text">Текстовый ответ</option>
    <option @if($task->answerType->name  == 'file') selected @endif  value="file">Ответ файлами</option>
    <option @if($task->answerType->name  == 'textfile') selected @endif  value="textfile">Текст + файлы</option>
    @else
    <option selected value="null">Не требует ответа</option>
    <option  value="text">Текстовый ответ</option>
    <option  value="file">Ответ файлами</option>
    <option  value="textfile">Текст + файлы</option>
    @endif
</select>
<label for="">Кол-во файлов в ответе</label>
<input type="number" name="max_files" value="{{$task->answerType->max_files ?? 0}}" class="form-control">
<label for="">Кол-во символов в ответе</label>
<input type="number" name="max_symbols" value="{{$task->answerType->max_symbols ?? 0}}" class="form-control">
<input type="submit" class="btn btn-primary mt-4" value="Сохранить">
