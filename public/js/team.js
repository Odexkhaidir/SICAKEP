$(document).ready(function () {
    
    function filterData() {
        let filter = {}

        filter['year'] = $(`#yearSelect`).val()
        filter['satker'] = $(`#satkerSelect`).val()
        return filter
    }

    function validateFilter() {
        if ($(`#yearSelect`).val() == '') {
            return false
        } else if ($(`#satkerSelect`).val() == '') {
            return false
        }

        return true
    }

    function fetchData() {
        $('.loader').removeClass('d-none');
        $("#team-table tbody").empty();
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

                    let action = showButton(item.id) + editButton(item.id) + deleteButton(item.id)
                    
                    // $("#evaluation-table tbody").append(`<tr></tr>`)
                    $("#team-table tbody").append(
                        `<tr><td class="text-center">` + (index + 1) + `</td>` +
                        `<td class="text-center">` + item.name + `</td>` +
                        `<td class="text-center">` + item.leader.name + `</td>` +
                        `<td class="text-center">` + item.year + `</td>` +
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

    $('#filter-button').click(function () {
        if (validateFilter()) {
            sessionStorage.setItem("filterData", JSON.stringify(filterData()))
            fetchData()
        } else {
            window.showToastr('warning', 'Isian filter tidak boleh kosong')
        }
    })
    
    function showButton (id) {
        return `<a class="dropdown-item" href="/team/`+ id +`">
                    <i class="fas fa-eye"></i>
                    Show
                </a>`
    }
    
    function editButton (id) {
        return `<a class="dropdown-item" href="/team/`+ id +`/edit">
                    <i class="fas fa-pencil-alt"></i>
                    Edit
                </a>`
    }
  
    function deleteButton (id) {
        return `<a onclick="deleteConfirm('/team/`+ id +`')" class="dropdown-item" href="#">
                    <i class="fas fa-trash"></i>
                    Delete
                </a>`
    }

});