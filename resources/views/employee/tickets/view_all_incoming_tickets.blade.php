@extends('employee.layout.auth')

@section('content')

<div class="row">
  <div class="col-md-12" >
    <div class="col-md-2" style="height: 300px; margin-top: 7.5em;">
      <ul class="list-group">
        <li class="list-group-item"><a href="{{ url('/employee/create_ticket') }}"> Создать заявку </a></li>
        <li class="list-group-item"><a href="">Входящие заявки</a></li>
        <li class="list-group-item"><a href="">Исходящие заявки</a></li>
        <li class="list-group-item"><a href="{{url('/employee/tickets_archieve')}}">Архив заявок</a></li>
      </ul>
    </div>

    <!-- Вывод пользователей -->
    <div class="col-md-9 ">
      <h2>Входящие заявки</h2>
      <b>На этой странице ({{   $tickets->count()}} заявок)</b>
      </br>
      </br>
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>#</th>
            <th>Тема</th>
            <th>Инициатор</th>
            <th class="col-md-2">Дата создания</th>
            <th class="col-md-3">Исполнитель</th>
            <th>Статус</th>
            <th>Действия</th>
          </tr>
        </thead>
        <tbody>
            @forelse($tickets as $ticket)
              <tr>
                <td>{{ $ticket->id }}</td>
                <td>{{ $ticket->subject }}</td>
                <td>{{ $ticket->current_employee_init_name }}</td>
                <td>{{ $ticket->created_at }}</td>
                <td>
                @if (Auth::user()->head_unit_id != NULL)
                  <div class="row">
                    <div class="col-md-12">
                      <div class="input-group form-group col-sm-12">
                        <form class="form-horizontal" method="get" action="/employee/appoint_executor_to_ticket">
                          <div class="col-sm-9">
                            <input type="hidden" name="id_ticket" value="{{$ticket->id}}">
                            <select class="form-control" name="id_new_executor">
                              <option value="NULL">
                                {{ $ticket->current_executor_name }}
                              </option>
                                @forelse($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name}}</option>
                                @empty
                                  <p>Сотрудники не найдены.</p>
                                @endforelse
                              </select>
                            </div>
                            <span class="input-group-btn"><button class="btn btn-md btn-success">OK</button></span>
                        </form>
                      </div>
                    </div>
                  </div>
                @else
                    <!-- If the user is an executor, not a head unit -->
                    {{ $ticket->current_executor_name }}
                @endif
                </td>
                <td>{{ $ticket->current_status_name }}</td>
                <td>
                  <!-- If the user is a head unit -->
                  @if (Auth::user()->head_unit_id != NULL)
                  <form method="get" action="">
                    <input type="hidden" name="id_record" value="{{ $ticket->id }}">

                    <a href="/employee/reject_ticket/{{$ticket->id}}" class="btn btn-danger btn-sm">
                      <span class="glyphicon glyphicon-remove" title="Отклонить заявку"></span>
                    </a>

                  <a href="/employee/more_info_ticket/{{$ticket->id}}" class="btn btn-info btn-sm">
                    <span class="glyphicon glyphicon-info-sign" title="Подробная информация о заявке"></span>
                  </a>

                  <a href="/employee/reopen_ticket/{{$ticket->id}}" class="btn btn-warning btn-sm">
                    <span class="glyphicon glyphicon-retweet" title="Переоткрыть заявку"></span>
                  </a>
                  </form>
                  @else
                    <a href="/employee/take_the_ticket/{{$ticket->id}}" class="btn btn-primary btn-sm">
                      <span class="glyphicon glyphicon-hourglass" title="Отметить заявку как выполняемую"></span>
                    </a>
                    <a href="/employee/refuse_the_ticket/{{$ticket->id}}" class="btn btn-danger btn-sm">
                      <span class="glyphicon glyphicon-ban-circle" title="Отказаться от заявки"></span>
                    </a>

                    <a href="/employee/more_info_ticket/{{$ticket->id}}" class="btn btn-info btn-sm">
                      <span class="glyphicon glyphicon-info-sign" title="Подробная информация о заявке"></span>
                    </a>

                    <a href="/employee/ticket_complete/{{$ticket->id}}" class="btn btn-success btn-sm">
                      <span class="glyphicon glyphicon-ok-circle" title="Отметить заявку как выполненную"></span>
                    </a>
                  @endif
                </td>
                </tr>
                  @empty
                    <p>Нет входящих заявок.</p>
                  @endforelse

          </tbody>
        </table>

    </div>
  </div>
</div>



{{ csrf_field() }}

<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script type="text/javascript">
  function show()
  {
    $.get({
        url: "/employee/view_all_incoming_tickets",
        cache: false,
        data: {
          "_token": "{{ csrf_token() }}",
        },
        success: function(data) {
          console.log(data);
          $('#items').load(location.href + ' #tickets');
        }
    });
  }

  $(document).ready(function () {
      show();
      setInterval('show()', 1000);
  });


</script>

@endsection
