
<table class="table table-striped mt-2">
    <thead>
        <th>#</th>
        <th>Пользователь</th>
        <th>Добавлен</th>
        <th>Обновлён</th>
        <th>Ответ</th>
        <th>Оценка</th>

    </thead>

    <tbody>

        @foreach($answers as $answer)
        <div class="modal fade" id="answer{{$answer->id}}" tabindex="-1" role="dialog" aria-labelledby="answer{{$answer->id}}Label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">

                  <h5 class="modal-title" id="answer{{$answer->id}}Label">{{$answer->user->lastname}} {{$answer->user->firstname}} {{$answer->user->patronym}}</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>

                </div>

                <div class="modal-body">


                    <div>
                        {!!$answer->text ?? ''!!}
                    </div>

                  <hr>

                  @foreach($answer->attachments as $attachment)
                <li><a href="{{$attachment->url}}" target="_blank">{{$attachment->name}}</a></li>
                @endforeach
                </div>

              </div>
            </div>
          </div>

        <tr>
            <td>{{$answer->id}}</td>
            <td style="max-width:220px">{{$answer->user->lastname}} {{$answer->user->firstname}} {{$answer->user->patronym}}
                <li>{{mb_substr($answer->user->spec()->title, 0,30)}}...</li>
                <li> {{$answer->user->categories()->first()->title}}</li>

            </td>
        <td>{{$answer->created_at}}</td>
        <td>{{$answer->updated_at}}</td>
            <td>
                <a href="#" class="btn btn-info btn-sm text-white" data-toggle="modal" data-target="#answer{{$answer->id}}">Смотреть ответ</a>
                </td>
                <td>
                    <form action="{{route('admin.answer.update', $answer)}}" method="post">
                        @csrf
                        <input type="hidden" name="_method" value="put">
                        <input style="display:inline-block" type="number" name="mark" class="" min="0" max="5" value="{{$answer->mark ?? 1}}">
                        <select name="locked" id="">

                            <option value="0" @if($answer->locked != 1) selected @endif>Разблокирован</option>
                            <option value="1"  @if($answer->locked == 1) selected @endif>Заблокирован</option>
                        </select>
                        <button style="display:inline-block" class="btn btn-success"><i class="fa fa-check"></i></button>

                    </form>
                </td>
        </tr>


        <form  id="delete-answer-{{$answer->id}}" style="display:none;" onsubmit="if(confirm('Удалить ответ?') ){return true}else{return false}" action="{{route('admin.answer.destroy', $answer)}}" method="post">
            @csrf
            <input type="hidden" name="_method" value="DELETE">

        </form>

        @endforeach
    </tbody>
</table>

