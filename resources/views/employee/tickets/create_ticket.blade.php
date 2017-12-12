@extends('employee.layout.auth')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Создать заявку</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{url('/employee/create_ticket') }}">
                        {{ csrf_field() }}
                        
                        <!-- Unit -->
                        <div class="form-group">
                            <label for="unit_to_id" class="col-md-4 control-label">Кому?</label>

                            <div class="col-md-6">
                                <select class="form-control" name="unit_to_id">
                                    @forelse($units as $unit)
                                    <option value="{{ $unit -> id }}">Отдел {{ $unit->name }}</option>
                                    @empty
                                        <p>Отделы не найдены.</p>
                                    @endforelse
                                </select>
                            </div>
                        </div>


                        <!-- Employee init id -->
                        <div class="form-group">
                            <label for="employee_init_id" class="col-md-4 control-label">От кого?</label>

                            <div class="col-md-6">
                                <select class="form-control" name="employee_init_id" id="employee_init_id">
                                    @forelse($employees as $employee)
                                    <option value="{{ $employee -> id }}">{{ $employee->name }}</option>
                                    @empty
                                        <p>Сотрудники не найдены.</p>
                                    @endforelse
                                </select>
                            </div>
                        </div>

                        <!-- Priority -->
                        <div class="form-group">
                            <label for="Priority" class="col-md-4 control-label">Приоритет</label>

                            <div class="col-md-6">
                                <select class="form-control" name="id_priority" id="priority">
                                    @forelse($priorities as $priority)
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
                        
                        <!-- Generate Token -->
                        <div class="form-group">
                            <div class="col-md-6">
                                <input id="id_company" type="hidden" class="form-control" name="id_company" value="<?php print(Auth::guard('employee')->user()->id_company) ?>">
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
