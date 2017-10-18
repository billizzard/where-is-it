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

deleteUpload = new DeleteUpload();