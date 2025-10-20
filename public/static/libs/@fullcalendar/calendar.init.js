!function($) {
    "use strict";

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

    var CalendarPage = function() {};

    CalendarPage.prototype.init = function() {

            var addEvent=$("#event-modal");
            var modalTitle = $("#modal-title");
            var formEvent = $("#form-event");
            var selectedEvent = null;
            var newEventData = null;
            var forms = document.getElementsByClassName('needs-validation');
            var selectedEvent = null;
            var eventObject = null;
            /* initialize the calendar */

            
            var Draggable = FullCalendarInteraction.Draggable;
            var externalEventContainerEl = document.getElementById('external-events');
            // init dragable
            new Draggable(externalEventContainerEl, {
                itemSelector: '.external-event',
                eventData: function (eventEl) {
                    const data = {
                        id: 64334554645,
                        title: eventEl.innerText,
                        className: $(eventEl).data('class')
                    };
                    return data;
                }
                
            });

            var draggableEl = document.getElementById('external-events');
            var calendarEl = document.getElementById('calendar');

            function addNewEvent(info) {
                addEvent.modal('show');
                formEvent.removeClass("was-validated");
                formEvent[0].reset();

                $("#event-title").val();
                $('#event-category').val();
                modalTitle.text('Új feladat');
                newEventData = info;
            }
            
            var calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'hu',
                plugins: ['interaction', 'dayGrid', 'timeGrid'],
                editable: true,
                droppable: true,
                selectable: true,
                defaultView: 'timeGridWeek',
                themeSystem: 'bootstrap',
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                },
                eventChange: function(info){
                    console.log('eventchange', info);
                },
                /*eventReceive: function(info){
                    var momentStart = window.moment(info.event.start);
                    var momentEnd = window.moment(info.event.end);
        
                },*/
                eventClick: function(info) {
                    addEvent.modal('show');
                    formEvent[0].reset();
                    selectedEvent = info.event;
                    console.log(selectedEvent.id);
                    $("#event-title").val(selectedEvent.title);
                    $('#event-category').val(selectedEvent.classNames[0]);
                    newEventData = null;
                    modalTitle.text('Feladat szerkesztése');
                    newEventData = null;
                },
                /*eventResizeStop: function(info){
                    console.log(info.el.fcSeg.start, info.el.fcSeg.end);
                },  
                dateClick: function(info) {
                    addNewEvent(info);
                },
                drop: function(props){
                    console.log(props);
                },*/
                
                /*eventDragStop: function(props){
                    console.log(props.event);
                    var event = {
                        type: 'move',
                        id: props.event.id,
                        start: moment.parseZone(props.event.start).format()
                    }
                    

                    $.ajax({
                        url: updateEvent,
                        data: event,
                        method: 'PUT',
                        dataType: 'json',
                        success: function(){

                        }
                    })
                },*/
                events: {
                    url: eventsUrl,
                    method: 'POST',
                    extraParams: {
                        '_token': $('meta[name="csrf-token"]').attr('content')
                    }
                }
            });
            calendar.render();
            
             /*Add new event*/
            // Form to add new event

            $(formEvent).on('submit', function(ev) {
                ev.preventDefault();
                var updatedTitle = $("#event-title").val();
                var userId = $('#form-event select').val();
                var note = $('#form-event textarea').val();
                
                // validation
                if (forms[0].checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                        forms[0].classList.add('was-validated');
                } else {
                    if(selectedEvent){
                        selectedEvent.setProp("title", updatedTitle);
                    } else {
                        
                        var newDate = moment(newEventData.date);
                        var newEvent = {
                            title: updatedTitle,
                            start: newDate.format(),
                            end: newDate.add(1, 'hour').format(),
                            userId: userId,
                            note: note
                        }
                        $.post(createEvent, newEvent, function(data, status){
                           
                        });
                        newEvent.id = 12332123;
                        calendar.addEvent(newEvent);

                        calendar.refetchEvents();
                    }
                    addEvent.modal('hide');
                }
            });

            $("#btn-delete-event").on('click', function(e) {
                if (selectedEvent) {
                    selectedEvent.remove();
                    selectedEvent = null;
                    addEvent.modal('hide');
                }
            });

            $("#btn-new-event").on('click', function(e) {
                addNewEvent({date: new Date(), allDay: true});
            });

    },
    //init
    $.CalendarPage = new CalendarPage, $.CalendarPage.Constructor = CalendarPage
}(window.jQuery),

//initializing 
function($) {
    "use strict";
    $.CalendarPage.init()
}(window.jQuery);