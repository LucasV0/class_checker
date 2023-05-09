document.addEventListener('DOMContentLoaded', function()  {
    let calendarEl = document.getElementById('calendar-holder');
    let calendar = new FullCalendar.Calendar(calendarEl, {


        plugins: [ "interaction", "dayGrid","timeGrid", 'bootstrap', 'list'],
        locale: 'fr',
        defaultView: 'dayGridMonth',
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
                url: `/calendar/session/${e.event.id}/edit`,
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
                            '<div class="flash" data-state="success">' +
                            '<strong id="response">La session a bien été mis a jour.</strong>' +
                            '</div>'
                        );
                    flash();
                },
                error: function (response){
                    $("#alert").append(
                        '<div class="flash" data-state="error">' +
                        '<strong id="resp">Il y a eu une erreur</strong>' +
                        '</div>'
                    );
                    flash();
                }
            })
        },

        select: function( e, jsEvent, view ) {

            let start = new Date (e.start)
            let end = new Date (e.end)
            let allDay = e.allDay
            console.log(allDay)
            // set values in inputs
            if (allDay) {
                $('#event-modal2').find('input[name=evtStart]').val(
                    start.toLocaleDateString()
                );
                $('#event-modal2').modal('show');

                $("#button2").on('click',function() {
                    $.ajax({
                        url: '/calendar/session/add',
                        data: $("#addSession2").serialize(),
                        method: 'post',
                        dataType: 'json',
                        success: function(response) {
                            // if saved, close modal
                            $("#event-modal2").modal('hide');
                            $("#alert").append(
                                '<div class="flash" data-state="success">' +
                                '<strong id="response">La session a bien été ajoutée.</strong>' +
                                '</div>'
                            );
                            flash();
                            // refetch event source, so event will be showen in calendar
                            calendar.refetchEvents()
                        },
                        error: function (response) {
                            $("#event-modal2").modal('hide');
                            $("#alert").append(
                                '<div class="flash" data-state="error">' +
                                '<strong id="resp">Il y a eu une erreur</strong>' +
                                '</div>'
                            );
                            flash();
                        }
                    });
                });

            }else{
                $('#event-modal').find('input[name=evtStart]').val(
                    start.toLocaleDateString()+' '+start.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})
                );
                $('#event-modal').find('input[name=evtEnd]').val(
                    end.toLocaleDateString()+' '+end.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})
                );
                $('#event-modal').modal('show');
                $("#button").on('click',function() {
                    $.ajax({
                        url: '/calendar/session/add',
                        data: $("#addSession").serialize(),
                        method: 'post',
                        dataType: 'json',
                        success: function(response) {
                            // if saved, close modal
                            $("#event-modal").modal('hide');
                            $("#alert").append(
                                '<div class="flash" data-state="success">' +
                                '<strong id="response">La session a bien été ajoutée.</strong>' +
                                '</div>'
                            );
                            flash();
                            // refetch event source, so event will be showen in calendar
                            calendar.refetchEvents()
                        },
                        error: function (response) {
                            $("#event-modal").modal('hide');
                            $("#alert").append(
                                '<div class="flash" data-state="error">' +
                                '<strong id="resp">Il y a eu une erreur</strong>' +
                                '</div>'
                            );
                            flash();
                        }
                    });
                });
            }
        },

        eventResize: function (e) {
            let start = new Date(e.event.start);
            let end = new Date(e.event.end);
            $.ajax({
                url: `/calendar/session/${e.event.id}/edit`,
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
                        '<div class="flash" data-state="success">' +
                        '<strong id="response">La session a bien été mis a jour.</strong>' +
                        '</div>'
                    );
                    flash();

                },
                error: function (response){
                    $("#alert").append(
                        '<div class="flash" data-state="error">' +
                        '<strong id="response">Il y a eu une erreur.</strong>' +
                        '</div>'
                    );
                    flash();
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
                        '<div class="flash" data-state="success">' +
                        '<strong id="response">La session a bien été supprimée.</strong>' +
                        '</div>'
                    );
                    flash();
                        calendar.refetchEvents()
                    },
                error: function (error){
                    console.log(error);
                    $("#alert").append(
                        '<div class="flash" data-state="success">' +
                        '<strong id="response">Il y a eu une erreur.</strong>' +
                        '</div>'
                    );
                    flash();

                }
            })
            }
        },

    });
    calendar.render();
});