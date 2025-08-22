$(document).ready(function () {
    
    function filterData() {
        let filter = {}

        filter['year'] = $(`#year`).val()
        filter['month'] = $(`#month`).val()
        filter['team'] = $(`#team`).val()
        return filter
    }

    function validateFilter() {
        if ($(`#team`).val() == '') {
            return false
        } else if ($(`#year`).val() == '') {
            return false
        } else if ($(`#month`).val() == '') {
            return false
        }

        return true
    }

    $('#year').on('change', function() {
        var year = this.value
        $("#team").html('')

        $.ajax({
            type: 'POST',
            url: url_fetch_filter.href,
            data: {
                year: year,
                _token: tokens,
            },
            dataType: 'json',

            success: function(result) {
                console.log(result);
                $('#team').html('<option value=""> Pilih Tim Kerja </option>');
                $.each(result.data, function(index, team) {
                        $('#team').append('<option value="' + team.id +
                            '">' + team.name + '</option>');
                });
            },
        })
    });

    function fetchData() {
        $('.loader').removeClass('d-none');
        $("#evaluation-table tbody").empty();
        $.ajax({
            type: 'POST',
            url: url_get_data.href,
            data: {
                filter: sessionStorage.getItem("filterData"),
                _token: tokens,
            },

            success: function (result) {

                console.log(result)

                $.each(result.data, function (index, item) {

                    let status = ''
                    let action = ''
                    let suboutput_name = ''

                    if (item.status == 0) {
                        status = `<td class="text-center"><span class="badge bg-danger"> entri </span></td>`
                        action = submitButton(item.id) + showButton(item.id) + editButton(item.id) + deleteButton(item.id)

                    } else if (item.status == 1) {
                        status = `<td class="text-center"><span class="badge bg-warning"> submit </span></td>`
                        action = showButton(item.id) + editButton(item.id)

                    } else if (item.status == 2) {
                        status = `<td class="text-center"><span class="badge bg-primary"> approved </span></td>`
                        action = showButton(item.id) 

                    } else if (item.status == 3) {
                        status = `<td class="text-center"><span class="badge bg-success"> final </span></td>`
                        action = showButton(item.id)
                    }

                    if(item.suboutput){
                        suboutput_name = item.suboutput.name
                    } else {
                        suboutput_name = 'Tidak Ada Kegiatan'
                    }

                    // $("#evaluation-table tbody").append(`<tr></tr>`)
                    $("#evaluation-table tbody").append(
                        `<tr><td class="text-center">` + (index + 1) + `</td>` +
                        `<td class="text-center">` + item.team.name + `</td>` +
                        `<td class="text-center">` + item.year + `</td>` +
                        `<td class="text-center">` + item.month.name + `</td>` +
                        `<td class="text-center">` + suboutput_name + `</td>` +
                        status +
                        `<td class="project-actions text-center">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            Aksi
                        </button>
                        <div class="dropdown-menu">` + action + `</div></td>` +
                        `</tr>`
                    );
                })

                $.each(result.messages, function (index, message) {
                    window.showToastr(message['type'], message['text'])
                })

                $('.loader').addClass('d-none')
            },
        });
    }

    function createNull() {
        $('.loader').removeClass('d-none');
        $.ajax({
            type: 'POST',
            url: url_post_null.href,
            data: {
                filter: sessionStorage.getItem("filterData"),
                _token: tokens,
            },

            success: function (result) {

                console.log(result)

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
            fetchData()
        } else {
            window.showToastr('warning', 'Isian filter tidak boleh kosong')
        }
    })
    
    $('#create-none-button').click(function () {
        if (validateFilter()) {
            sessionStorage.setItem("filterData", JSON.stringify(filterData()))
            createNull()
            fetchData()
        } else {
            window.showToastr('warning', 'Isian filter tidak boleh kosong')
        }
    })

    function submitButton (id) {
        return `<a class="dropdown-item" href="/evaluation/submit/`+ id +`">
                    <i class="fas fa-check"></i>
                    Submit
                </a>`
    }
    
    function showButton (id) {
        return `<a class="dropdown-item" href="/evaluation/`+ id +`">
                    <i class="fas fa-eye"></i>
                    Show
                </a>`
    }
    
    function editButton (id) {
        return `<a class="dropdown-item" href="/evaluation/`+ id +`/edit">
                    <i class="fas fa-pencil-alt"></i>
                    Edit
                </a>`
    }
  
    function deleteButton (id) {
        return `<a onclick="deleteConfirm('/evaluation/`+ id +`')" class="dropdown-item" href="#">
                    <i class="fas fa-trash"></i>
                    Delete
                </a>`
    }

});