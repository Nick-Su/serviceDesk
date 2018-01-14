@extends('header_template')

@section('content')

	
	<div class="col-md-12">

		<div class="col-md-8 col-md-offset-2 tile-wrap">

			<h2 class="text-left main_title">Создать аккаунт</h2>

			<br><br><br>
			
			<a href="/employee/register">
				<div class="col-xs-3 text-center tile" id="login-employee">
					<h3>Сотрудникам</h3>
				</div>
			</a>

			<a href="/individual/register">
				<div class="col-xs-3 text-center tile" id="login-indi">
					<h3>Физическим лицам</h3>
				</div>
			</a>

			<a href="/legal/register">
				<div class="col-xs-3 text-center tile" id="login-legal">
					<h3>Юридическим лицам</h3>
				</div>
			</a>
		</div>
	</div>


<style type="text/css">
	.main_title {
		padding-left: 3.2em;
	}

	.tile-wrap {
		margin-top: 10em;
		background-color: grays;
	}

	.tile {
		height: 200px;
		border: 1px solid rgba(0, 0, 0, 0.5);
		margin-left: 3em;

		line-height: 170px;
	}

	.tile h3 {
		vertical-align: middle;
    	display: inline-block;
	}

	#login-employee {
		margin-left: 7em;
	}

	a {
        background-color: #fff;
        color: #636b6f;
        font-family: 'Raleway', sans-serif;
        font-weight: 100;
        height: 100vh;
        margin: 0;
    }

</style>

<script type="text/javascript">
	$(document).ready(function() {
		$('.tile').hover(function() {
			/* Stuff to do when the mouse enters the element */
			$(this).css('box-shadow', '0px 0px 24px 5px rgba(185,186,188,0.5)');
		}, function() {
			/* Stuff to do when the mouse leaves the element */
			$('.tile').css('box-shadow', 'none');
		});	
	});
</script>

@endsection