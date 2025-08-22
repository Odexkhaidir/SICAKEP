$(document).ready(function () {

    function filterData() {
        let filter = {}

        filter['year'] = $(`#year`).val()
        filter['month'] = $(`#month`).val()
        return filter
    }

    $(`#month`).change(function (){     
        $('#approval-card').addClass('d-none');
        $('#approveall-button').addClass('d-none')
    })

    $(`#year`).change(function (){     
        $('#approval-card').addClass('d-none');
        $('#approveall-button').addClass('d-none')
    })

    function validateFilter() {
        if ($(`#year`).val() == '') {
            return false
        } else if ($(`#month`).val() == '') {
            return false
        }

        return true
    }

    function approve_all() {
        $('.loader').removeClass('d-none');
        var year = $('#year').val();
        var month = $('#month').val();
        $.ajax({
            type: 'POST',
            url: url_approve_all.href,
            data: {
                year: year,
                month: month,
                _token: tokens,
            },

            success: function (result) {

                console.log(result)

                $.each(result.messages, function (index, message) {
                    window.showToastr(message['type'], message['text'])
                })

                fetchData()

                $('.loader').addClass('d-none')
            },
        });
    }


    $('#approveall-button').click(function () {
        if (validateFilter()) {
            approve_all();
        } else {
            window.showToastr('warning', 'Isian filter tidak boleh kosong')
        }
    })

    $('#filter-button').click(function () {
        if (validateFilter()) {
            fetchData();
            $('#approveall-button').removeClass('d-none')
        } else {
            window.showToastr('warning', 'Isian filter tidak boleh kosong')
        }
    })

    function fetchData() {
        $("#approval-table tbody").empty();
        $('.loader').removeClass('d-none');
        var year = $('#year').val();
        var month = $('#month').val();
        $.ajax({
            type: 'POST',
            url: url_fetch_approval.href,
            data: {
                year: year,
                month: month,
                _token: tokens,
            },

            success: function (result) {

                console.log(result)

                $.each(result.data, function (index, item) {

                    let status = ''
                    let action = ''

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

                    // $("#evaluation-table tbody").append(`<tr></tr>`)
                    $("#approval-table tbody").append(
                        `<tr><td class="text-center">` + (index + 1) + `</td>` +
                        `<td class="text-center">` + item.team.name + `</td>` +
                        `<td class="text-center">` + item.year + `</td>` +
                        `<td class="text-center">` + item.month.name + `</td>` +
                        `<td class="text-center">` + item.suboutput.name + `</td>` +
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