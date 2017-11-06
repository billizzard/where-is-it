function PlaceMap(mapId, data) {

    var myPlacemark;
    var elMap = $('#' + mapId);

    var init = function () {
        if (elMap.length) {
            addEvents();
        }
    };

    var addEvents = function () {
        ymaps.ready(function () {
            if (elMap.data('lat')) {
                var lat = elMap.data('lat');
                var lon = elMap.data('lon');
                var myMap = new ymaps.Map(mapId, {
                    center: [lat, lon],
                    controls: ['geolocationControl', 'zoomControl'],
                    zoom: 11
                });
            }

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

    init();
}

var placeMap = new PlaceMap('placeMap');