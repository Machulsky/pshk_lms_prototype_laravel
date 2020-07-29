
   <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">

      <div class="list-group list-group-flush">
        @if (Auth::user()->hasRole('admin'))
        <a href="{{route('admin.category.index')}}" class="list-group-item list-group-item-action bg-light">Категории</a>
        @endif
        @if (Auth::user()->hasRole('teacher') or Auth::user()->hasRole('admin'))
        <a href="{{route('admin.course.index')}}" class="list-group-item list-group-item-action bg-light">Курсы</a>
        <a href="{{route('admin.user.index')}}" class="list-group-item list-group-item-action bg-light">Пользователи</a>
        <a href="/filemanager" class="list-group-item list-group-item-action bg-light" target="_blank">Мои файлы</a>
        @endif
        @if (Auth::user()->hasRole('student'))
        <a href="{{route('student.course.index')}}" class="list-group-item list-group-item-action bg-light">Курсы</a>
        <a href="{{route('student.answer.index')}}" class="list-group-item list-group-item-action bg-light">Мои ответы</a>
        <a href="{{route('student.task.index')}}" class="list-group-item list-group-item-action bg-light">Новые задания</a>
        @endif
      </div>
    </div>
    <!-- /#sidebar-wrapper -->
