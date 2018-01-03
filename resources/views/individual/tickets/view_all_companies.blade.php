@extends('individual.layout.auth')

@section('content')

<div class="row">
  <div class="col-md-12" >
   
    <!-- Вывод компаний -->
    <div class="col-md-9 col-md-offset-2">
      <h2>Доступные компании Вашего города</h2>
      <b>На этой странице ({{ $allCompanies->count() }})  компаний</b>
      </br>
      </br>
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th class="col-xs-1">#</th>
            <th class="col-md-2">Название</th>
            <th>Адрес</th>
            <th>Описание</th>
            <th class="col-md-1">Действия</th>
          </tr>
        </thead>
        <tbody>
        	@forelse($allCompanies as $company)
				<tr>
					<th>{{ $company->id }}</th>
					<th>{{ $company->name }}</th>
					<th>{{ $company->address }}</th>
					<th>{{ $company->description }}</th>
					<th>
            			<a href="/individual/create_ticket_form/{{ $company->id_company }}">
                    	<button type="button" class="btn btn-success btn-sm">
                    	    <span class="glyphicon glyphicon-plus"></span> Оставить заявку 
                    	</button>
                    	</a>
					</th>
				</tr>
				
        	@empty
				<p> Компании не обнаружены </p>
        	@endforelse 
            
              
          </tbody>
        </table>
                  
    </div>
  </div>
</div>

@endsection