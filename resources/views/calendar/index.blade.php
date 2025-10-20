@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-xl-3">

                    <div id="external-events">
                        <br>
                        <p class="text-muted">Drag and drop your event or click in the calendar</p>
                        @foreach ($users as $user)
                        <div class="external-event fc-event bg-success" data-id="{{$user->id}}" data-class="bg-success">
                            {{$user->name}}
                        </div>
                        @endforeach
                    </div>
                </div> <!-- end col-->
                <div class="col-xl-9">
                    <div class="card mb-0">
                        <div id="calendar"></div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row-->
            <div style='clear:both'></div>

            <!-- Add New Event MODAL -->
            <div class="modal fade" id="event-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header py-3 px-4">
                            <h5 class="modal-title" id="modal-title">Event</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body p-4">
                            <form class="needs-validation" name="event-form" id="form-event" novalidate>
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Feladat</label>
                                        <input class="form-control" placeholder="Feladat elnevezése" type="text"
                                            name="title" id="event-title" required value="">
                                        <div class="invalid-feedback">Please provide a valid event name</div>                       
                                    </div> <!-- end col-->
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Szerelő</label>
                                        <select class="form-select mt-2">
                                            <option value="">-- nem szerelőhöz kötött --</option>
                                            @foreach ($users as $user)
                                            <option value="{{$user->id}}">
                                                {{$user->name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Jegyzet</label>
                                        <textarea class="form-control"></textarea>
                                    </div>
                                   
                                </div> <!-- end row-->
                                <div class="row mt-2">
                                    <div class="col-6">
                                        <button type="button" class="btn btn-danger"
                                            id="btn-delete-event">Delete</button>
                                    </div> <!-- end col-->
                                    <div class="col-6 text-end">
                                        <button type="button" class="btn btn-light me-1"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success" id="btn-save-event">Save</button>
                                    </div> <!-- end col-->
                                </div> <!-- end row-->
                            </form>
                        </div>
                    </div>
                    <!-- end modal-content-->
                </div>
                <!-- end modal dialog-->
            </div>
            <!-- end modal-->
        </div>

    </div>
</div>
@endsection

@section('css')
<link rel="stylesheet" href="/static/libs/@fullcalendar/core/main.min.css" type="text/css">
<link rel="stylesheet" href="/static/libs/@fullcalendar/daygrid/main.min.css" type="text/css">

<link rel="stylesheet" href="/static/libs/@fullcalendar/timegrid/main.min.css" type="text/css">
@endsection


@section('js')
<script>
const eventsUrl = "{{route('calendar.events')}}";
const createEvent = "{{route('calendar.create')}}";
const updateEvent = "{{route('calendar.update')}}";
const deleteEvent = "{{route('calendar.delete')}}";

</script>
<script src="/static/libs/moment/min/moment.min.js"></script>
<script src="/static/libs/jquery-ui-dist/jquery-ui.min.js"></script>
<script src="/static/libs/@fullcalendar/core/index.global.min.js"></script>
<script src="/static/libs/@fullcalendar/core/locales/hu.global.js"></script>

<script src="/static/libs/@fullcalendar/calendar.js"></script>


@endsection