@extends('individual.layout.auth')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Создать заявку</div>

                <div class="panel-body">
                	<h2 class="text-center">{{$CompanyName}}</h2></br>
                    <form class="form-horizontal" method="POST" action="{{url('/individual/create_ticket/{id_company}') }}">
                        {{ csrf_field() }}
                        
                        <!-- Unit -->
                        <div class="form-group">
                            <label for="unit_to_id" class="col-md-4 control-label">Кому?</label>

                            <div class="col-md-6">
                                <select class="form-control" name="unit_to_id">
                                    @forelse($allUnitsOfTheCompany as $unit)
                                    	<option value="{{ $unit -> id }}">Отдел {{$unit->name}}</option>
                                    @empty
                                    	<option>Отделы не найдены</option>
                                    @endforelse 
                                </select>
                            </div>
                        </div>


                        <!-- Priority -->
                        <div class="form-group">
                            <label for="Priority" class="col-md-4 control-label">Приоритет</label>

                            <div class="col-md-6">
                                <select class="form-control" name="id_priority" id="priority">
                                    @forelse($allPriorities as $priority)
                                    <option value="{{ $priority -> id }}">{{ $priority->name }}</option>
                                    @empty
                                        <p>Приоритеты не найдены.</p>
                                    @endforelse
                                </select>
                            </div>
                        </div>


                        <!-- Subject -->
                        <div class="form-group">
                            <label for="subject" class="col-md-4 control-label">Тема</label>

                            <div class="col-md-6">
                                <input id="subject" type="text" class="form-control" name="subject" required>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="form-group">
                            <label for="description" class="col-md-4 control-label">Что случилось?</label>

                            <div class="col-md-6">
                                <textarea id="description"  class="form-control" name="description" required> </textarea>
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="form-group">
                            <label for="client_address" class="col-md-4 control-label">Адрес</label>

                            <div class="col-md-6">
                                <input type="text" id="client_address"  class="form-control" name="client_address" required value="{{$clientAddress}}"> 
                            </div>
                        </div>
                        
                        <!-- Inject User id -->
                        <div class="form-group">
                            <div class="col-md-6">
                                <input id="id_company" type="hidden" class="form-control" name="id_company" value="<?php print(Auth::user()->id) ?>">
                            </div>
                        </div>

                        <!-- Inject Company id -->
                        <div class="form-group">
                            <div class="col-md-6">
                                <input id="id_client" type="hidden" class="form-control" name="id_client" value="<?php print(Auth::user()->id) ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6">
                                <input id="id_company" type="hidden" class="form-control" name="id_company" value="{{ $CompanyId }}" >
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Создать заявку
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
	
	

@endsection