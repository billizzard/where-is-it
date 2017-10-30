function FileUploader() {

    this.previewContainer = '.fake-image';

    var init = function () {
        addEvents();
    };

    this.upload = function(inputId, callback) {
        var file = $('#' + inputId).prop('files')[0];
        var formData = new FormData();
        formData.append("Image[url]", '');
        formData.append("Image[url]", file);
        formData.append($('#csrf').attr('name'), $('#csrf').val());
        $.ajax({
            url: '/place/upload-image/',
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            type: 'post',
            beforeSend: function() {
                //console.log('beforeSend');
            },
            complete: function(res) {
                if (res && res.status === 200) {
                    callback(res);
                } else {
                    var response = res.responseText ? JSON.parse(res.responseText).message : 'Не удалось загрузить изображение';
                    flashError.setErrors(response);
                }
            }
        });
        //setPreview(file);
    };

    var processSuccess = function (res) {
        var url = res.responseText ? JSON.parse(res.responseText).url : '';
        if (url) {
            setPreview(url);
        }
    };

    var setPreview = function(file) {
            var imageType = /image.*/;

            if (!file.type.match(imageType)) {
                throw "File Type must be an image";
            }
            console.log('-----');

            // Using FileReader to display the image content
            var reader = new FileReader();
            reader.onload = (function(aImg) { return function(e) { console.log(e.target.result); }; })(file);
            reader.readAsDataURL(file);
    };


    var addEvents = function () {

    };

    init();
}

var fileUploader = new FileUploader();
