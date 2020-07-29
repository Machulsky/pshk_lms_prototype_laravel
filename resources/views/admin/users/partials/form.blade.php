@isset($user->id)
<label for="">Принадлежит пользователю (менять только при переводе студента к другому куратору)</label>
<input type="number" name="created_by" value="{{$user->created_by ?? ''}}" class="form-control">
@endisset
<label for="">Логин</label>
<input @if(Auth::user()->hasRole('teacher')) readonly @endif type="text" class="form-control" name="username" placeholder="Логин" value="{{$user->username ?? 'student'.substr(rand()+rand()+time(),0,5)}}" required>

<label for="">Пароль</label>
<input  @if(Auth::user()->hasRole('teacher') && !isset($user->id)) readonly @endif type="text" class="form-control" required name="password" value="{{$user->password ?? substr(rand()+rand()+time(),0,8) }}">

<label for="">Фамилия</label>
<input type="text" class="form-control" required name="lastname" value="{{$user->lastname ?? ''}}">

<label for="">Имя</label>
<input type="text" class="form-control" required name="firstname" value="{{$user->firstname ?? ''}}">

<label for="">Отчество</label>
<input type="text" class="form-control" name="patronym" value="{{$user->patronym ?? ''}}">

@if(Auth::user()->hasRole('admin'))
<label for="">Роль</label>
<select name="role" id="role" class="form-control">
    @inject('Role', 'App\Role')
   @foreach($Role::all() as $role)
    <option value="{{ $role->id }}">{{ $role->displayname }}</option>
    @endforeach
</select>
@else
<input type="hidden" name="role" value="3">
@endif

<label for="">E-mail</label>
<input type="text" class="form-control" name="email" value="{{$user->email ?? ''}}">

<label for="">Укажите принадлежность к курсу</label>
<select name="categories[]" id="" class="form-control" multiple style="height:300px;" @if(Auth::user()->hasRole('teacher'))required @endif>
@include('admin.users.partials.categories-list', ['categories' => $categories])
</select>


<input type="submit" class="btn btn-primary mt-4" value="Сохранить">
