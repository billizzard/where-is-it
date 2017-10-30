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

        $('.js-schedule select').on('change', function() {
            $(this).closest('tr').find('.js-output').prop('checked', false);
        })
    };

    var changeVisibility = function(el) {
        el.closest('tr').find('select').val('-1');
    };

    init();
}

deleteUpload = new DeleteUpload();
schedule = new Schedule();