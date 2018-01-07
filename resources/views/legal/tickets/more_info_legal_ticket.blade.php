@extends('legal.layout.auth')

@section('content')
<div  class="col-md-6 col-md-offset-3">
	
	@forelse($ticketInfo as $ticket)
	<h1>Заявка {{$ticket->id}}</h1>
	<table class="table table-bordered text-center">
		<tr>
			<td class="col-md-3">Инициатор</td>
			<td>{{ $clientName}}</td>
		</tr>
		
		<tr>
			<td>Приоритет</td>
			<td>{{$prioName}}</td>
		</tr>

		<tr>
			<td>Исполняющий отдел</td>
			<td>{{$unitName}}</td>
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
			<td>{{$executorName}}</td>
		</tr>

		<tr>
			<td>Адрес</td>
			<td>{{$ticket->address}} </td>
		</tr>

		<tr>
			<td>Е-mail</td>
			<td>{{$clientEmail}} </td>
		</tr>

		<tr>
			<td>Телефон</td>
			<td>{{$clientTel}} </td>
		</tr>

		<tr>
			<td>Статус</td>
			<td>{{ $statusName }}</td>
		</tr>
	</table>
	<a href="/legal/outgoing_tickets" class="btn btn-primary col-md-12"> Назад </a>
	




	@empty
	    <p>Отделы не найдены.</p>
	@endforelse
</div>

@endsection