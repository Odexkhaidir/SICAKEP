$(document).ready(function () {
    
    $('#team').on('change', function() {
        var team = this.value
        var year = $('#year').val();
        $("#suboutput").html('')

        $.ajax({
            type: 'POST',
            url: url_fetch_output.href,
            data: {
                team: team,
                year: year,
                _token: tokens,
            },
            dataType: 'json',

            success: function(result) {
                console.log(result);
                $('#suboutput').html('<option value=""> Pilih Output/Suboutput </option>');
                $.each(result, function(key, output) {
                    $.each(output.suboutput, function(key, suboutput) {
                        $('#suboutput').append('<option value="' + suboutput.id +
                            '">' + suboutput.name + '</option>');
                    });
                });
            },
        })
    });

    $("#save-button").click(function () {

        $('#modal-simpan').modal('toggle');

    });

    for (let index = 2; index <= 14; index++) {

        $(`#realization_score_${index}`).keyup(function (e) {
            average_score(index)
        })

        $(`#time_score_${index}`).keyup(function (e) {
            average_score(index)
        })

        $(`#quality_score_${index}`).keyup(function (e) {
            average_score(index)
        })
    }

    function average_score(index){
        let realization =  Number($(`#realization_score_${index}`).val())
        let time = Number($(`#time_score_${index}`).val())
        let quality = Number($(`#quality_score_${index}`).val())

        let average = (realization + time + quality) / 3

        $(`#average_score_${index}`).val(average.toFixed(2))
    }

});