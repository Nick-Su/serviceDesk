@extends('employee.layout.auth')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Добавить нового сотрудника</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{url('/employee/add_new_employee') }}">
                        {{ csrf_field() }}
    <!-- action('EmployeesController@save_data') -->
                        <!-- FIO field -->
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Ф.И.О сотрудника</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('fio'))
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
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Пароль</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Подтвердите пароль</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                        
                        <!-- Tel -->
                        <div class="form-group">
                            <label for="phone_number" class="col-md-4 control-label">Телефон</label>

                            <div class="col-md-6">
                                <input id="phone_number" type="text" class="form-control" name="phone_number" required>
                            </div>
                        </div>

                        <!-- Room -->
                        <div class="form-group">
                            <label for="room" class="col-md-4 control-label">Кабинет</label>

                            <div class="col-md-6">
                                <input id="room" type="text" class="form-control" name="room" required>
                            </div>
                        </div>
                        
                        <!-- Priv field -->
                        <div class="form-group">
                            <label for="priv_add_employee" class="col-md-4 control-label">Разрешить добавление сотрудников</label>
                            <div class="col-md-6">
                                <input id="priv_add_employee" type="checkbox" class="form-control" name="priv_add_employee"  value="1">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="priv_edit_employee" class="col-md-4 control-label">Разрешить редактирование сотрудников</label>
                            <div class="col-md-6">
                                <input id="priv_edit_employee" type="checkbox" class="form-control" name="priv_edit_employee"  value="1">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="priv_delete_employee" class="col-md-4 control-label">Разрешить удаление сотрудников</label>
                            <div class="col-md-6">
                                <input id="priv_delete_employee" type="checkbox" class="form-control" name="priv_delete_employee" value="1">
                            </div>
                        </div>
                        
                        <!-- Generate Token -->
                        <div class="form-group">
                            <div class="col-md-6">
                                <input id="id_company" type="hidden" class="form-control" name="id_company" value="<?php print(Auth::guard('employee')->user()->id_company) ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Добавить
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
