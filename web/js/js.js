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
    var inputHidden = document.querySelector('#nav-toggle');

    var init = function() {
        addEvents();
    };

    var addEvents = function() {
        links.on('click', function() {
            var li = $(this).closest('li');
            changeClass(li);
            showSubMenu(li);
            addToInput(li);
        });
        menu.find('.nav-menu__close').on('click', function() {
            leftMenu.close();
        });
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

    this.show = function() {
        inputHidden.checked = true;
    };

    this.close = function() {
        inputHidden.checked = false;
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
        console.log(map.getBounds());
        getAddress(coords);
    };

    // Определяем адрес по координатам (обратное геокодирование).
    var getAddress = function (coords) {
        myPlacemark.properties.set('iconCaption', 'поиск...');
        ymaps.geocode(coords).then(function (res) {
            var firstGeoObject = res.geoObjects.get(0);
            //console.log('firstGeo');
            var coordinates = firstGeoObject.geometry.getCoordinates();
            //console.log(firstGeoObject);
            console.log(coordinates);
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
            console.log(address[0]);
            console.log(address[1]);
            var add = firstGeoObject.getAddressLine();
            console.log(add);


            insertAddress(add);
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

function TopMenu() {
    var init = function() {
        addEvents();
    };

    var addEvents = function() {
        $('.menu-butt').hover(function() {
            $('.menu-butt span').addClass('hover');
        }, function() {
            $('.menu-butt span').removeClass('hover');
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

    var myMap;
    var maxZoom;
    var currPlace;

    var init = function() {
        if (document.querySelector('#ymap')) {
            addEvents();
        }
    };

    var addEvents = function() {
        ymaps.ready(function () {
            myMap = new ymaps.Map("ymap", {
                center: [55.76, 37.64],
                controls: ['geolocationControl', 'zoomControl'],
                zoom: 10
            });

            createPlacemark();

            $('nav.nav-menu a').on('click', function() {
                currPlace = $(this);
                addToMap();
            });

            myMap.events.add('boundschange', function (event) {
                if (event.get('newZoom') > maxZoom) {
                    maxZoom = event.get('newZoom');
                    if (currPlace) {
                        addToMap();
                    }
                }
            });

        });

        var addToMap = function() {
            if (!currPlace.closest('li').find('ul').length) {
                var data = {};
                data['category_id'] = currPlace.data('id');
                var csrfName = $('#csrfParam').attr('name');
                var csrfVal = $('#csrfParam').val();
                data[csrfName] = csrfVal;
                data['size'] = myMap.getBounds();

                $.ajax({
                    type: "POST",
                    url: "/place/get-by-category/",
                    data:  data,
                    dataType: "json",
                    success: function(data, textStatus, xhr){
                        if (data.length) {
                            data.forEach(function(item) {
                                leftMenu.close();
                                clearMap();
                                createPlacemark(item)
                            });

                        }
                    }
                });
            }
        };

        var clearMap = function() {
            myMap.geoObjects.removeAll();
        };

        var createPlacemark = function(item) {
            if (item) {
                var color = '#' + (item.color ? item.color : '000000');

                var myGroup = new ymaps.GeoObjectCollection({}, {});

                if (item.places && item.places.length) {
                    item.places.forEach(function (item) {
                        // Добавляем в группу метки и линию.
                        myGroup.add(new ymaps.Placemark([item.lat, item.lon], {
                            hintContent: item.name,
                            balloonContentHeader: false,
                            balloonContentBody: "" +
                            "<div class='cus-balloon'>" +
                            "<div class='cus-balloon__header'>" + item.name + "</div>" +
                            "<div class='cus-balloon__body'>" + item.description + "</div>" +
                            "<div class='cus-balloon__footer'>подробнее</div>" +
                            "</div>" +
                            "",
                        }, {
                            iconColor: color,
                            balloonCloseButton: false,
                            hideIconOnBalloonOpen: false,
                            balloonOffset: [0, -37]
                        }));
                    });

                    // myGroup.add(new ymaps.Placemark(["55.774709776995", "37.839813842773"], {
                    //     hintContent: '#cccccc',
                    // }, {
                    //     iconColor: '#cccccc',
                    // }));
                    //
                    // myGroup.add(new ymaps.Placemark(["55.794709776995", "37.839813842773"], {
                    //     hintContent: '#9dc2fb',
                    // }, {
                    //     iconColor: '#9dc2fb',
                    // }));
                    //
                    // myGroup.add(new ymaps.Placemark(["55.814709776995", "37.839813842773"], {
                    //     hintContent: '#dcdcdc',
                    // }, {
                    //     iconColor: '#dcdcdc',
                    // }));
                    //
                    // myGroup.add(new ymaps.Placemark(["55.834709776995", "37.839813842773"], {
                    //     hintContent: '#001dff',
                    // }, {
                    //     iconColor: '#001dff',
                    // }));
                    //
                    // myGroup.add(new ymaps.Placemark(["55.854709776995", "37.839813842773"], {
                    //     hintContent: '#fff67f',
                    // }, {
                    //     iconColor: '#fff67f',
                    // }));

                    // Добавляем группу на карту.
                    myMap.geoObjects.add(myGroup);
                    myMap.setBounds(myGroup.getBounds());
                    // Устанавливаем карте центр и масштаб так, чтобы охватить группу целиком.
                    if (item.places.length == 1) {
                        myMap.setZoom(13);
                    }

                    //myMap.geoObjects.add(mark);
                }
            }



        };
    };

    init();
}



function GeoPopup() {
    var time = 60 * 60 * 24 * 300;

    var init = function() {
        addEvents();
    };

    var addEvents = function() {
        $(".modal-trigger").click(function(e){
            e.preventDefault();
            show($(this).attr("data-modal"));
        });

        $(".close-modal, .modal-sandbox").click(function(){
            close();
        });
    };

    var show = function(dataModal) {
        $("#" + dataModal).css({"display":"block"});
    };

    var close = function() {
        var newCity = $('#selectGeoCity').val();
        var newCityName = $('#selectGeoCity option:selected').text();
        var oldCity = cookie.get('city_id');
        if (newCity !== oldCity) {
            cookie.set('city_id', newCity, time);
            cookie.set('city_name', newCityName, time);
            document.location.reload();
        }
        $(".modal").css({"display":"none"});
    };

    init();
}

function Cookie() {
    this.set = function(name, value, sec) {
        var date = new Date(new Date().getTime() + sec * 1000);
        document.cookie = name + "=" + value + "; path=/; expires=" + date.toUTCString();
    };

    this.get = function(name) {
        var matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    };

    this.delete = function(name) {
        this.set(name, "", -1);
    }
}





var cookie = new Cookie();
var geoPopup = new GeoPopup();
var mapAdd = new MapAdd();
var menu = new Menu();
var leftMenu = new LeftMenu();
var formPlace = new FormPlace();
var flashError = new FlashError();
var mapMain = new MapMain();
var topMenu = new TopMenu();


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


/*
 ===============================================================

 Hi! Welcome to my little playground!

 My name is Tobias Bogliolo. 'Open source' by default and always 'responsive',
 I'm a publicist, visual designer and frontend developer based in Barcelona.

 Here you will find some of my personal experiments. Sometimes usefull,
 sometimes simply for fun. You are free to use them for whatever you want
 but I would appreciate an attribution from my work. I hope you enjoy it.

 ===============================================================
 */

