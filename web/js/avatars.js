function Avatars() {

    var data = {};
    var sending = false;
    var target;
    var userId;

    var init = function () {
        if ($('.avatar-index').length) {
            userId = $('.avatar-index').data('id');
        }
        addEvents();
    };

    var addEvents = function () {
        $('.avatar-pick').on('click', function () {
            if (!sending) {
                sending = true;
                target = $(this);
                var src = $(this).closest('.avatar').find('img').attr('src');
                sendAvatar(src);
            }
            return false;
        });
    };

    var sendAvatar = function(src) {
        data['src'] = src;
        $.ajax({
            type: "POST",
            url: "/admin/users/avatars/?user_id=" + userId,
            data: data,
            dataType: "json",
            complete: function(res) {
                sending = false;
                if (res && res.status === 200) {
                    console.log(res);
                    successPick();
                } else {
                    var response = res.responseText ? JSON.parse(res.responseText).message : 'Не удалось загрузить изображение';
                    flashError.setErrors(response);
                }
            }
        });
    };

    var successPick = function() {
        clearPick();
        target.closest('.avatar').addClass('picked');
    };

    var clearPick = function() {
        $('.avatar').removeClass('picked');
    };

    init();
}

var avatars = new Avatars();

