function Menu() {

    var init = function () {
        addEvents();
    };

    var addEvents = function () {
        var inputHidden = document.querySelector('#nav-toggle');

        $('.nav-toggle1').on('click', function () {
            inputHidden.checked = inputHidden.checked ? inputHidden.checked = false : inputHidden.checked = true;
            $('.wrap').addClass('slide');
            return false;
        });

        $('body').on('click', '.slide', function () {
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

    var init = function () {
        addEvents();
    };

    var addEvents = function () {
        links.on('click', function () {
            var li = $(this).closest('li');
            changeClass(li);
            showSubMenu(li);
            addToInput(li);
            return false;
        });
        menu.find('.nav-menu__close').on('click', function () {
            leftMenu.close();
        });
    };

    var showSubMenu = function (li) {
        var subUl = li.find('ul');
        if (subUl.length) {
            subUl.slideToggle(500);
        }
    };

    var changeClass = function (li) {
        if (li.hasClass('opened')) {
            li.removeClass('opened');
        } else {
            li.addClass('opened');
        }
    };

    var addToInput = function (li) {
        var a = li.find('a');
        if (placeContainer.length) {
            if (!li.find('ul').length) {
                placeContainer.find('.js-point-category_id').val(a.data('id'));
                placeContainer.find('.js-point-category').val(a.text());
                leftMenu.close();
            }
        }
    };

    this.show = function () {
        inputHidden.checked = true;
    };

    this.close = function () {
        inputHidden.checked = false;
    };

    init();
}

function MapAdd() {

    var myPlacemark;

    var init = function () {
        if (document.querySelector('#ymapAdd')) {
            addEvents();
        }
    };

    var addEvents = function () {
        ymaps.ready(function () {
            var myMap = new ymaps.Map("ymapAdd", {
                center: [cookie.get('lat'), cookie.get('lon')],
                controls: ['geolocationControl', 'zoomControl'],
                zoom: 11
            });

            myMap.events.add('click', function (e) {
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
        console.log(map.getBounds());
        getAddress(coords);
    };

    // Определяем адрес по координатам (обратное геокодирование).
    var getAddress = function (coords) {
        myPlacemark.properties.set('iconCaption', 'поиск...');
        ymaps.geocode(coords).then(function (res) {
            var firstGeoObject = res.geoObjects.get(0);
            var coordinates = firstGeoObject.geometry.getCoordinates();

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
        document.querySelector('.js-point-address').value = address;
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

function TopMenu() {
    var init = function () {
        addEvents();
    };

    var addEvents = function () {
        $('.menu-butt').hover(function () {
            $('.menu-butt span').addClass('hover');
        }, function () {
            $('.menu-butt span').removeClass('hover');
        });
    };

    init();

}

function FormPlace() {
    var form = $('#form-place');
    var error = false;
    var init = function () {
        addEvents();
    };

    var addEvents = function () {
        form.submit(function () {
            clearError();
            checkRequired();
            if (error) {
                return false;
            }
        });

        $('.js-fake-image').on('click', function() {
            $('.js-image').trigger('click');
        });

        $('.js-image').on('change', function() {
            fileUploader.upload('image', successUpload);
        });

        $('.remove-icon').on('click', function() {
            removePreview();
            return false;
        });
    };

    var successUpload = function(res) {
        var url = res.responseText ? JSON.parse(res.responseText) : '';
        if (url.length) {
            setPreview(url[0]);
        }

    };

    var setPreview = function(url) {
        if (url) {
            $('.js-fake-image').css('background-image', 'url(/' + url.addFilePrefix('add_') + ')');
            $('#image-hid').val(url);
            $('.camera-icon').css('display', 'none');
            $('.remove-icon').css('display', 'block');
        }
    };

    var removePreview = function() {
        $('.js-fake-image').css('background-image', '');
        $('#image-hid').val('');
        $('.camera-icon').css('display', 'block');
        $('.remove-icon').css('display', 'none');
    };

    var checkRequired = function () {
        form.find('.required').each(function () {
            if (!$.trim($(this).val())) {
                $(this).addClass('error');
                flashError.setErrors('Заполните обязательные поля');
                error = true;
            }
        });

        form.find('.required_coord').each(function () {
            if (!$.trim($(this).val())) {
                $(this).addClass('error');
                flashError.setErrors('Выберите точку на карте');
                error = true;
            }
        });
    };

    var clearError = function () {
        error = false;
        form.find('.error').removeClass('error');
    };

    init();
}


function FlashError() {

    var init = function () {
        addEvents();
    };

    var addEvents = function () {
        $('body').on('click', '.flash-errors .flash-errors__close', function () {
            removeMessage();
        });
    };

    var getMessage = function (type, message) {
        return '<div class="flash-errors ' + type + '"><span class="flash-errors__text">' + message + '</span><div class="flash-errors__close">x</div></div>'
    };

    var removeMessage = function () {
        if ($('.flash-errors__text').length) {
            $('.flash-errors').remove();
        }
    };

    this.setErrors = function (message) {
        removeMessage();
        $('body').append(getMessage('error', message));
    };

    this.setInfo = function (message) {
        removeMessage();
        $('body').append(getMessage('info', message));
    };

    init();
}

function BaseMap() {
    this.getBalloonContent = function (item) {
        var footer = "<div class='cus-balloon__footer'>";
        if (item.type == 0) {
            footer += "<div class='confirmation js-yes-no'><span class='yes'>" + item.yes + "</span> / <span class='no'>" + item.no + "</span></div>";
        }
        footer += "<a href='/place/" + item.id + "/' class='glyphicon glyphicon-share-alt more'></a>";
        footer += "</div>";

        var image = '';
        if (item.url && item.url['map_']) {
            image = "<div class='cus-balloon__img'><img src='/" + item.url['map_'] + "'></div>";
        }


        var content = "" +
            "<div class='cus-balloon'>" +
            "<div class='cus-balloon__header'>" + item.name + "</div>" +
            image +

            "<div class='cus-balloon__body'>" +
            "<div class='work_time'>" + item.work_time + "</div>" +
            "<div class='work_time'>" + item.work_time + "</div>" +
            "<div class='work_time'>" + item.work_time + "</div>" +
            "<div class='work_time'>" + item.work_time + "</div>" +
            "<div class='work_time'>" + item.work_time + "</div>" +
            "<div class='work_time'>" + item.work_time + "</div>" +
            "<div class='description'>" + item.description + "</div>" +
            "</div>" +
            footer +

            //"<div class='butt plus'><a href='#' class='glyphicon glyphicon-plus'></a></div>" +
            //"<div class='butt plus'><a href='#' class='glyphicon glyphicon-plus'></a><br>14</div>" +
            //"<div class='butt minus'><a href='#' class='glyphicon glyphicon-minus'></a><br>12</div>" +
            "</div>";

        return content;
    };

    // this.getThumbUrl = function (url) {
    //     var pos = url.lastIndexOf('/');
    //     if (pos !== -1) {
    //         url = url.addSubStr(pos + 1, 'thumb_');
    //     }
    //     return url;
    // };

    this.getPlacemark = function (item, color) {
        return new ymaps.Placemark([item.lat, item.lon], {
            hintContent: item.name,
            balloonContentHeader: false,
            balloonContentBody: baseMap.getBalloonContent(item)
        }, {
            iconColor: color,
            balloonCloseButton: false,
            hideIconOnBalloonOpen: false,
            balloonOffset: [0, -37]
        })
    }
}

function MapMain() {

    var myMap;
    var currPlace;
    var balloonOpened = false;
    var minLat = 0;
    var maxLat = 0;
    var minLon = 0;
    var maxLon = 0;

    var init = function () {
        if (document.querySelector('#ymap')) {
            addEvents();
        }
    };

    var addEvents = function () {
        $('body').on('click', '.js-yes-no', function () {
            flashError.setInfo('Место еще не подтвержено администратором. Вы можете помочь подтвердить информацию в подробном описании места.')
        });
        ymaps.ready(function () {
            myMap = new ymaps.Map("ymap", {
                center: [cookie.get('lat'), cookie.get('lon')],
                controls: ['geolocationControl', 'zoomControl'],
                zoom: 11
            });

            //createPlacemark();

            $('nav.nav-menu a').on('click', function () {
                currPlace = $(this);
                addToMap();
                return false;
            });

            myMap.events.add('balloonopen', function (event) {
                balloonOpened = true;
            });

            myMap.events.add('balloonclose', function (event) {
                balloonOpened = false;
            });

            myMap.events.add('boundschange', function (event) {
                addToMap();
            });

            myMap.events.add('actionend', function (event) {
                addToMap();
            });

        });

        var addToMap = function () {
            var data = {};
            data['size'] = myMap.getBounds();
            if (isNeedGetPlaces(data['size'])) {
                data['category_id'] = currPlace.data('id');
                var csrfName = $('#csrfParam').attr('name');
                var csrfVal = $('#csrfParam').val();
                data[csrfName] = csrfVal;

                $.ajax({
                    type: "POST",
                    url: "/place/get-by-category/",
                    data: data,
                    dataType: "json",
                    success: function (data, textStatus, xhr) {
                        if (data.length) {
                            data.forEach(function (item) {
                                leftMenu.close();
                                clearMap();
                                createPlacemark(item);
                            });
                        }
                    }
                });
            }
        };

        var isNeedGetPlaces = function (size) {
            // Если выбрана категория
            if (currPlace && !balloonOpened) {
                // И если это не родительская категория
                if (!currPlace.closest('li').find('ul').length) {
                    if (size[0][0] < minLat ||
                        size[1][0] > maxLat ||
                        size[0][1] < minLon ||
                        size[1][1] > maxLon) {

                        minLat = size[0][0];
                        maxLat = size[1][0];
                        minLon = size[0][1];
                        maxLon = size[1][1];
                        return true;
                    }
                }
            }
            return false;
        };

        var clearMap = function () {
            myMap.geoObjects.removeAll();
        };

        var createPlacemark = function (item) {
            if (item) {
                var color = '#' + (item.color ? item.color : '000000');

                var myGroup = new ymaps.GeoObjectCollection({}, {});

                if (item.places && item.places.length) {
                    item.places.forEach(function (item) {
                        // Добавляем в группу метки и линию.
                        myGroup.add(baseMap.getPlacemark(item, color));
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
                    // if (setCenter) {
                    //     myMap.setBounds(myGroup.getBounds());
                    // }
                    // Устанавливаем карте центр и масштаб так, чтобы охватить группу целиком.
                    // if (item.places.length == 1) {
                    //     console.log();
                    //     myMap.setZoom(13);
                    // }

                    //myMap.geoObjects.add(mark);
                }
            }


        };
    };

    init();
}


function GeoPopup() {
    var time = 60 * 60 * 24 * 300;

    var init = function () {
        addEvents();
    };

    var addEvents = function () {
        $(".modal-trigger").click(function (e) {
            e.preventDefault();
            show($(this).attr("data-modal"));
        });

        $(".close-modal, .modal-sandbox").click(function () {
            close();
        });
    };

    var show = function (dataModal) {
        $("#" + dataModal).css({"display": "block"});
    };

    var close = function () {
        var newCity = $('#selectGeoCity').val();
        var newCityName = $('#selectGeoCity option:selected').text();
        var oldCity = cookie.get('city_id');
        if (newCity !== oldCity) {
            cookie.set('city_id', newCity, time);
            cookie.set('city_name', newCityName, time);
            document.location.reload();
        }
        $(".modal").css({"display": "none"});
    };

    init();
}

function Cookie() {
    this.set = function (name, value, sec) {
        var date = new Date(new Date().getTime() + sec * 1000);
        document.cookie = name + "=" + value + "; path=/; expires=" + date.toUTCString();
    };

    this.get = function (name) {
        var matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    };

    this.delete = function (name) {
        this.set(name, "", -1);
    }
}

function Stars() {

    var data = {};

    var init = function() {
        data['placeId'] = $('#place_id').val();
        data[$('#csrf').attr('name')] = $('#csrf').val();
        addEvents();
    };

    var addEvents = function() {
        $('.js-star').on('mouseenter', function() {
            if (!$(this).hasClass('glyphicon-star')) {
                $(this).prevAll().removeClass('glyphicon-star-empty').addClass('glyphicon-star');
                $(this).removeClass('glyphicon-star-empty').addClass('glyphicon-star');
            }
        });

        $('.js-star').on('mouseleave', function() {
            if (!$(this).hasClass('glyphicon-star-empty')) {
                $(this).prevAll().removeClass('glyphicon-star').addClass('glyphicon-star-empty');
                $(this).removeClass('glyphicon-star').addClass('glyphicon-star-empty');
            }
        });

        $('.js-r-star').on('click', function() {

            $(this).prevAll().removeClass('glyphicon-star-empty').addClass('glyphicon-star');
            $(this).nextAll().removeClass('glyphicon-star').addClass('glyphicon-star-empty');
            $(this).removeClass('glyphicon-star-empty').addClass('glyphicon-star');

            var count = $('.js-r-star.glyphicon-star').length;
            $('#star').val(count);
            return false;
        });

    };

    init();
}

function widgetUploadErrors(success, message) {
    flashError.setErrors(message);
}


var cookie = new Cookie();
//var geoPopup = new GeoPopup();
var baseMap = new BaseMap();
var mapAdd = new MapAdd();
var menu = new Menu();
var leftMenu = new LeftMenu();
var formPlace = new FormPlace();
var flashError = new FlashError();
var mapMain = new MapMain();
var topMenu = new TopMenu();
var stars = new Stars();


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


