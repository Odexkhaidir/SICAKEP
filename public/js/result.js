$(document).ready(function () {

    function filterData() {
        let filter = {}

        filter['year'] = $(`#year`).val()
        filter['month'] = $(`#month`).val()
        return filter
    }

    $(`#month`).change(function (){     
        $('#result-card').addClass('d-none');
    })

    $(`#year`).change(function (){     
        $('#result-card').addClass('d-none');
    })

    function validateFilter() {
        if ($(`#year`).val() == '') {
            return false
        } else if ($(`#month`).val() == '') {
            return false
        }

        return true
    }

    function getRecap() {
        $('.loader').removeClass('d-none');
        $.ajax({
            type: 'POST',
            url: url_get_recap.href,
            data: {
                filter: sessionStorage.getItem("filterData"),
                _token: tokens,
            },

            success: function (result) {

                console.log(result)

                if (result.data) {

                    $('#result-card').removeClass('d-none');

                    $.each(result.data, function (key, value) {
                        if (value.average_score > 0) {
                            $('#realization_score_' + value.code).text((value.realization_score).toFixed(2));
                            $('#time_score_' + value.code).text((value.time_score).toFixed(2));
                            $('#quality_score_' + value.code).text((value.quality_score).toFixed(2));
                            $('#average_score_' + value.code).text((value.average_score).toFixed(2));
                            $('#rank_' + value.code).text((value.rank));
                        } else {
                            $('#realization_score_' + value.code).text('-');
                            $('#time_score_' + value.code).text('-');
                            $('#quality_score_' + value.code).text('-');
                            $('#average_score_' + value.code).text('-');
                            $('#rank_' + value.code).text('-');
                        }
                    })

                } else {

                    $('#result-card').addClass('d-none');

                }

                $.each(result.messages, function (index, message) {
                    window.showToastr(message['type'], message['text'])
                })

                $('.loader').addClass('d-none')
            },
        });
    }


    $('#filter-button').click(function () {
        if (validateFilter()) {
            sessionStorage.setItem("filterData", JSON.stringify(filterData()))
            getRecap()
        } else {
            window.showToastr('warning', 'Isian filter tidak boleh kosong')
        }
    })

});