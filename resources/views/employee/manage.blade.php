@extends('employee.layout.auth')

@section('content')
<?php 
    $users = DB::table('employees')->where('id_company', Auth::user()->id_company)->get();
?>
    <div class="row">

        <div class="col-md-9 col-md-offset-2" >
            
            <div class="col-md-3" style="height: 300px; background-color: ;">
                <ul class="list-group">
                    <li class="list-group-item"><a href="{{ url('/employee/create_employee') }}"> Создать пользователя </a></li>
                    <li class="list-group-item"><a href="">Просмотр всех пользователей</a></li>
                </ul>
            </div>

        <!-- Вывод пользователей -->
        <div class="col-md-6 ">
            <b>In this page ({{   $users->count()}} users)</b>
            <ul class="list-group">
                @forelse($users as $user)
                    <li class="list-group-item" style="margin-top: 20px;">

                        <span> {{ $user->name }} </span>

                        <span class="pull-right clearfix">


                    <button class="btn btn-xs btn-primary">Edit</button>
                    <button class="btn btn-xs btn-danger">Delete</button>

                        </span>
                    </li>
                @empty
                    <p>No users available.</p>
                @endforelse

            </ul>

        </div>

        </div>

        

    </div>








@endsection