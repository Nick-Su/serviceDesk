@extends('individual.layout.auth')

@section('content')

<div class="row">
  <div class="col-md-12" >
    

    <!-- Вывод пользователей -->
    <div class="col-md-10 col-md-offset-1 ">
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
            <th>Действия</th>
          </tr>
        </thead>
        <tbody> 
            @forelse($tickets as $ticket)
              <tr>
                <td>{{ $ticket->id }}</td>
                <td>{{ $companyName }}</td>
                <td>{{ $ticket->subject }}</td>
                <td>{{ $ticket->description }}</td>
                <td>{{ $priority }}</td>
                <td>{{ $ticket->created_at }}</td>
                <td>{{ $current_executor }}</td>
                <td>{{ $statusName }}</td>
            
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
@endsection