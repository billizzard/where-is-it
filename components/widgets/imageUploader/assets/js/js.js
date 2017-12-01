/**
 * Created by v on 20.10.17.
 */
function ImageUploader() {
    var iu;
    var inputFile;
    var config = {};
    var hasError = false;

    var init = function() {
        fillOldImages();
        addEvents();
    };

    var fillOldImages = function() {
        $('.js-image-old-url').each(function() {
            setConfig($(this));
            updateInputUrlValue();
        })

    };

    var addEvents = function() {

        $('.iu').find('.js-add').on('click', function() {
            setConfig($(this));
            inputFile.trigger('click');
            return false;
        });

        $('.iu').find('input[type=file]').on('change', function() {
            upload();
        });

        $('.iu').on('click', '.js-delete', function() {
            if (confirm('Удалить?')) {
                setConfig($(this));
                deleteImage($(this));
            }
        });
    };

    var upload = function() {
        checkFiles();
        if (!hasError) {
            var formData = new FormData();
            var csrf = $('input[name=_csrf]');
            if (csrf.length) {
                formData.append(csrf.attr('name'), csrf.val());
            }
            formData.append(inputFile.attr('name'), '');
            for (var i = 0; i < inputFile.prop('files').length; i++) {
                checkFiles(inputFile.prop('files')[i]);
                formData.append(inputFile.attr('name'), inputFile.prop('files')[i]);
            }

            if (config.uploadUrl) {
                $.ajax({
                    url: config.uploadUrl,
                    dataType: 'text',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    type: 'post',
                    beforeSend: function () {
                    },
                    complete: function (res) {
                        if (res && res.status === 200) {
                            var files = res.responseText ? JSON.parse(res.responseText) : [];
                            setPreview(files);
                        } else {
                            var response = res.responseText ? JSON.parse(res.responseText).message : 'Не удалось загрузить изображение';
                            showError(response);
                        }
                    }
                });
            }
        }
    };

    var deleteImage = function(a) {
        if (config.deleteUrl) {
            deleteByUrl(a);
        } else {
            removePreview(a);
        }
    };

    var deleteByUrl = function(a) {

        var data = a.data('params');
        $.ajax({
            type: "POST",
            url: config.deleteUrl,
            data: data,
            dataType: "json",
            success: function (data, textStatus, xhr) {
                if (data){
                    removePreview(a);
                }
            },
            complete: function (res) {
                if (res && res.status !== 200) {
                    var response = res.responseText ? JSON.parse(res.responseText).message : 'Не удалось загрузить изображение';
                    showError('Недостаточно прав');
                }
            }
        });

        return false;
    };

    var removePreview = function(a) {
        a.closest('.iu_uploaded_img').remove();
        updateInputUrlValue();
    };

    var checkFiles = function(file) {
        if (file) {
            var imageType = /image.*/;

            if (!file.type.match(imageType)) {
                showError('Файл должен быть изображением')
            }
        } else {
            var current = iu.find('.iu_uploaded_img').length;
            if (inputFile.prop('files').length + current > config.maxFiles) {
                showError('Максимум ' + config.maxFiles + ' файла(ов)');
            }
        }

    };

    var setConfig = function(el) {
        hasError = false;
        iu = el.closest('.iu');
        inputFile = iu.find('input[type=file]');
        config.maxFiles = inputFile.data('maxfiles');
        config.uploadUrl = inputFile.data('uploadurl');
        config.errorCallback = inputFile.data('errorcallback');
        config.deleteUrl = inputFile.data('deleteurl');
        config.deleteButton = inputFile.data('deletebutton');
        config.uploadButton = inputFile.data('uploadbutton');
    };

    var setPreview = function(files) {
        if (files.length) {
            for (var i = 0; i < files.length; i++) {
                var url = '/' + files[i];
                var content = '<div class="iu_uploaded_img js-new-image">' +
                    '<img src="' + url + '">';
                if (config.deleteButton) {
                   // content += '<span href="#" class="delete" data-id=">">x</span>'
                    content += '<span class="iu-icon iu-icon-remove js-delete glyphicon glyphicon-remove"></span>'
                }
                content += '</div>';
                iu.find('.iu_gallery').append(content);
            }
        }
        updateInputUrlValue();
    };

    var updateInputUrlValue = function() {
        var urlArr = [];
        var urlOldArr = [];
        iu.find('.js-new-image img').each(function() {
            urlArr.push($(this).attr('src'));
        });
        iu.find('.js-image img').each(function() {
            urlOldArr.push($(this).attr('src'));
        });
        iu.find('.js-image-url').val(urlArr.join(','));
        iu.find('.js-image-old-url').val(urlOldArr.join(','));
    };

    var showSuccess = function(message) {
        if (config.errorCallback && window[config.errorCallback]) {
            window[config.errorCallback](true, message);
        }
    };

    var showError = function(message) {
        hasError = true;
        if (config.errorCallback && window[config.errorCallback]) {
            window[config.errorCallback](false, message);
        } else {
            alert(message);
        }
    };

    init();
}

var imageUploader = new ImageUploader();
