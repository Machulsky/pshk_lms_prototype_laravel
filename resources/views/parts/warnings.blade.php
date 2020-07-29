<!-- Position toasts -->
<div style="position: absolute; top: 5px; left:0; right:0; z-index:1; width:400px; margin:0 auto;">
@if (\Session::has('success'))
    
    
    @foreach (\Session::get('success') as $k => $m)
    <div role="alert" aria-live="assertive" aria-atomic="true" class="toast" data-delay="10000">
  <div class="toast-header">
    <strong class="mr-auto ">Успех</strong>
    
    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="toast-body">
   {!! $m !!}
  </div>
</div>
    @endforeach

@endif

@if (\Session::has('error'))

@foreach (\Session::get('error') as $k => $m)
    <div role="alert" aria-live="assertive" aria-atomic="true" class="toast" data-delay="10000">
  <div class="toast-header">
    <strong class="mr-auto text-danger">Ошибка</strong>
    
    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="toast-body  text-danger">
   {!! $m !!}
  </div>
</div>
    @endforeach

@endif
    </div> 