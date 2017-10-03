function AdminPlaceMap() {

    var myPlacemark;
    var elMap = $('#ymapAdminPlaceMap');

    var init = function () {
        if (elMap.length) {
            addEvents();
        }
    };

    var addEvents = function () {
        ymaps.ready(function () {
            var lat = cookie.get('lat');
            var lon = cookie.get('lon');
            if (elMap.data('lat')) {
                lat = elMap.data('lat');
                lon = elMap.data('lon');
            }

            var myMap = new ymaps.Map("ymapAdminPlaceMap", {
                center: [lat, lon],
                controls: ['geolocationControl', 'zoomControl'],
                zoom: 11
            });

            myMap.events.add('click', function (e) {
                mapClickEvent(e, myMap);
            });

            //myPlacemark = new ymaps.Placemark([elMap.data('lat'), elMap.data('lon')], { hintContent: 'Москва!', balloonContent: 'Столица России' });


            if (elMap.data('lat')) {
                var mark = new ymaps.Placemark(
                    [lat, lon],
                    {},
                    {
                        //iconColor: '#00000'
                    }
                );

                myMap.geoObjects.add(mark);
            }

        });
    };

    var mapClickEvent = function (e, map) {
        var coords = e.get('coords');

        // Если метка уже создана – просто передвигаем ее.
        if (myPlacemark) {
            myPlacemark.geometry.setCoordinates(coords);
        }
        // Если нет – создаем.
        else {
            myPlacemark = createPlacemark(coords);
            map.geoObjects.add(myPlacemark);
            // Слушаем событие окончания перетаскивания на метке.
            myPlacemark.events.add('dragend', function () {
                getAddress(myPlacemark.geometry.getCoordinates());
            });
        }
        getAddress(coords);
    };

    // Определяем адрес по координатам (обратное геокодирование).
    var getAddress = function (coords) {
        myPlacemark.properties.set('iconCaption', 'поиск...');
        ymaps.geocode(coords).then(function (res) {
            var firstGeoObject = res.geoObjects.get(0);

            // var address = [
            //     // Название населенного пункта или вышестоящее административно-территориальное образование.
            //     firstGeoObject.getLocalities().length ? firstGeoObject.getLocalities() : firstGeoObject.getAdministrativeAreas(),
            //     // Получаем путь до топонима, если метод вернул null, запрашиваем наименование здания.
            //     firstGeoObject.getThoroughfare() || firstGeoObject.getPremise()
            // ].filter(Boolean).join(', ');

            var address = [
                // Название населенного пункта или вышестоящее административно-территориальное образование.
                firstGeoObject.getLocalities().length ? firstGeoObject.getLocalities() : firstGeoObject.getAdministrativeAreas(),
                // Получаем путь до топонима, если метод вернул null, запрашиваем наименование здания.
                firstGeoObject.getThoroughfare() || firstGeoObject.getPremise()
            ];
            var add = firstGeoObject.getAddressLine();

            insertAddress(add);
            insertCoords(coords);

            myPlacemark.properties
                .set({
                    iconCaption: '',
                    // В качестве контента балуна задаем строку с адресом объекта.
                    balloonContent: ''
                });
        });
    };

    var insertAddress = function (address) {
        $('.js-point-address').text(address);
    };

    var insertCoords = function (coords) {
        if (coords.length) {
            document.querySelector('.js-point-lat').value = coords[0];
            document.querySelector('.js-point-lon').value = coords[1];
        }

    };

    var createPlacemark = function (coords) {

        return new ymaps.Placemark(coords, {
            iconCaption: 'поиск...'
        }, {
            draggable: true
        });
    };

    init();
}

var adminPlaceMap = new AdminPlaceMap();

