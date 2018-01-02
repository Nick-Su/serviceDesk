@extends('employee.layout.auth')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Профиль компании</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{url('/employee/fill_company_info') }}">
                        {{ csrf_field() }}
                        
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Название компании</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $name }}" placeholder="{{ $name }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="city" class="col-md-4 control-label">Город</label>

                            <div class="col-md-6">
                                <input id="city" type="text" class="form-control" name="city" value="{{ $city }}" required autofocus">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address" class="col-md-4 control-label">Адрес</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control" name="address" value="{{ $address }}" required autofocus">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">E-mail</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control" name="email" value="{{ $email }}" required autofocus">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tel" class="col-md-4 control-label">Телефон</label>

                            <div class="col-md-6">
                                <input id="tel" type="text" class="form-control" name="tel" value="{{ $tel }}" required autofocus">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-md-4 control-label">Описание компании</label>

                            <div class="col-md-6">
                                <textarea id="description" type="text" class="form-control" name="description" required autofocus>{{ $description }} </textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="allow_external_tickets" class="col-md-4 control-label">Разрешить прием заявок от частных клиентов</label>

                            <div class="col-md-6">
                                <input id="allow_external_tickets" class="form-control" type="checkbox" name="external_tickets" value="1" {{ $isChecked }}>
                            </div>
                        </div>

                        <!-- Generate Token -->
                        <div class="form-group">
                            <div class="col-md-6">
                                <input id="id_company" type="hidden" class="form-control" name="id_company" value="<?php print(Auth::guard('employee')->user()->id_company) ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 col-md-offset-24">
                                <button type="submit" class="btn btn-primary col-md-12">
                                    Сохранить изменения
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
