
@if (!\Session::has('credentials'))
<label for="">ФИО студентов через пробел, новый студент с новой строки</label>
<textarea name="users" id="" style="min-height:200px;" class="form-control" required></textarea>

<label for="">Укажите принадлежность к курсу</label>
<select name="categories[]" id="" class="form-control" multiple style="height:300px;" @if(Auth::user()->hasRole('teacher'))required @endif>
@include('admin.users.partials.categories-list', ['categories' => $categories])
</select>


<input type="submit" class="btn btn-primary mt-4" value="Сохранить">
@else

@foreach (\Session::get('credentials') as $k => $m)
<a href="/user" class="btn btn-primary">Вернуться назад</a>
<h2>Обязательно сохраните эти данные</h2>
    <table class="table table-striped">
        <thead>
            <th>ID</th>
            <th>ФИО</th>
            <th>Логин</th>
            <th>Пароль</th>
        </thead>
        <tbody>
            @foreach($m as $u)
                <tr>
                    <td>{{$u->id}}</td>
                    <td>{{$u->lastname}} {{$u->firstname}} {{$u->patronym}}</td>
                <td>{{$u->username}}</td>
                <td>{{$u->pass}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endforeach

@endif
