document.addEventListener('DOMContentLoaded', function()  {
    let calendarEl = document.getElementById('calendar-holder');
    let calendar = new FullCalendar.Calendar(calendarEl, {


        plugins: [ "interaction", "dayGrid","timeGrid", 'bootstrap', 'list'],
        locale: 'fr',
        defaultView: 'timeGridWeek',
        header: {
            left: 'prev,next today,',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay, listWeek',
        },
        height: 'auto',
        themeSystem: 'bootstrap',
        eventLimit: true,
        allDaySlot: false,
        minTime: "09:00",
        maxTime: "20:00",
        editable: true,
        eventResizableFromStart: true,
        hiddenDays: [0],
        eventSources: [
            {
                url: "/fc-load-events",
                method: "POST",
                extraParams: {

                    filters: JSON.stringify({})
                },
                failure: () => {
                    // alert("There was an error while fetching FullCalendar!");
                },
            },

        ],
        selectable: true,
        timeZone: 'Europe/Paris',
        slotDuration: '00:15:00',
        eventDrop: function (e) {
            let start = new Date(e.event.start);
            let end = new Date(e.event.end);
            $.ajax({
                url: `/calendar/lesson/${e.event.id}/edit`,
                dataType: "json",
                method: "PUT",
                data: {
                    "title": e.event.title,
                    "start": start.toISOString(),
                    "end": end.toISOString(),
                },
                success: function (response){
                    console.log(response)
                        $("#alert").append(
                            '<div class="alert alert-dismissible alert-success" id="succes">' +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                            '<strong id="response">Le cours a bien été mis a jour.</strong>' +
                            '</div>'
                        );
                },
                error: function (response){
                    $("#alert").append(
                        '<div class="alert alert-dismissible alert-danger" id="error">' +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                        '<strong id="resp">Il y a eu une erreur</strong>' +
                        '</div>'
                    );
                }
            })
        },

        select: function( start, end, jsEvent, view ) {
            // set values in inputs
            $('#event-modal').find('input[name=evtStart]').val(
                start.format('YYYY-MM-DD HH:mm:ss')
            );
            $('#event-modal').find('input[name=evtEnd]').val(
                end.format('YYYY-MM-DD HH:mm:ss')
            );

            // show modal dialog
            $('#event-modal').modal('show');

            /*
            bind event submit. Will perform a ajax call in order to save the event to the database.
            When save is successful, close modal dialog and refresh fullcalendar.
            */
            /*
            $("#event-modal").find('form').on('submit', function() {
                $.ajax({
                    url: 'yourFileUrl.php',
                    data: $("#event-modal").serialize(),
                    type: 'post',
                    dataType: 'json',
                    success: function(response) {
                        // if saved, close modal
                        $("#event-modal").modal('hide');

                        // refetch event source, so event will be showen in calendar
                        $("#calendar").fullCalendar( 'refetchEvents' );
                    }
                });
            });*/
        },

        eventResize: function (e) {
            let start = new Date(e.event.start);
            let end = new Date(e.event.end);
            $.ajax({
                url: `/calendar/lesson/${e.event.id}/edit`,
                dataType: "json",
                method: "PUT",
                data: {
                    "title": e.event.title,
                    "start": start.toISOString(),
                    "end": end.toISOString(),
                },
                success: function (response){

                    console.log(response)
                        $("#alert").append(
                            '<div class="alert alert-dismissible alert-success" id="succes">' +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                            '<strong id="response">Le cours a bien été mis a jour.</strong>' +
                            '</div>'
                        );

                },
                error: function (response){
                    $("#alert").append(
                        '<div class="alert alert-dismissible alert-danger" id="error">' +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                        '<strong id="resp">Il y a eu une erreur</strong>' +
                        '</div>'
                    );
                }
            })
        },

        eventClick: function (e) {
            if(confirm('Vous-êtes sur de vouloir supprimer la séance ? ')){
                $.ajax({
                url: `/session/delete/${e.event.id}`,
                dataType: "json",
                method: "DELETE",
                success: function (data){
                        $("#alert").append(
                            '<div class="alert alert-dismissible alert-success" id="succes">' +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                            '<strong id="response">Le cours du '+ data.date +' a bien été supprimé.</strong>' +
                            '</div>'
                        );
                    },
                error: function (error){
                    console.log(error);
                    $("#alert").append(
                        '<div class="alert alert-dismissible alert-danger" id="error">' +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                        '<strong id="resp">Il y a eu une erreur</strong>' +
                        '</div>'
                    );

                }
            })
            }
        },

    });
    calendar.render();
});