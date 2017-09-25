function Menu() {

    var init = function() {
        addEvents();
    };

    var addEvents = function() {
        var inputHidden = document.querySelector('#nav-toggle');

        $('.nav-toggle1').on('click', function() {
            inputHidden.checked = inputHidden.checked ? inputHidden.checked = false : inputHidden.checked = true;
            $('.wrap').addClass('slide');
            return false;
        });

        $('body').on('click', '.slide', function() {
            if (inputHidden.checked) {
                inputHidden.checked = false;
                $('.wrap').removeClass('slide');
            }
        })
    };

    init();
}

function LeftMenu() {

    var menu = $('nav.nav-menu');
    var links = menu.find('ul li a');
    var placeContainer = $('#add-place');

    var init = function() {
        addEvents();
    };

    var addEvents = function() {
        links.on('click', function() {
            var li = $(this).closest('li');
            changeClass(li);
            showSubMenu(li);
            addToInput(li);
            addToMap(li);
        });
    };

    var addToMap = function(li) {
        
    };

    var showSubMenu = function(li) {
        var subUl = li.find('ul');
        if (subUl.length) {
            subUl.slideToggle(500);
        }
    };

    var changeClass = function(li) {
        if (li.hasClass('opened')) {
            li.removeClass('opened');
        } else {
            li.addClass('opened');
        }
    };

    var addToInput = function(li) {
        var a = li.find('a');
        if (placeContainer.length) {
            if (!li.find('ul').length) {
                placeContainer.find('.js-point-category_id').val(a.data('id'));
                placeContainer.find('.js-point-category').val(a.text());
            }
        }
    };

    init();
}

function MapAdd() {

    var myPlacemark;

    var init = function() {
        if (document.querySelector('#ymapAdd')) {
            addEvents();
        }
    };

    var addEvents = function() {
        ymaps.ready(function () {
            var myMap = new ymaps.Map("ymapAdd", {
                center: [55.76, 37.64],
                controls: ['geolocationControl', 'zoomControl'],
                zoom: 10
            });

            myMap.events.add('click', function(e) {
                mapClickEvent(e, myMap);
            });

            //myPlacemark = new ymaps.Placemark([55.76, 37.64], { hintContent: 'Москва!', balloonContent: 'Столица России' });

            var lat, lon = '';
            if ($('.js-point-lat').length) {
                lat = $('.js-point-lat').val();
                lon = $('.js-point-lon').val();
            }

            if (lat && lon) {
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
            draggable: true
        });
    };

    init();
}

function FormPlace() {
    var form = $('#form-place');
    var error = false;
    var init = function() {
        addEvents();
    };

    var addEvents = function() {
        form.submit(function() {
            clearError();
            checkRequired();
            if (error) {
                return false;
            }
        })
    };

    var checkRequired = function() {
        form.find('.required').each(function() {
            if (!$.trim($(this).val())) {
                $(this).addClass('error');
                flashError.setErrors('Заполните обязательные поля');
                error = true;
            }
        });

        form.find('.required_coord').each(function() {
            if (!$.trim($(this).val())) {
                $(this).addClass('error');
                flashError.setErrors('Выберите точку на карте');
                error = true;
            }
        });
    };

    var clearError = function() {
        error = false;
        form.find('.error').removeClass('error');
    };

    init();
}


function FlashError() {

    var init = function() {
        addEvents();
    };

    var addEvents = function() {
        $('body').on('click', '.flash-errors .flash-errors__close', function() {
            $(this).closest('.flash-errors').remove();
        });
    };

    this.setErrors = function(error) {
        if ($('.flash-errors__text').length) {
            $('.flash-errors').remove();
        }

        $('body').append('<div class="flash-errors"><span class="flash-errors__text">' + error + '</span><div class="flash-errors__close">x</div></div>');
    };

    init();
}

function MapMain() {

    var myPlacemark;

    var init = function() {
        if (document.querySelector('#ymap')) {
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



        });
    };

    init();
}

var mapAdd = new MapAdd();
var menu = new Menu();
var leftMenu = new LeftMenu();
var formPlace = new FormPlace();
var flashError = new FlashError();


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

