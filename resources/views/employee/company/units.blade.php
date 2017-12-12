@extends('employee.layout.auth')

@section('content')
    <div class="row">

        <div class="col-md-9 col-md-offset-2" >
            
            <div class="col-md-3" style="height: 300px; background-color: ;">
                <ul class="list-group">
                    <li class="list-group-item"><a href="{{ url('/employee/add_unit') }}"> Добавить отдел </a></li>
                    <li class="list-group-item"><a href="">Просмотр всех отделов</a></li>
                </ul>
            </div>

        <!-- Вывод пользователей -->
        <div class="col-md-6 ">
            <b>На этой странице ({{   $units->count()}}) отдел(ов)</b>
            <ul class="list-group">
                @forelse($units as $unit)
                    <li class="list-group-item" style="margin-top: 20px;">

                        <span> {{ $unit->name }} </span>

                        <span class="pull-right clearfix">


                    <button class="btn btn-xs btn-primary">Редактировать</button>
                    <button class="btn btn-xs btn-danger">Удалить</button>

                        </span>
                    </li>
                @empty
                    <p>Отделы не найдены</p>
                @endforelse

            </ul>

        </div>

        </div>

        

    </div>








@endsection