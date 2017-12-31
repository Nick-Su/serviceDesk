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
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address" class="col-md-4 control-label">Адрес</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control" name="address" value="{{ old('address') }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">E-mail</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tel" class="col-md-4 control-label">Телефон</label>

                            <div class="col-md-6">
                                <input id="tel" type="text" class="form-control" name="tel" value="{{ old('tel') }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-md-4 control-label">Описание компании</label>

                            <div class="col-md-6">
                                <textarea id="description" type="text" class="form-control" name="description" value="{{ old('description') }}" required autofocus> </textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="allow_external_tickets" class="col-md-4 control-label">Разрешить прием заявок от частных клиентов</label>

                            <div class="col-md-6">
                                <input id="allow_external_tickets" class="form-control" type="checkbox" name="allow_external_tickets" value="1">
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
                                    Сохранить
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
