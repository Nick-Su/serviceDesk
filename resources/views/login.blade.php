@extends('header_template')

@section('content')

	
	<div class="col-md-12 jumbotron">

		<div class="col-md-8 col-md-offset-2 tile-wrap">

			<h2 class="text-left main_title">Вход в личный кабинет</h2>

			<br><br><br>
			
			<a href="/employee/login">
				<div class="col-xs-3 text-center emp">
					<div class="tile img-container" id="login-employee">
						<img src="{!! asset('/pics/employee.jpg') !!}">
						<h3>Сотрудникам</h3>
					</div>				
				</div>
			</a>

			<a href="/individual/login">
				<div class="col-xs-3 text-center">
					<div class="tile img-container" id="login-indi">
						<img src="{!! asset('/pics/indi.jpg') !!}">	
						<h3>Физическим лицам</h3>				
					</div>					
				</div>
			</a>

			<a href="/legal/login">
				<div class="col-xs-3 text-center">
					<div class="tile img-container" id="login-legal">
						<img src="{!! asset('/pics/legal.jpg') !!}">	
						<h3>Юридическим лицам</h3>			
					</div>				
				</div>
			</a>

		</div>
	</div>


<style type="text/css">


	.jumbotron {
		margin-top: -3em;
		height: auto;
		background-image: url({!! asset('/pics/cup-of-coffee.jpg') !!});
	}

	.main_title {
		color:white;
		padding-left: 3.2em;
	}

	.tile-wrap {
		height: 30em;
		dmargin-top: 0em;
		aborder: 1px solid gray;
	}

	.tile {
		height: 200px;
		aborder: 1px solid rgba(0, 0, 0, 0.5);
		fmargin-left: 3em;

		fline-height: 170px;
	}

	.tile h3 {
		vertical-align: middle;
    	display: inline-block;
    	color: white;
	}

	.tile-wrap h3 {
		color: white;
	}

	.img-container {
		height: auto;
	}

	.emp {
		margin-left: 7em;
	}

	#login-legal {
		
		background-repeat: no-repeat;
		background-image: url();
	}

	a {
        background-color: #fff;
        color: #636b6f;
        font-family: 'Raleway', sans-serif;
        font-weight: 100;
        height: 100vh;
        margin: 0;
    }

	.img-container h3 {
    	color: #CCCFE1;
    }

    a:hover h3 {
    	color: white;
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







	jQuery(function ($) {
    function fix_size() {
        var images = $('.img-container img');
        images.each(setsize);

        function setsize() {
            var img = $(this),
                img_dom = img.get(0),
                container = img.parents('.img-container');
            if (img_dom.complete) {
                resize();
            } else img.one('load', resize);

            function resize() {
                if ((container.width() / container.height()) < (img_dom.width / img_dom.height)) {
                    img.width('100%');
                    img.height('auto');
                    return;
                }
                img.height('100%');
                img.width('auto');
            }
        }
    }
    $(window).on('resize', fix_size);
    fix_size();
});
</script>

@endsection