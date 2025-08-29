<div id="mailModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <form action="{{route('worksheet.email', ['worksheet' => $worksheet])}}" method="POST">
                @csrf
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="mailModalLabel">Munkalap kiküldése</h5>
                
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Bezár"></button>
            </div>
            <div class="modal-body">
                <h5 class="font-size-16">Munkalap küldése az adott emailcímre:</h5>
                <input type="text" name="targetEmail" value="{{$worksheet->client->email}}" class="form-control">
                <a class="btn mt-2 btn-info" href="{{route('worksheet.view', ['worksheet' => $worksheet])}}" target="_blank">Előnézet</a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Mégsem</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light">Email küldése 
                    
                </button>
            </div>
            </form>
            <div class="loading-fade">
                <div class="spinner-border text-warning m-1" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</div>
