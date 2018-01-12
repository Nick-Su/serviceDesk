@extends('legal.layout.auth')

@section('content')

<div class="row">
  <div class="col-md-10 col-md-offset-1" >
    
    <!-- Вывод пользователей -->
    <div class="" id="tickets">
      <h2>Исходящие заявки</h2>
      <b>На этой странице ({{ $tickets->count() }}) заявок</b>
      </br>
      </br>
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>#</th>
            <th>Название компании</th>
            <th>Тема</th>
            <th>Описание</th>
            <th>Приоритет</th>
            <th class="col-md-2">Дата создания</th>
            <th class="col-md-2">Исполнитель</th>
            <th>Статус</th>
            <th class="col-xs-2">Действия</th>
          </tr>
        </thead>
        <tbody> 
            @forelse($tickets as $ticket)
              <tr>
                <td>{{ $ticket->id }}</td>
                <td>{{ $ticket->companyName }}</td>
                <td>{{ $ticket->subject }}</td>
                <td>{{ $ticket->description }}</td>
                <td>{{ $ticket->priority }}</td>
                <td>{{ $ticket->created_at }}</td>
                <td>{{ $ticket->current_executor_name }}</td>
                <td>{{ $ticket->current_status_name }}</td>
            
                <td>
                   
                  <a href="/legal/more_info_legal_ticket/{{$ticket->id}}" class="btn btn-info btn-sm">
                    <span class="glyphicon glyphicon-info-sign" title="Подробная информация о заявке"></span>
                  </a>

                  <a href="/legal/confirm_legal_ticket_complete_by_initiator/{{$ticket->id}}" class="btn btn-success btn-sm">
                    <span class="glyphicon glyphicon-ok" title="Отметить заявку как выполненную"></span>                     
                  </a>

                  <a href="/legal/legal_ticket_is_not_complete/{{$ticket->id}}" class="btn btn-danger btn-sm">
                    <span class=" glyphicon glyphicon-repeat" title="Отметить заявку как невыполненную. Она будет рассмотрена снова"></span>                     
                  </a>   
                  
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



<script type="text/javascript">

  function show()
  {
    $.get({
        url: "/legal/outgoing_tickets",
        cache: false,
        data: {
          "_token": "{{ csrf_token() }}",
        },
        success: function(data) {
          console.log(data);
          $('#tickets').load(location.href + ' #tickets');
        }
    });
  }

  $(document).ready(function () {
      show();
      setInterval('show()', 5000);
  });

</script>
@endsection