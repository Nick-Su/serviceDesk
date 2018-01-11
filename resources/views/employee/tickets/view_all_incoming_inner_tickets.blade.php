@extends('employee.layout.auth')

@section('content')

<div class="panel-body" id="items">
              <ul class="list-group">
                @foreach($items as $item)
                  <li class="list-group-item ourItem" data-toggle="modal" data-target="#myModal" >{{$item->subject}}
                    <input type="hidden" id="itemId" value="{{$item->id}}">
                  </li>
                @endforeach
              </ul>
</div>



{{ csrf_field() }}

<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script type="text/javascript">

  function show()
  {
    $.get({
        url: "/employee/view_all_incoming_tickets",
        cache: false,
        data: {
          "_token": "{{ csrf_token() }}",
        },
        success: function(data) {
          console.log(data);
          $('#items').load(location.href + ' #items');
        }
    });
  }

  $(document).ready(function () {
			show();
			setInterval('show()', 1000);
	});

</script>

@endsection
