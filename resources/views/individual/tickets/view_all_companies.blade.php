@extends('individual.layout.auth')

@section('content')

<div class="row">
  <div class="col-md-12" >
   
    <!-- Вывод компаний -->
    <div class="col-md-9 ">
      <h2>Входящие заявки</h2>
      <b>На этой странице ()  компаний</b>
      </br>
      </br>
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>#</th>
            <th>Название</th>
            <th>Адрес</th>
            <th>Описание</th>
            <th>Статус</th>
            <th>Действия</th>
          </tr>
        </thead>
        <tbody> 
            
              
          </tbody>
        </table>
                  
    </div>
  </div>
</div>

@endsection