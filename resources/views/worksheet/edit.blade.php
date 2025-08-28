@extends('layouts.admin')

@section('content')
<link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css" />
    <form action="{{route('worksheet.update', ['worksheet' => $worksheet->id])}}" method="POST" id="worksheet-form" style="margin-bottom: 90px">
        @csrf
        @method('PUT')
        <div class="row" >
            <div class="col-md-12 ">
                <div class="card flex-grow-1">
                    <div class="card-body">
                        <div class="row align-items-center mb-1">
                            <div class="col-md-6">
                                <h4 class="mb-4">Munkalap szerkesztése</h4>
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
                            <div class="col-md-4">
                                <div class="mb-1">
                                    <div class="mb-1">
                                        <label class="form-label">Becsült javítási költség</label>
                                        <input type="text" class="form-control" id="calc_price" name="WorkSheet[calc_price]" placeholder="Várható költség (bruttó)" value="{{old('calc_price') ?? $worksheet->calc_price}}">
                                    </div>
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
                        @include('worksheet._worksheet_item', ['item' => $item])
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
                            <div class="col-md-12 text-end mb-1 total-netto-price"><b>Nettó érték:</b> <span></span> Ft</div>
                            <div class="col-md-12 text-end mb-1 total-vat-price"><b>Áfa:</b> <span></span> Ft</div>
                            <div class="col-md-12 text-end mb-1 total-brutto-price"><b>Bruttó érték:</b> <span></span> Ft</div>
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
            <div class="col-md-6 ">
                <input type="submit" class="btn btn-primary float-end" value="Mentés" form="worksheet-form"/>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>
<style>
    #images-con img {
        max-width: 200px;
        height: auto;
    }
    #images-con .dz-details {
        display: flex;
        gap: 20px;
    }
    .add-image-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100px;
        height: 100px;
        background-color: #ddd;
        float: right;
        cursor: pointer;
    }
    .add-image-btn i {
        font-size: 30px;
    }
    #images-con .dz-preview {
        margin-bottom: 20px;
    }
</style>
<script type="module">
    $(function(){
        var prevFile;
        $("span#images-con").dropzone({
             url: "{{route('image.upload')}}",
             paramName: "image",
             clickable: '.add-image-btn',
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
             success: function(file, response) {
                prevFile = file;
                $(file.previewElement).find('img').attr('src', response.path)
                $(file.previewElement).find('input.imagename-input').val(response.filename)
             },
             
             sending: function(){
               //this.element.querySelector('.dz-preview').remove();
             },
             previewTemplate: `<div class="dz-preview dz-file-preview">
                <div class="dz-details">
                    <div class="dz-image"><img data-dz-thumbnail /></div>
                    <textarea class="form-control" name="WorksheetImage[new][note][]" placeholder="Megjegyzés"></textarea>
                </div>
                <input type="hidden" name="WorksheetImage[new][image][]" class="imagename-input" value=""><hr />
             </div>`
        });
    });
    document.getElementById('calc_price').addEventListener('input', function(event) {
    let value = this.value.replace(/\D/g, '');
    if (value) {
        this.value = number_format(value);
    } else {
        this.value = '';
    }
});

function number_format(value){
    return Number(value).toLocaleString('hu-HU', { useGrouping: true });
}

$('body').on({
    'input': function(){
        countPrice();
    }
}, '#worksheet-items-container .counter');

function countPrice(){
    var totalBruttoPrice = 0;
    var totalNettoPrice = 0;
    $('#worksheet-items-container .card').each(function(){
        var nettoPrice = $(this).find('.quantity-price').val() * $(this).find('.unit-price').val();
        var bruttoPrice = Math.round(nettoPrice + (nettoPrice / 100 * $(this).find('.vat-price').val()));
        $(this).find('.item-fullprice span').html(number_format(nettoPrice));
        totalBruttoPrice += bruttoPrice;
        totalNettoPrice += nettoPrice;
        $('.total-netto-price span').html(number_format(totalNettoPrice));
        $('.total-vat-price span').html(number_format(totalBruttoPrice - totalNettoPrice));
        $('.total-brutto-price span').html(number_format(totalBruttoPrice));
    });
    
}
countPrice();
function addWorksheetItem(){
    return `
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col">
                <label class="form-label">Cikkszám</label>
                <input type="text" class="form-control" name="WorksheetItem[new][${$('#worksheet-items-container .card').length}][item_num]" placeholder="Cikkszám">
            </div>
            <div class="col">
                <label class="form-label">Megnevezés</label>
                <input type="text" class="form-control" name="WorksheetItem[new][${$('#worksheet-items-container .card').length}][item_name]" placeholder="Megnevezés">
            </div>
            <div class="col">
                <label class="form-label">Mennyiség</label>
                <input type="text" class="form-control" name="WorksheetItem[new][${$('#worksheet-items-container .card').length}][quantity]" placeholder="Mennyiség">
            </div>
            <div class="col">
                <label class="form-label">Mennyiségi egység</label>
                <select class="form-select" name="WorksheetItem[new][${$('#worksheet-items-container .card').length}][unit]">
                    <option value="1" selected>darab</option>
                    <option value="2">óra</option>
                    <option value="3">liter</option>
                    <option value="4">kg</option>
                </select>
            </div>
            <div class="col">
                <label class="form-label">Egységár (nettó)</label>
                <input type="text" class="form-control" name="WorksheetItem[new][${$('#worksheet-items-container .card').length}][unit_price]" placeholder="Egységár (nettó)">
            </div>
            <div class="col">
                <label class="form-label">ÁFA</label>
                <select class="form-select" name="WorksheetItem[new][${$('#worksheet-items-container .card').length}][vat]">
                    <option value="27" selected>27%</option>
                    <option value="5">5%</option>
                    <option value="18">18%</option>
                    <option value="0">AAM</option>
                </select>
            </div>
            <div class="col">
                <label class="form-label">Tétel összesen</label>
                <div class="item-fullprice">0 Ft</div>
            </div>
            <div class="col">
                <a href=""><i class="dripicons-trash"></i></a>
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
}, '#new-worksheet-item')

</script>
@endsection