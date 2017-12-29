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
      <h2>Исходящие заявки</h2>
      <b>На этой странице ({{ $tickets->count() }}) заявок</b>
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
                
                    <!-- If the user is an executor, not a head unit -->
                    {{ $ticket->current_executor_name }}
                
                </td>
                <td>{{ $ticket->current_status_name }}</td>
                <td>
                  <!-- If the user is a head unit -->    
                  <a href="/employee/more_info_ticket/{{$ticket->id}}" class="btn btn-info btn-sm">
                    <span class="glyphicon glyphicon-info-sign" title="Подробная информация о заявке"></span>
                  </a>

                  <a href="/employee/confirm_ticket_complete_by_initiator/{{$ticket->id}}" class="btn btn-success btn-sm">
                    <span class="glyphicon glyphicon-ok" title="Отметить заявку как выполненную"></span>                     
                  </a>

                  <a href="/employee/ticket_is_not_complete/{{$ticket->id}}" class="btn btn-danger btn-sm">
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

<?php
#var_dump($tickets)

?>