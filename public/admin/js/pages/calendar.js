document.addEventListener('DOMContentLoaded', () => {
    var calendarEl = document.getElementById('calendar-holder');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        defaultView: 'dayGridMonth',
        editable: true,
        eventSources: [
            {
                url: "/fc-load-events",
                method: "POST",
                extraParams: {
                    filters: JSON.stringify({})
                },
                failure: () => { // alert("There was an error while fetching FullCalendar!");
                }
            },
        ],
        eventDrop: function (info) {
            console.log(info.event);
            console.log(info.oldEvent); // data before the drop
            console.log(info.delta); // how far it was moved
            console.log(info.jsEvent);
            console.log(info.newResource); // if using a resource view
            console.log(info.oldResource); // if using a resource view

            if (confirm('revert change?')) {
                info.revert();
            }
        },
        dateClick: function(info){
            $('#modalAppointment').modal('show');

            $('#appointment_beginAt_date').val(info.dateStr);
            $('#appointment_endAt_date').val(info.dateStr);
        },
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        plugins: [
            'interaction', 'dayGrid', 'timeGrid'
        ], // https://fullcalendar.io/docs/plugin-index
        timeZone: 'UTC'
    });
    calendar.render();
});