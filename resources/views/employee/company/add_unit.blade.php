@extends('employee.layout.auth')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Добавить новый отдел</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{url('/employee/add_new_unit') }}">
                        {{ csrf_field() }}
    
                        <!-- Name field -->
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Название отдела</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
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
                                    Добавить отдел
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
