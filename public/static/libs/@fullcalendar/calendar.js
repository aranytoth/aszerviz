$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

document.addEventListener('DOMContentLoaded', function() {

    var addEvent=$("#event-modal");
    var modalTitle = $("#modal-title");
    var formEvent = $("#form-event");
    var selectedEvent = null;
    var newEventData = null;
    var calendarEl = document.getElementById('calendar');
    var externalEventContainerEl = document.getElementById('external-events');

    new FullCalendar.Draggable(externalEventContainerEl, {
      itemSelector: '.external-event',
      eventData: function (eventEl) {
        const data = {
            title: eventEl.innerText,
            userId: eventEl.dataset.id,
            className: $(eventEl).data('class')
        };
        return data;
    }
    });

    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'hu',
        headerToolbar: {
            left: 'prevYear,prev,next,nextYear today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
      
        navLinks: true, // can click day/week names to navigate views
        editable: true,
        selectable: true,
        droppable: true,
        themeSystem: 'bootstrap',
        initialView: 'timeGridWeek',
        dayMaxEvents: true, // allow "more" link when too many events
        eventReceive: function(info){
            console.log(info);
            var start = moment(info.event.startStr);
            var newEvent = {
                title: info.event.title,
                start: start.format('YYYY-MM-DDTHH:mm:ss'),
                end: start.add(1, 'hour').format('YYYY-MM-DDTHH:mm:ss'),
                userId: info.event.extendedProps.userId,
                note: ''
            }
            $.post(createEvent, newEvent, function(data, status){
                info.event.remove();
                calendar.refetchEvents();
            });
        },
        eventChange: function(info){
            var start = moment(info.event.startStr).format('YYYY-MM-DDTHH:mm:ss');
            var end = moment(info.event.endStr).format('YYYY-MM-DDTHH:mm:ss');
            modifiedEvent = {
                id: info.event.id,
                start: start,
                end: end
            }
            $.ajax({
                url: updateEvent,
                data: modifiedEvent,
                method: 'PUT',
                dataType: 'json',
                success: function(){
                    calendar.refetchEvents();
                }
            })
        },
        events: {
            url: eventsUrl,
            method: 'POST',
            extraParams: {
                '_token': $('meta[name="csrf-token"]').attr('content')
            }
        },
        eventClick: function(info){
            console.log(info.event.extendedProps);
            selectedEvent = info.event;
            addEvent.modal('show');
            $("#event-title").val(info.event.title);
            $('#form-event select').val(info.event.extendedProps.user_id);
            $('#form-event textarea').val(info.event.extendedProps.note);
        },
        dateClick: function(info) {
            addEvent.modal('show');
            formEvent[0].reset();
            selectedEvent = info.event;
            newEventData = info;
            console.log('clicked ' + info.dateStr);
        },
    });

    calendar.render();

    $(formEvent).on('submit', function(ev) {
        ev.preventDefault();
        var updatedTitle = $("#event-title").val();
        var userId = $('#form-event select').val();
        var note = $('#form-event textarea').val();
            
        if(selectedEvent){
            
            var event = {
                id: selectedEvent.id,
                title: updatedTitle,
                userId: userId,
                note: note
            }
            $.ajax({
                url: updateEvent,
                data: event,
                method: 'PUT',
                dataType: 'json',
                success: function(){
                    calendar.refetchEvents();
                }
            })
        } else {
            var newDate = moment(newEventData.dateStr);
            var newEvent = {
                title: updatedTitle,
                start: newDate.format('YYYY-MM-DDTHH:mm:ss'),
                end: newDate.add(1, 'hour').format('YYYY-MM-DDTHH:mm:ss'),
                userId: userId,
                note: note
            }
            $.post(createEvent, newEvent, function(data, status){
                calendar.refetchEvents();
            });
            
            
        }
        addEvent.modal('hide');
            
    });
});