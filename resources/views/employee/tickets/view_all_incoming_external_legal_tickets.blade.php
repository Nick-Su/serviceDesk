@extends('employee.layout.auth')

@section('content')
<?php 

if(isset($_POST['userID']))
{
    $uid = $_POST['userID'];
    echo $uid;
}
?>
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <!-- Вывод пользователей -->
    <div class="" id="tickets">
      <h2>Входящие внешние заявки от организаций 5656</h2>
      <b>На этой странице ({{   $tickets->count()}} заявок)</b>
      </br>
      </br>

      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>#</th>
            <th>Тема</th>
            <th>Описание</th>
            <th>Инициатор</th>
            <th class="col-md-2">Дата создания</th>
            <th class="col-md-3">Исполнитель</th>
            <th>Статус</th>
            <th>Действия</th>
          </tr>
        </thead>
        <tbody id="showdata"> 
            @forelse($tickets as $ticket)
              <tr>
                <td>{{ $ticket->id }}</td>
                <td>{{ $ticket->subject }}</td>
                <td>{{ $ticket->description }}</td>
                <td>{{ $ticket->current_employee_init_name }}</td>
                <td>{{ $ticket->created_at }}</td>
                <td>
                @if (Auth::user()->head_unit_id != NULL)
                  <div class="row">
                    <div class="col-md-12">
                      <div class="input-group form-group col-sm-12">
                        <form class="form-horizontal" method="get" action="/employee/appoint_executor_to_legal_ticket">
                          <div class="col-sm-9">
                            <input type="hidden" name="id_ticket" value="{{$ticket->id}}">
                            <select class="form-control" name="id_new_executor">
                              <option value="NULL">
                                {{ $ticket->current_executor_name }}
                              </option>
                                @forelse($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name}}</option>
                                @empty
                                  <p>Сотрудники не найдены.</p>
                                @endforelse
                              </select>
                            </div>
                            <span class="input-group-btn"><button class="btn btn-md btn-success">OK</button></span>
                        </form>
                      </div>                
                    </div>
                  </div>
                @else 
                    <!-- If the user is an executor, not a head unit -->
                    {{ $ticket->current_executor_name }}
                @endif
                </td>
                <td>{{ $ticket->current_status_name }}</td>
                <td>
                  <!-- If the user is a head unit -->
                  @if (Auth::user()->head_unit_id != NULL)
                  <form method="get" action="">
                    <input type="hidden" name="id_record" value="{{ $ticket->id }}">

                    <a href="/employee/reject_legal_ticket/{{$ticket->id}}" class="btn btn-danger btn-sm">
                      <span class="glyphicon glyphicon-remove" title="Отклонить заявку"></span>                     
                    </a>

                  <a href="/employee/more_info_legal_ticket/{{$ticket->id}}" class="btn btn-info btn-sm">
                    <span class="glyphicon glyphicon-info-sign" title="Подробная информация о заявке"></span>
                  </a>

                  <a href="/employee/reopen_legal_ticket/{{$ticket->id}}" class="btn btn-warning btn-sm">
                    <span class="glyphicon glyphicon-retweet" title="Переоткрыть заявку"></span>
                  </a>
                  </form>
                  @else
                    <a href="/employee/take_the_legal_ticket/{{$ticket->id}}" class="btn btn-primary btn-sm">
                      <span class="glyphicon glyphicon-hourglass" title="Отметить заявку как выполняемую"></span>                     
                    </a>
                    <a href="/employee/refuse_the_legal_ticket/{{$ticket->id}}" class="btn btn-danger btn-sm">
                      <span class="glyphicon glyphicon-ban-circle" title="Отказаться от заявки"></span>                     
                    </a>

                    <a href="/employee/more_info_legal_ticket/{{$ticket->id}}" class="btn btn-info btn-sm">
                      <span class="glyphicon glyphicon-info-sign" title="Подробная информация о заявке"></span>
                    </a>

                    <a href="/employee/legal_ticket_complete/{{$ticket->id}}" class="btn btn-success btn-sm">
                      <span class="glyphicon glyphicon-ok-circle" title="Отметить заявку как выполненную"></span>
                    </a>  
                  @endif
                </td>
                </tr>
                  @empty
                    <p>Нет входящих заявок.</p>
                  @endforelse
              
          </tbody>
        </table>
                  
    </div>
  </div>
</div>


<input type="hidden" id="authUserHeadUnitID" value="<?= Auth::user()->head_unit_id ?>">

<meta name="_token" content="{!! csrf_token() !!}" />



<script type="text/javascript">
 
function show() {
  
  $.get({
          url: "/employee/getRequest",
          cache: false,
          async: true,
          data: {
            "_token": "{{ csrf_token() }}",
          },
          
          dataType: 'JSON',
          success: function(data) {
            //console.log(data[0].employees.length);
            console.log(data);

            var html = '';
            var i;
            var j;
            var emp;
            var btn = '<span class="input-group-btn"><button class="btn btn-md btn-success">OK</button></span>';
            var authUserHeadUnitID =  document.getElementById("authUserHeadUnitID").value;
            var WhichBtnToShow;
            var OneEmpOrNot;
      
            
            for(i=0; i<data.length; i++){
             
              emp = '';

              if (data[0].employees !== null) {

              for (j = 0; j<data[i].employees.length; j++) {
                emp += '<option value="'+data[i].employees[j].id+'">'+data[i].employees[j].name+'</option> ';  

                if (authUserHeadUnitID != null) { 
                  OneEmpOrNot = '<div class="row">'+
                    '<div class="col-md-12">'+
                      '<div class="input-group form-group col-sm-12">'+
                        '<form class="form-horizontal" method="get" action="/employee/appoint_executor_to_legal_ticket">'+
                          '<div class="col-sm-9">'+
                            '<input type="hidden" name="id_ticket" value="'+ data[i].id +'">'+

                            '<select class="form-control" name="id_new_executor">'
                                  +'<option value="NULL">'+data[i].current_executor_name+'</option>'
                                  + emp +                             
                            '</select>'+
                
                          '</div>'
                          + btn +
                      '</div>'+ 
                        '</form>'+
                    '<div>'+
                  '</div>';

                  WhichBtnToShow = '<form method="get" action="">'+
                    '<input type="hidden" name="id_record" value="'+data[i].id+'">' +

                    '<a href="/employee/reject_legal_ticket/'+ data[i].id +'" class="btn btn-danger btn-sm">'+
                      '<span class="glyphicon glyphicon-remove" title="Отклонить заявку"></span>'+                     
                    '</a>'+

                    '<a href="/employee/more_info_legal_ticket/'+ data[i].id +'" class="btn btn-info btn-sm">'+
                      '<span class="glyphicon glyphicon-info-sign" title="Подробная информация о заявке"></span>'+
                    '</a>'+

                    '<a href="/employee/reopen_legal_ticket/'+ data[i].id +'" class="btn btn-warning btn-sm">'+
                      '<span class="glyphicon glyphicon-retweet" title="Переоткрыть заявку"></span>'+
                    '</a>'+
                  '</form>';
                } else {
                    OneEmpOrNot = data[i].current_executor_name;

                    WhichBtnToShow = 
                    '<a href="/employee/take_the_legal_ticket/'+ data[i].id +'" class="btn btn-primary btn-sm">'+
                      '<span class="glyphicon glyphicon-hourglass" title="Отметить заявку как выполняемую"></span>'+
                    '</a>'+
                    
                    '<a href="/employee/refuse_the_legal_ticket/'+ data[i].id +'" class="btn btn-danger btn-sm">'+
                      '<span class="glyphicon glyphicon-ban-circle" title="Отказаться от заявки"></span>'+
                    '</a>'+

                    '<a href="/employee/more_info_legal_ticket/'+ data[i].id +'" class="btn btn-info btn-sm">'+
                      '<span class="glyphicon glyphicon-info-sign" title="Подробная информация о заявке"></span>'+
                    '</a>'+

                    '<a href="/employee/legal_ticket_complete/'+ data[i].id +'" class="btn btn-success btn-sm">'+
                      '<span class="glyphicon glyphicon-ok-circle" title="Отметить заявку как выполненную"></span>'+
                    '</a>';
                }          
              };

            } else {
              OneEmpOrNot = data[i].current_executor_name;

              WhichBtnToShow = 
                    '<a href="/employee/take_the_legal_ticket/'+ data[i].id +'" class="btn btn-primary btn-sm">'+
                      '<span class="glyphicon glyphicon-hourglass" title="Отметить заявку как выполняемую"></span>'+
                    '</a>'+
                    
                    '<a href="/employee/refuse_the_legal_ticket/'+ data[i].id +'" class="btn btn-danger btn-sm">'+
                      '<span class="glyphicon glyphicon-ban-circle" title="Отказаться от заявки"></span>'+
                    '</a>'+

                    '<a href="/employee/more_info_legal_ticket/'+ data[i].id +'" class="btn btn-info btn-sm">'+
                      '<span class="glyphicon glyphicon-info-sign" title="Подробная информация о заявке"></span>'+
                    '</a>'+

                    '<a href="/employee/legal_ticket_complete/'+ data[i].id +'" class="btn btn-success btn-sm">'+
                      '<span class="glyphicon glyphicon-ok-circle" title="Отметить заявку как выполненную"></span>'+
                    '</a>';
            }
   
              html +='<tr>'+
                    '<td>'+data[i].id+'</td>'+
                    '<td>'+data[i].subject+'</td>'+
                    '<td>'+data[i].description+'</td>'+
                    '<td>'+data[i].current_employee_init_name+'</td>'+
                    '<td>'+data[i].created_at+'</td>'+
                    
                    '<td>'
                     + OneEmpOrNot +
                    '</td>'+

                    '<td>'+ data[i].current_status_name +'</td>'+
                    '<td>'+
                      WhichBtnToShow +
                    '</td>'+
                    '</tr>';
            }
            $('#showdata').html(html);

          }
      }); // ends a $.get

}



function getHash() {
  var tmp = null;
  $.ajax({
      'async': false,
      'type': "get",
      'global': false,
      'dataType': 'html',
      'url': "/employee/getHash",
      'data': { 'request': "", 'target': 'arrange_url', 'method': 'method_target', "_token": "{{ csrf_token() }}" },
      'success': function (data) {
          tmp = data;
      }
  });
  return tmp;
};


var currentHash = getHash();

function compareHashes(oldHash)
{
  //console.log('Old '+ oldHash);
  var newestHash = getHash();

  //console.log('NewHash ' + newestHash);
  //console.log('OldHash ' + oldHash); 

  if (oldHash != getHash()) {
    console.log('Hashes are differ! Show() is working now');
    currentHash = newestHash;
    show();
  } else { 
    //currentHash = newestHash;
    console.log('Hashes are the same ' + currentHash);
  }
  
  //console.log('new current hash ' + currentHash );

  return newestHash; 
}


$(document).ready(function () {
       
      setInterval( function() { compareHashes(currentHash); }, 1000 );

      //show();
      //setInterval('show()', 5000);
  }); 



// Original function
/*
function show()
  {
    
    $.get({
        url: "/employee/view_all_incoming_external_legal_tickets",
        cache: false,
        data: {
          "_token": "{{ csrf_token() }}",
        },
        success: function(data) {
          console.log(data);
          $('#tickets').load(location.href + ' #tickets');

          //$('#tickets').append(data);
          
          //$('#tickets').html('data');
        }
    }); 
  } 

  $(document).ready(function () {
      show();
      setInterval('show()', 5000);
  });

*/

</script>

@endsection