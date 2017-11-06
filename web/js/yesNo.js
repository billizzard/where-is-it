function YesNoButtons() {

    var data = {};

    var init = function () {
        data['placeId'] = $('#place_id').val();
        data[$('#csrf').attr('name')] = $('#csrf').val();
        addEvents();
    };

    var addEvents = function () {
        $('.js-eye').on('click', function () {
            var vote = $(this).data('vote');
            var message = vote === 'yes' ? 'что место действительно есть' : 'что место отсутствует';
            if (confirm('Вы подтверждаете ' + message + '? За неверные голоса возможны баны.')) {
                sendVote(vote);
            }
            return false;
        });
    };

    var sendVote = function(vote) {
        if (vote === 'yes' || vote === 'no') {
            data['vote'] = vote;
            $.ajax({
                type: "POST",
                url: "/place/vote/",
                data: data,
                dataType: "json",
                complete: function(res) {
                    if (res && res.status === 200) {
                        flashError.setInfo('Спасибо. Ваш голос учтен.')
                    } else {
                        var response = res.responseText ? JSON.parse(res.responseText).message : 'Не удалось загрузить изображение';
                        flashError.setErrors(response);
                    }
                }
            });
        }
    };

    init();
}

var yesNoButtons = new YesNoButtons();

