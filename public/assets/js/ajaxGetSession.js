$(document).ready(function () {
        $.ajax({
            url: '/api/session',
            dataType: 'json',
            method: 'GET',
            success: function (data) {
                $("#labelPeriod").append(data.currentSession);
                for (let i = 0; i < data.periods.length; i++) {
                    $("#sessions").append(
                        '<a class="dropdown-item" onclick="getSession('+data.periods[i].period.id+')">' +
                        '<i>' +data.periods[i].period.session + '</i></a>'
                    );
                }

            }
        });
});