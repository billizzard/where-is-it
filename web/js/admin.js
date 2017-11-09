function DeleteUpload() {
    var init = function() {
        addEvents();
    };

    var addEvents = function() {
        $('.uploaded_img .delete').on('click', function() {
            var a = $(this);
            if (confirm('Удалить фото?')) {

                var data = {id: a.data('id')};
                $.ajax({
                    type: "POST",
                    url: "/admin/places/remove-image/",
                    data: data,
                    dataType: "json",
                    success: function (data, textStatus, xhr) {
                        if (data){
                            removeImage(a);
                        } else {
                            flashError.setErrors('Не удалось удалить');
                        }
                    }
                });
            }
            return false;
        });
    };

    var removeImage = function(a) {
        a.closest('.uploaded_img').remove();
    };

    init();
}

function Schedule() {

    var init = function() {
        addEvents();
    };

    var addEvents = function() {
        $('.js-output').on('click', function() {
            changeVisibility($(this));
        });

        $('.js-schedule input').on('change', function() {
            if ($(this).val() !== '00:00') {
                $(this).closest('tr').find('.js-output').prop('checked', false);
            }
        })
    };

    var changeVisibility = function(el) {
        el.closest('tr').find('input').val('00:00');
    };

    init();
}

$('#discount-start_date, #discount-end_date').datetimepicker({
    format:'Y-m-d H:i'
});

deleteUpload = new DeleteUpload();
schedule = new Schedule();