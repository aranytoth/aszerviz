@extends('layouts.admin')

@section('content')
<link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css" />
<link href="{{asset('static/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <form action="{{route('worksheet.update', ['worksheet' => $worksheet->id])}}" method="POST" id="worksheet-form" style="margin-bottom: 90px">
        @csrf
        @method('PUT')
        <div class="row" >
            <div class="col-md-12 ">
                <div class="card flex-grow-1">
                    <div class="card-body">
                        <div class="row align-items-center mb-1">
                            <div class="col-md-6">
                                <h4 class="mb-4">{{$worksheet->name}} - {{$worksheet->vehicle->license_plate}}</h4>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-12">
                                <div class="mb-1">
                                    <label class="form-label">Megnevezés</label>
                                    <input type="text" class="form-control" name="WorkSheet[name]"  placeholder="Munkalap neve" value="{{old('name') ?? $worksheet->name}}">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-12">
                                <div class="mb-1">
                                    <label class="form-label">Hiba leírása</label>
                                    <textarea type="text" class="form-control" rows="4" name="WorkSheet[note]"  placeholder="Hiba leírása">{{old('note') ?? $worksheet->note}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-4">
                                <div class="mb-1">
                                    <label class="form-label">Tervezett szerelő</label>
                                    <select name="WorkSheet[mechanic_user_id]" class="form-control">
                                        @foreach ($mechanics as $mechanic)
                                            <option value="{{$mechanic->id}}" {{$mechanic->id == $worksheet->mechanic_user_id ? 'selected' : ''}}>{{$mechanic->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6 align-items-stretch">
                <div class="card flex-grow-1 h-100">
                    <div class="card-header">
                            <h5 class="mb-0">Gépjármű adatai</h5>
                    </div>
                    <div class="card-body">
                        @if (isset($vehicle->id))
                            <input type="hidden" name="Vehicle[id]" value="{{$vehicle->id}}">
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-1">
                                        <label class="form-label">Rendszám</label>
                                        <input type="text" class="form-control" name="Vehicle[license_plate]" placeholder="Rendszám" value="{{old('license_plate') ?? $vehicle->license_plate}}">
                                    </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-1">
                                        <label class="form-label">Márka, típus</label>
                                        <input type="text" class="form-control" name="Vehicle[brand]" placeholder="Márka, típus" value="{{old('brand') ?? $vehicle->brand}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-1">
                                        <label class="form-label">Műszaki érvényesség</label>
                                        <input type="date" class="form-control" name="Vehicle[alidity_date]" placeholder="Műszaki érvényesség" value="{{old('validity_date') ?? $vehicle->validity_date}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-1">
                                        <label class="form-label">Alvázszám</label>
                                        <input type="text" class="form-control" name="Vehicle[chasis_num]" placeholder="Alvázszám" value="{{old('chasis_num') ?? $vehicle->chasis_num}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-1">
                                        <label class="form-label">Gyártási év</label>
                                        <input type="text" class="form-control" name="Vehicle[man_year]" placeholder="Gyártási év" value="{{old('man_year') ?? $vehicle->man_year}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label">Kilóméteróra állása</label>
                                    <input type="text" class="form-control" name="Vehicle[speedometer]" placeholder="Kilóméteróra állása" value="{{old('speedometer') ?? $vehicle->speedometer}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label">Motorkód</label>
                                    <input type="text" class="form-control" name="Vehicle[engine_code]" placeholder="Motorkód" value="{{old('engine_code') ?? $vehicle->engine_code}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label">Kilowatt</label>
                                    <input type="text" class="form-control" name="Vehicle[kilowatt]" placeholder="Motorkód" value="{{old('kilowatt') ?? $vehicle->kilowatt}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb1">
                                    <label class="form-label">Gépjármű típusa</label>
                                    <div class="btn-group w-100" role="group" aria-label="Basic radio toggle button group">
                                        <input type="radio" class="btn-check" name="Vehicle[type]" value="1" id="typeoption1" autocomplete="off" {{$vehicle->type == 1 ? 'checked' : ''}}>
                                        <label class="btn btn-primary" for="typeoption1"><i class="mdi mdi-car me-1"></i> SZGK</label>
                                        
                                        <input type="radio" class="btn-check" name="Vehicle[type]" value="2" id="typeoption2" autocomplete="off" {{$vehicle->type == 2 ? 'checked' : ''}}>
                                        <label class="btn btn-primary" for="typeoption2"><i class="mdi mdi-truck me-1"></i> TGK</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb1">
                                    <label class="form-label">Üzemanyag típusa</label>
                                    <div class="btn-group w-100" role="group" aria-label="Basic radio toggle button group">
                                        <input type="radio" class="btn-check" name="Vehicle[fuel_type]" value="1" id="fuel_typeoption1" autocomplete="off" {{$vehicle->fuel_type == 1 ? 'checked' : ''}}>
                                        <label class="btn btn-info" for="fuel_typeoption1">Benzin</label>
                                        
                                        <input type="radio" class="btn-check" name="Vehicle[fuel_type]" value="2" id="fuel_typeoption2" autocomplete="off" {{$vehicle->fuel_type == 2 ? 'checked' : ''}}>
                                        <label class="btn btn-info" for="fuel_typeoption2">Dízel</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-6 align-items-stretch">
                <div class="card flex-grow-1 h-100">
                    <div class="card-header">
                            <h5 class="mb-0">Ügyfél adatai</h5>
                    </div>
                    <div class="card-body">
                        @if (isset($client->id))
                            <input type="hidden" name="Client[id]" value="{{$client->id}}">
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label">Ügyfél neve</label>
                                    <input type="text" class="form-control" name="Client[name]" placeholder="Ügyfél neve" value="{{old('name') ?? $client->name}}">
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label">Ügyfél email címe</label>
                                    <input type="text" class="form-control" name="Client[email]" placeholder="Ügyfél email címe" value="{{old('email') ?? $client->email}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label">Ügyfél telefonszám</label>
                                    <input type="text" class="form-control" name="Client[phone]" placeholder="Ügyfél neve" value="{{old('phone') ?? $client->phone}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label">Cég neve (cég esetén)</label>
                                    <input type="text" class="form-control" name="Client[company_name]" placeholder="Ügyfél email címe" value="{{old('company_name') ?? $client->company_name}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label">Cég adószáma</label>
                                    <input type="text" class="form-control" name="Client[company_vat]" placeholder="Ügyfél email címe" value="{{old('company_vat') ?? $client->company_vat}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label">Irányítószám</label>
                                    <input type="text" class="form-control" name="Client[zip]" placeholder="Irányítószám" value="{{old('zip') ?? $client->zip}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label">Település</label>
                                    <input type="text" class="form-control" name="Client[city]" placeholder="Település" value="{{old('city') ?? $client->city}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label">Utca</label>
                                    <input type="text" class="form-control" name="Client[street]" placeholder="Utca" value="{{old('street') ?? $client->street}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label">Házszám</label>
                                    <input type="text" class="form-control" name="Client[housenumber]" placeholder="Házszám" value="{{old('housenumber') ?? $client->housenumber}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-label">Megjegyzés</label>
                                <textarea name="Client[note]" class="form-control">{{old('note') ?? $client->note}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="card mb-0">
                    <div class="card-header ">
                        <h5 class="mb-0">Munkalap tételek</h5>
                    </div>
                </div>
                <div id="worksheet-items-container">
                    @foreach ($worksheet->items as $item)
                        @include('worksheet._worksheet_item', ['item' => $item, 'mechanics' => $mechanics])
                    @endforeach
                </div>
            </div>
            <div class="col-md-12">
                <a href="" class="btn btn-info" id="new-worksheet-item">Új tétel hozzáadása</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Rendelkezések</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <label class="col-sm-6 col-form-label">Garanciát vállalunk:</label>
                            <div class="col-md-2">
                                <input type="hidden" name="WorkSheet[warranty]" value="0">
                                <input type="checkbox" name="WorkSheet[warranty]" id="switch1" value="1" switch="none" {{$worksheet->warranty ? 'checked' : ''}} />
                                <label for="switch1" ></label>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-6 col-form-label">Lecserélt alkatrészekrő lemond:</label>
                            <div class="col-md-2">
                                <input type="hidden" name="WorkSheet[old_parts]" value="0">
                                <input type="checkbox" name="WorkSheet[old_parts]" id="switch2" switch="none" value="1" {{$worksheet->old_parts ? 'checked' : ''}} />
                                <label for="switch2" ></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Tételek összesen</h5>
                    </div>
                    <div class="card-body">
                        <div class="row float-end">
                            <div class="col-md-12 text-end mb-1 total-netto-price"><b>Nettó érték:</b> <span>{{number_format($worksheet->totalNetto, 0, ' ', ' ')}}</span> Ft</div>
                            <div class="col-md-12 text-end mb-1 total-vat-price"><b>Áfa:</b> <span>{{number_format($worksheet->totalVat, 0, ' ', ' ')}}</span> Ft</div>
                            <div class="col-md-12 text-end mb-1 total-brutto-price"><b>Bruttó érték:</b> <span>{{number_format(($worksheet->totalNetto + $worksheet->totalVat), 0, ' ', ' ')}}</span> Ft</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Képek</div>
                    <div class="card-body">
                        <span id="images-con">
                            <div class="images-previews"></div>
                            @foreach ($worksheet->images as $item)
                                @include('worksheet._worksheet_image', ['item' => $item])
                            @endforeach
                        </span>
                        <span  class="add-image-btn"><i class="dripicons-camera"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('content-footer')
<div class="footer bg-" style="bottom: 60px; height: 70px; position: fixed;">
    <div class="container-fluid">
        <div class="row justify-content-end">
           
            <div class="col-md-4">
                <input type="submit" class="btn btn-primary float-end" value="Mentés" form="worksheet-form"/>
                <div class="dropdown float-end me-2">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Lehetőségek <i class="mdi mdi-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#mailModal">Munkalap kiküldése emailben</button>
                        @if ($vehicle->type == 1)
                        <a href="{{asset('static/docs/allapot-gepjarmu.pdf')}}" class="dropdown-item" target="_blank">Állapotfelmérő lap (szgk)</a>
                        @else
                        <a href="{{asset('static/docs/allapot-haszon.pdf')}}" class="dropdown-item" target="_blank">Állapotfelmérő lap (tgk)</a>
                        @endif
                        <a class="dropdown-item worksheet-status" data-status="2" href="#">Munkavégzés</a>
                        @if (!$worksheet->is_closed)
                        <a class="dropdown-item worksheet-status" data-status="10" href="#">Lezárás</a>
                        @else
                        <button type="button" class="dropdown-item">Számla kiállítása</button>  
                        @endif
                        
                        <a class="dropdown-item" href="{{route('worksheet.warranty', ['worksheet' => $worksheet])}}" target="_blank">Garanciajegy</a>
                        @role('admin|manager')
                        <a class="dropdown-item worksheet-status" data-status="11" href="#">Törlés</a>
                        @endrole
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('worksheet._modals', ['worksheet' => $worksheet])

<div class="toast-container position-fixed top-0 end-0 p-3">
  <div class="toast align-items-center bg-success text-light" id="liveToast" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="d-flex">
    <div class="toast-body">
      A munkalap státusza megváltozott
    </div>
    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
</div>
</div>

@endsection

@section('js')
<script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>
<script src="{{asset('static/libs/select2/js/select2.full.min.js')}}"></script>

<style>
    
</style>
<script type="module">
    $(function(){
        $.ajaxSetup({
            headers:
            { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });
        var prevFile;
        $("span#images-con").dropzone({
             url: "{{route('image.upload')}}",
             paramName: "image",
             previewsContainer: ".images-previews",
             clickable: '.add-image-btn',
             acceptedFiles: 'image/*,audio/*,video/*',
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
             success: function(file, response) {
                prevFile = file;
                $(file.previewElement).find('img').attr('src', response.path);
                $(file.previewElement).find('.dz-progress').hide();
                $(file.previewElement).find('input.imagename-input').val(response.filename);
                $(file.previewElement).find('input.imagehasvideo-input').val(response.video);

             },
             uploadprogress: function(file, progress, bytesSent){
                console.log(progress);
             },
             sending: function(){
               //this.element.querySelector('.dz-preview').remove();
             },
             previewTemplate: `<div class="dz-preview dz-file-preview">
                <div class="dz-details">
                    <div class="dz-image"><img data-dz-thumbnail /></div>
                    <div class="dz-progress">
                        <div class="spinner-border text-primary m-1" role="status">
                            <span class="sr-only">Loading...</span>
                        </div></div>
                    <textarea class="form-control" name="WorksheetImage[new][note][]" placeholder="Megjegyzés"></textarea>
                </div>
                <input type="hidden" name="WorksheetImage[new][has_video][]" class="imagehasvideo-input" value="">
                <input type="hidden" name="WorksheetImage[new][image][]" class="imagename-input" value=""><hr />
                
             </div>`
        });
    });

function number_format(value){
    return Number(value).toLocaleString('hu-HU', { useGrouping: true });
}

$('body').on({
    'input': function(){
        countPrice();
    }
}, '#worksheet-items-container .counter');

$('body').on({
    'submit': function(e){
        e.preventDefault();
        $('#mailModal').find('.loading-fade').css({'display':'flex'});
        $.post($(this).attr('action'), {email: $(this).find('.modal-body input').val()}, function(response){
            if(response.success){
                var myModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('mailModal'));
                myModal.hide();
            }
            
        });
    }
}, '#mailModal form');

$('body').on({
    'click': function(e){
        e.preventDefault();
        var setStatus = $(this).data('status');
        $.post("{{route('worksheet.status', ['worksheet' => $worksheet])}}", {status: setStatus}, function(response){
            if(response.success) {
                if(setStatus == 11){
                    location.href = "{{route('worksheet.index')}}";
                }
                var myAlert = document.getElementById('liveToast');
                var bsAlert = new bootstrap.Toast(myAlert);
                bsAlert.show();

            }
        });
        
    }
}, '.worksheet-status');

$('body').on({
    'change':function(e){
    if($(this).is(':checked')){
        $(this).parent().parent().find('select').show();
    } else {
        $(this).parent().parent().find('select').hide();
    }
}
}, '.is-work-checkbox');

function countPrice(){
    var totalBruttoPrice = 0;
    var totalNettoPrice = 0;
    $('#worksheet-items-container .card').each(function(){
        if($(this).find('.quantity-price').val() !== undefined && $(this).find('.unit-price').val() !== undefined){
            var nettoPrice = $(this).find('.quantity-price').val() * $(this).find('.unit-price').val();
            var bruttoPrice = Math.round(nettoPrice + (nettoPrice / 100 * $(this).find('.vat-price').val()));
            $(this).find('.item-fullprice span').html(number_format(nettoPrice));
            totalBruttoPrice += bruttoPrice;
            totalNettoPrice += nettoPrice;
            $('.total-netto-price span').html(number_format(totalNettoPrice));
            $('.total-vat-price span').html(number_format(totalBruttoPrice - totalNettoPrice));
            $('.total-brutto-price span').html(number_format(totalBruttoPrice));
        }
    });
    
}
countPrice();
function addWorksheetItem(){
    return `
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-2 col-sm-12">
                <label class="form-label">Cikkszám</label>
                <input type="text" class="form-control" name="WorksheetItem[new][${$('#worksheet-items-container .card').length}][item_num]" placeholder="Cikkszám">
            </div>
            <div class="col-md-2 col-sm-12">
                <input type="hidden" name="WorksheetItem[new][${$('#worksheet-items-container .card').length}][is_work]" value="0">
                <label class="form-label">Megnevezés (Munkaóra <input type="checkbox" class="form-check-input is-work-checkbox" name="WorksheetItem[new][${$('#worksheet-items-container .card').length}][is_work]" value="1">)</label>
                <input type="text" class="form-control" name="WorksheetItem[new][${$('#worksheet-items-container .card').length}][item_name]" placeholder="Megnevezés">
                <select class="form-select worker-selector mt-2" style="display: none" name="WorksheetItem[new][${$('#worksheet-items-container .card').length}][worker_user_id]">
                    @foreach ($mechanics as $mechanic)
                        <option value="{{$mechanic->id}}" >{{$mechanic->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1 col-sm-12">
                <label class="form-label">Mennyiség</label>
                <input type="text" class="form-control counter quantity-price" name="WorksheetItem[new][${$('#worksheet-items-container .card').length}][quantity]" placeholder="Mennyiség">
            </div>
            <div class="col-md-1 col-sm-12">
                <label class="form-label">Egység</label>
                <select class="form-select" name="WorksheetItem[new][${$('#worksheet-items-container .card').length}][unit]">
                    <option value="1" selected>darab</option>
                    <option value="2">óra</option>
                    <option value="3">liter</option>
                    <option value="4">kg</option>
                </select>
            </div>
            <div class="col-md-2 col-sm-12">
                <label class="form-label">Egységár (nettó)</label>
                <input type="text" class="form-control counter unit-price" name="WorksheetItem[new][${$('#worksheet-items-container .card').length}][unit_price]" placeholder="Egységár (nettó)">
            </div>
            <div class="col-md-1 col-sm-12">
                <label class="form-label">ÁFA</label>
                <select class="form-select counter vat-price" name="WorksheetItem[new][${$('#worksheet-items-container .card').length}][vat]">
                    <option value="27" selected>27%</option>
                    <option value="5">5%</option>
                    <option value="18">18%</option>
                    <option value="0">AAM</option>
                </select>
            </div>
            <div class="col-md-2 col-sm-12">
                <label class="form-label">Tétel összesen</label>
                <div class="item-fullprice"><span>0</span> Ft</div>
            </div>
            <div class="col-md-1 col-sm-12">
                <a href="" class="item-to-trash"><i class="dripicons-trash"></i></a>
            </div>
        </div>
    </div>
</div>`;
}


$('body').on({
    click: function(e){
        e.preventDefault();
        $('#worksheet-items-container').append(addWorksheetItem());
    }
}, '#new-worksheet-item');

$('body').on({
    click: function(e){
        e.preventDefault();
        $(this).closest('.card').remove();
    }
}, '.item-to-trash')


</script>
@endsection