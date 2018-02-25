<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <script src="{!! asset('/jquery-3.2.1.min.js') !!}"></script> 
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/smoothness/jquery-ui.css" />
        <script src="http://api-maps.yandex.ru/2.0-stable/?load=package.full&lang=ru-RU" type="text/javascript"></script>
        <script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
        <script src="http://code.jquery.com/ui/1.9.1/jquery-ui.min.js"></script>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div id="myMap" style="width: 500px; height: 300px;"></div>
        Поиск: <input id="Address" type="text" value="" style="width: 445px; margin-top: 10px;" />



        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Главная страница</a>
                    @else
                        <a href="{{ url('/login') }}">Вход</a>  <!-- {{ route('login') }} -->
                        <a href="{{ url('/register') }}">Регистрация</a> <!-- {{ route('register') }} -->
                    @endauth
                </div>
            @endif

            @yield('content')

            <div class="content">
                <div class="title m-b-md">
                    Laravel
                </div>

                <div class="links">
                    <a href="https://laravel.com/docs">Documentation</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>
            </div>
        </div>
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