@extends('employee.layout.auth')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Добавить нового сотрудника</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="/employee/save_edit_employee_changes">
                        {{ csrf_field() }}
    <!-- action('EmployeesController@save_data') -->
    					@forelse($employee as $emp)
                        <!-- FIO field -->
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Ф.И.О сотрудника</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $emp->name }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                    
                        <!-- Email field -->
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail адрес</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $emp->email }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>        
                        
                        <!-- Tel -->
                        <div class="form-group">
                            <label for="phone_number" class="col-md-4 control-label">Телефон</label>

                            <div class="col-md-6">
                                <input id="phone_number" type="text" class="form-control" name="phone_number" required value="{{ $emp->phone_number }}">
                            </div>
                        </div>

                        <!-- Unit -->
                        <div class="form-group">
                            <label for="unit" class="col-md-4 control-label">Отдел</label>

                            <div class="col-md-6">
                                <select class="form-control" name="id_unit">
                                    @forelse($units as $unit)
                                    <option value="{{ $unit -> id }}">{{ $unit->name }}</option>
                                    @empty
                                        <p>Отделы не найдены.</p>
                                    @endforelse
                                </select>
                            </div>
                        </div>

                        <!-- Head Unit ID -->
                        <div class="form-group">
                            <label for="unit" class="col-md-4 control-label">Начальник отдела</label>

                            <div class="col-md-6">
                                <select class="form-control" name="head_unit_id">
                                    <option value="">Не является начальником отдела</option>
                                    @forelse($units as $unit)
                                    <option value=" {{ $unit -> id }}">{{ $unit->name }}</option>
                                    @empty
                                        <p>Отделы не найдены.</p>
                                    @endforelse
                                </select>
                            </div>
                        </div>

                        <!-- Room -->
                        <div class="form-group">
                            <label for="room" class="col-md-4 control-label">Кабинет</label>

                            <div class="col-md-6">
                                <input id="room" type="text" class="form-control" name="room" value="{{ $emp->room }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="role" class="col-md-4 control-label">
                                Сотрудник имеет права администратора
                            </label>
                            <div class="col-md-6">
                                <input id="role" type="checkbox" name="id_role" value="1" class="form-control" {{ $isChecked }}>
                            </div>
                        </div>                      
                        
                        <!-- Generate Token -->
                        <div class="form-group">
                            <div class="col-md-6">
                                <input id="id_company" type="hidden" class="form-control" name="id_company" value="<?php print(Auth::guard('employee')->user()->id_company) ?>">
                            </div>
                        </div>

                        <input type="hidden" name="id" value="{{ $emp->id }}">

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Сохранить изменения
                                </button>
                            </div>
                        </div>

                        @empty
							<p>Что-то пошло не так...</p>
                        @endforelse
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection