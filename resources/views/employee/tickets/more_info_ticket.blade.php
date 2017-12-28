@extends('employee.layout.auth')

@section('content')
<div  class="col-md-6 col-md-offset-3">
	
	@forelse($ticketInfo as $ticket)
	<h1>Заявка {{$ticket->id}}</h1>
	<table class="table table-bordered text-center">
		<tr>
			<td class="col-md-3">Инициатор</td>
			<td>{{$ticket->employee_init_id}} {{ $employeeName}}</td>
		</tr>
		
		<tr>
			<td>Приоритет</td>
			<td>{{$ticket->id_priority}} {{$prioName}}</td>
		</tr>

		<tr>
			<td>Исполняющий отдел</td>
			<td>{{$ticket->unit_to_id}} {{$unitName}}</td>
		</tr>

		<tr>
			<td>Тема</td>
			<td>{{$ticket->subject}}</td>
		</tr>
		<tr>
			<td>Описание проблемы</td>
			<td>{{$ticket->description}}</td>
		</tr>

		<tr>
			<td>ФИО Исполнителя</td>
			<td>{{$ticket->id_executor}} {{$executorName}}</td>
		</tr>

		<tr>
			<td>Статус</td>
			<td>{{$ticket->id_status}} {{ $statusName }}</td>
		</tr>
	</table>
	<a href="/employee/view_all_incoming_tickets" class="btn btn-primary col-md-12"> Назад </a>
	




	@empty
	    <p>Отделы не найдены.</p>
	@endforelse
</div>

@endsection