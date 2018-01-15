@extends('employee.layout.auth')

@section('content')
<?php 
    $users = DB::table('employees')->where('id_company', Auth::user()->id_company)->get();
?>
    <div class="row">

        <div class="col-md-9 col-md-offset-2" >
            
            <div class="col-md-3" style="height: 300px; background-color: ;">
                <ul class="list-group">
                    <li class="list-group-item"><a href="/employee/create_employee"> Создать пользователя </a></li>
                    <li class="list-group-item"><a href="">Просмотр всех пользователей</a></li>
                </ul>
            </div>

        <!-- Вывод пользователей -->
        <div class="col-md-6 " id="employee_list">
            <b>На этой странице ({{ $users->count()}} сотрудников)</b>
            <ul class="list-group">
                @forelse($users as $user)
                    <li class="list-group-item" style="margin-top: 20px;">

                        <span> {{ $user->name }} </span>

                        <span class="pull-right clearfix">
                            
                            <a href="/employee/edit_employee/{{ $user->id}}" class="edit" id="{{ $user->id}}">
                                <button  class="btn btn-xs btn-primary">Редактировать</button>
                            </a> 

                            <a href="#" class="delete" id="{{ $user->id}}">
                                <button class="btn btn-xs btn-danger">Удалить</button>
                            </a>
                           
                        </span>
                    </li>
                @empty
                    <p>Сотрудники не найдены</p>
                @endforelse

            </ul>

        </div>

        </div>

        

    </div>




<script type="text/javascript">
    
    $(document).ready(function () {
     
        $('.delete').click(function(event) {
            var isDelete = confirm('Вы действительно хотите удалить этого сотрудника?');
            var id = this.id;

            if (isDelete) {
                $.post({
                    url: "/employee/delete_employee",
                    cache: false,
                    data: {
                      "_token": "{{ csrf_token() }}",
                      "id": id,
                    },
                    success: function(data) {     
                      $('#employee_list').load(location.href + ' #employee_list');
                    }
                });
              
               
            } else {
                alert('no deletion');
            }
        });

    });

    /* $.get({
        url: "/employee/delete_employee",
        cache: false,
        data: {
          "_token": "{{ csrf_token() }}",
        },
        success: function(data) {
          console.log(data);
          
          $('#tickets').load(location.href + ' #tickets');
        }
    }); */
  

  ;

</script> 



@endsection