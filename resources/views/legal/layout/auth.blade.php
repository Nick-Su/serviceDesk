<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel Multi Auth Guard') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>

    <script src="{!! asset('/jquery-3.2.1.min.js') !!}"></script> 

   <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/smoothness/jquery-ui.css" />
    <script src="http://api-maps.yandex.ru/2.0-stable/?load=package.full&lang=ru-RU" type="text/javascript"></script>
    <script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
    <script src="http://code.jquery.com/ui/1.9.1/jquery-ui.min.js"></script>

    
</head>
<body>
    Поиск: <input id="Address" type="text" value="" style="width: 445px; margin-top: 10px;" />
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/legal') }}">
                    {{ config('app.name', 'Laravel Multi Auth Guard') }}: Legal
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/legal/login') }}">Войти</a></li>
                        <li><a href="{{ url('/legal/register') }}">Зарегистрироваться</a></li>
                    @else
                        <li class="dropdown"> 
                             <a href="#"  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                Мои заявки <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/legal/create_ticket') }}">Создать заявку</a></li>
                                <li><a href="{{ url('/legal/outgoing_tickets') }}">Исходящие заявки</a></li>
                                <li><a href="{{ url('/legal/archieved_tickets')}}">Архив заявок</a></li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{url('/legal/profile')}}">Профиль</a></li>
                                <li>
                                    <a href="{{ url('/legal/logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        Выход
                                    </a>

                                    <form id="logout-form" action="{{ url('/legal/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

     

    @yield('content')

    <!-- Scripts -->
    <script src="/js/app.js"></script>



</body>
</html>



<script type="text/javascript">
    var myMap;
var search_result = [];

ymaps.ready(function () {
    myMap = new ymaps.Map("myMap", {
        center: [56.85570581355954, 53.201285499999955],
        zoom: 12,
        behaviors: ['default', 'scrollZoom']
    });
    myMap.controls.add('zoomControl');
});

$(document).ready(function(){
    $("#Address").keyup(function(){
        //РїРѕ РјРµСЂРµ РІРІРѕРґР° С„СЂР°Р·С‹, СЃРѕР±С‹С‚РёРµ Р±СѓРґРµС‚ СЃСЂР°Р±Р°С‚С‹РІР°С‚СЊ РІСЃСЏРєРёР№ СЂР°Р·
        var search_query = $(this).val();
        //РјР°СЃСЃРёРІ, РІ РєРѕС‚РѕСЂС‹Р№ Р±СѓРґРµРј Р·Р°РїРёСЃС‹РІР°С‚СЊ СЂРµР·СѓР»СЊС‚Р°С‚С‹ РїРѕРёСЃРєР°
        search_result = [];
        //РґРµР»Р°РµРј Р·Р°РїСЂРѕСЃ Рє РіРµРѕРєРѕРґРµСЂСѓ
        $.getJSON('http://geocode-maps.yandex.ru/1.x/?format=json&callback=?&geocode='+search_query, function(data) {
            //РіРµРѕРєРѕРґРµСЂ РІРѕР·РІСЂР°С‰Р°РµС‚ РѕР±СЉРµРєС‚, РєРѕС‚РѕСЂС‹Р№ СЃРѕРґРµСЂР¶РёС‚ РІ СЃРµР±Рµ СЂРµР·СѓР»СЊС‚Р°С‚С‹ РїРѕРёСЃРєР°
            //РґР»СЏ РєР°Р¶РґРѕРіРѕ СЂРµР·СѓР»СЊС‚Р°С‚Р° РІРѕР·РІСЂР°С‰Р°СЋС‚СЃСЏ РіРµРѕРіСЂР°С„РёС‡РµСЃРєРёРµ РєРѕРѕСЂРґРёРЅР°С‚С‹ Рё РЅРµРєРѕС‚РѕСЂР°СЏ РґРѕРїРѕР»РЅРёС‚РµР»СЊРЅР°СЏ РёРЅС„РѕСЂРјР°С†РёСЏ
            //РѕС‚РІРµС‚ РіРµРѕРєРѕРґРµСЂР° Р»РµРіРєРѕ РїРѕСЃРјРѕС‚СЂРµС‚СЊ СЃ РїРѕРјРѕС‰СЊСЋ console.log();
            for(var i = 0; i < data.response.GeoObjectCollection.featureMember.length; i++) {
                //Р·Р°РїРёСЃС‹РІР°РµРј РІ РјР°СЃСЃРёРІ СЂРµР·СѓР»СЊС‚Р°С‚С‹, РєРѕС‚РѕСЂС‹Рµ РІРѕР·РІСЂР°С‰Р°РµС‚ РЅР°Рј РіРµРѕРєРѕРґРµСЂ
                search_result.push({
                    label: data.response.GeoObjectCollection.featureMember[i].GeoObject.description+' - '+data.response.GeoObjectCollection.featureMember[i].GeoObject.name,
                    value:data.response.GeoObjectCollection.featureMember[i].GeoObject.description+' - '+data.response.GeoObjectCollection.featureMember[i].GeoObject.name,
                    longlat:data.response.GeoObjectCollection.featureMember[i].GeoObject.Point.pos});
            }
            //РїРѕРґРєР»СЋС‡Р°РµРј Рє С‚РµРєСЃС‚РѕРІРѕРјСѓ РїРѕР»СЋ РІРёРґР¶РµС‚ autocomplete
            $("#Address").autocomplete({
                //РІ РєР°С‡РµСЃС‚РІРµ РёСЃС‚РѕС‡РЅРёРєР° СЂРµР·СѓР»СЊС‚Р°С‚РѕРІ СѓРєР°Р·С‹РІР°РµРј РјР°СЃСЃРёРІ search_result
                source: search_result,
                select: function(event, ui){
                    //СЌС‚Рѕ СЃРѕР±С‹С‚РёРµ СЃСЂР°Р±Р°С‚С‹РІР°РµС‚ РїСЂРё РІС‹Р±РѕСЂРµ РЅСѓР¶РЅРѕРіРѕ СЂРµР·СѓР»СЊС‚Р°С‚Р°
                    //РєРѕРѕСЂРґРёРЅР°С‚С‹ С‚РѕС‡РµРє РЅР°РґРѕ РїРѕРјРµРЅСЏС‚СЊ РјРµСЃС‚Р°РјРё
                    console.log(ui.item);
                    var longlat = ui.item.longlat.split(" ");

                    var myPlacemark = new ymaps.Placemark([longlat[1], longlat[0]],{
                        balloonContentBody: ui.item.label,
                        hintContent: ui.item.label
                    });
                    myMap.geoObjects.add(myPlacemark);
                    myMap.setCenter([longlat[1], longlat[0]], 13);

                }
            });
        });

    });

    $.ui.autocomplete.filter = function (array, term) {
        return $.grep(array, function (value) {
            return value.label || value.value || value;
        });
    };

});
</script>