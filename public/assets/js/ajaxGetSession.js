$(document).ready(function () {
        $.ajax({
            url: '/api/session',
            method: 'GET',
            success: function (data) {
                for (let i = 0; i < data.length; i++) {
                    $("#sessions").append(
                        '<a class="dropdown-item" href="/lesson/"'+data[i].period.id+'>' +
                        '<i>' +data[i].period.session + '</i></a>'
                    );
                }

            }
        });
});