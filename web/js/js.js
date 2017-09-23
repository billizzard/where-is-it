function Menu() {

    var init = function() {
        addEvents();
    };

    var addEvents = function() {
        var elem = document.querySelector('.nav-toggle1');
        var inputHidden = document.querySelector('#nav-toggle');

        elem.addEventListener('click', function() {
            inputHidden.checked = inputHidden.checked ? inputHidden.checked = false : inputHidden.checked = true;
        })
    };

    init();
}

function LeftMenu() {

    var menu = $('nav.nav-menu');
    var links = menu.find('ul li');

    var init = function() {
        addEvents();
    };

    var addEvents = function() {
        links.on('click', function() {
            showSubMenu($(this));
        });
    };

    var showSubMenu = function(li) {
        var subUl = li.find('ul');
        if (subUl.length) {
            subUl.slideToggle(500);
        }
    };

    init();
}

function MapAdd() {

    var myPlacemark;

    var init = function() {
        if (document.querySelector('#ymap')) {
            console.log('yes');
            addEvents();
        }
    };

    var addEvents = function() {
        ymaps.ready(function () {
            var myMap = new ymaps.Map("ymap", {
                center: [55.76, 37.64],
                controls: ['geolocationControl', 'zoomControl'],
                zoom: 10
            });

            myMap.events.add('click', function(e) {
                mapClickEvent(e, myMap);
            });

        });
    };

    var mapClickEvent = function(e, map) {
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
            var address = [
                // Название населенного пункта или вышестоящее административно-территориальное образование.
                firstGeoObject.getLocalities().length ? firstGeoObject.getLocalities() : firstGeoObject.getAdministrativeAreas(),
                // Получаем путь до топонима, если метод вернул null, запрашиваем наименование здания.
                firstGeoObject.getThoroughfare() || firstGeoObject.getPremise()
            ].filter(Boolean).join(', ');


            insertAddress(firstGeoObject.getAddressLine());
            insertCoords(coords);

            myPlacemark.properties
                .set({
                    iconCaption:'',
                    // В качестве контента балуна задаем строку с адресом объекта.
                    balloonContent: ''
                });
        });
    };

    var insertAddress = function(address) {
        document.querySelector('.js-point-address').value = address;
    };

    var insertCoords = function(coords) {
        if (coords.length) {
            document.querySelector('.js-point-lat').value = coords[0];
            document.querySelector('.js-point-lon').value = coords[1];
        }

    };

    var createPlacemark = function(coords) {

        return new ymaps.Placemark(coords, {
            iconCaption: 'поиск...'
        }, {
            preset: 'islands#violetDotIconWithCaption',
            draggable: true
        });
    };

    init();
}

var mapAdd = new MapAdd();
var menu = new Menu();
var leftMenu = new LeftMenu();


// ymaps.ready(function () {
//     var myMap = new ymaps.Map("ymap", {
//         center: [55.76, 37.64],
//         zoom: 10,
//         type: "yandex#satellite",
//         // Карта будет создана без
//         // элементов управления.
//         controls: []
//     });
//
//     // Создание метки
//     var myPlacemark = new ymaps.Placemark(
//         // Координаты метки
//         [55.76, 37.64],
//         {
//             //iconContent: 'Нижний Новгород'
//             hintContent: 'Нижний Новгород',
//             balloonContent: "<span style='color:red'>Столица</span> России",
//         },
//         {
//             draggable: true, // Метку можно перетаскивать, зажав левую кнопку мыши.
//             preset: 'twirl#redIcon',
//             /* - показывать значок метки
//              при открытии балуна */
//             hideIconOnBalloonOpen: false
//             // Цвет метки. Опция iconColor может быть
//             // задана совместно с опцией preset,
//             // если последняя не принимает значение 'stretchyIcon'.
//             //iconColor: '#00000'
//             // Один из двух стандартных макетов
//             // меток со значком-картинкой:
//             // - default#image - без содержимого;
//             // - default#imageWithContent - с текстовым
//             // содержимым в значке.
//             // iconLayout: 'default#image',
//             // iconImageHref: '/path/to/icon.png',
//             // iconImageSize: [20, 30],
//             // iconImageOffset: [-10, -20]
//         }
//     );
//
//     // Слушаем клик на карте.
//     myMap.events.add('click', function (e) {
//         var coords = e.get('coords');
//
//         // Если метка уже создана – просто передвигаем ее.
//         if (myPlacemark) {
//             myPlacemark.geometry.setCoordinates(coords);
//         }
//         // Если нет – создаем.
//         else {
//             myPlacemark = createPlacemark(coords);
//             myMap.geoObjects.add(myPlacemark);
//             // Слушаем событие окончания перетаскивания на метке.
//             myPlacemark.events.add('dragend', function () {
//                 getAddress(myPlacemark.geometry.getCoordinates());
//             });
//         }
//         getAddress(coords);
//     });
//
//     // Создание метки.
//     function createPlacemark(coords) {
//
//         return new ymaps.Placemark(coords, {
//             iconCaption: 'поиск...'
//         }, {
//             preset: 'islands#violetDotIconWithCaption',
//             draggable: true
//         });
//     }
//
//
//     myPlacemark.events.add("beforedrag", function (event) {
//         console.log('--------');
//         var originalOffset = event.get("pixelOffset");
//         event.callMethod("setPixelOffset", [originalOffset[0], 0]);
//     });
//
//     // Добавление метки на карту
//     myMap.geoObjects.add(myPlacemark);
//
//     var myPlacemark2 = new ymaps.Placemark(
//         [55.8, 37.6],
//         {},
//         {
//             preset: 'islands#circleIcon',
//             // Цвет метки. Опция iconColor может быть
//             // задана совместно с опцией preset,
//             // если последняя не принимает значение 'stretchyIcon'.
//             iconColor: '#00000'
//             // Один из двух стандартных макетов
//             // меток со значком-картинкой:
//             // - default#image - без содержимого;
//             // - default#imageWithContent - с текстовым
//             // содержимым в значке.
//             // iconLayout: 'default#image',
//             // iconImageHref: '/path/to/icon.png',
//             // iconImageSize: [20, 30],
//             // iconImageOffset: [-10, -20]
//         }
//     );
// });

