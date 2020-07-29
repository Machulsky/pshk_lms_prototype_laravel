
@if($myAnswer == null)
    @if($task->answerType->name == 'text')

<form action="{{route('admin.answer.store')}}" method="post">
    @csrf
    <input type="hidden" name="user_id" value="{{Auth::id()}}">
    <input type="hidden" name="task_id" value="{{$task->id}}">
    <label for="">{{$task->answerType->displayname}}</label>
    <textarea name="text" id="description" class="form-control" value=""></textarea>
    <button class="btn btn-primary ">Сохранить ответ</button>
    </form>
    @endif

    @if($task->answerType->name == 'file' or $task->answerType->name == 'textfile')

    <form action="{{route('admin.answer.store')}}" method="post">
        @csrf
        <input type="hidden" name="user_id" value="{{Auth::id()}}">
        <input type="hidden" name="task_id" value="{{$task->id}}">
        <button class="btn btn-primary ">Добавить ответ</button>
    </form>
    @endif
@else
<form  id="delete" style="display:none;" onsubmit="if(confirm('Удалить ваш ответ?') ){return true}else{return false}" action="{{route('admin.answer.destroy', $myAnswer)}}" method="post">
    <input type="hidden" name="_method" value="DELETE">
    @csrf

</form>
    @if($task->answerType->name == 'text')

    <form action="{{route('admin.answer.update', $myAnswer)}}" method="post">
        @csrf
        <input type="hidden" name="_method" value="put">
    <label for="">{{$task->answerType->displayname}}</label>

    <textarea name="text" id="description" class="form-control" >
        {!!$myAnswer->text ?? '' !!}
    </textarea>

    <button class="btn btn-primary mt-2">Сохранить ответ</button>
    <a href="#" class="btn btn-danger mt-2" onclick="$('#delete').submit()">Удалить ответ</a>
    </form>

    @endif
    @if($task->answerType->name == 'file')
        @include('admin.answers.partials.filemanager')
        <a href="#" class="btn btn-danger" onclick="$('#delete').submit()">Удалить ответ</a>
    @endif
    @if($task->answerType->name == 'textfile')
    <form action="{{route('admin.answer.update', $myAnswer)}}" method="post">
        @csrf
        <input type="hidden" name="_method" value="put">
    <label for="">{{$task->answerType->displayname}}</label>

    <textarea name="text" id="description" class="form-control" >
        {!!$myAnswer->text ?? '' !!}
    </textarea>
    @include('admin.answers.partials.filemanager')
    <button class="btn btn-primary">Сохранить ответ</button> <a href="#" class="btn btn-danger" onclick="$('#delete').submit()">Удалить ответ</a>
    </form>

    @endif
@endif

