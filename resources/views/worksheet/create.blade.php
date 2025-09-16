@extends('layouts.admin')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<div class="row" style="margin-bottom: 90px">
    <form action="{{route('worksheet.store')}}" method="POST" id="worksheet-form">
        @csrf
        <div class="col-md-12 ">
            <div class="card flex-grow-1">
                <div class="card-body">
                    <div class="row align-items-center mb-1">
                        <div class="col-md-6">
                            <h4 class="mb-4">Új munkalap</h4>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-12">
                            <div class="mb-1">
                                <label class="form-label">Megnevezés</label>
                                <input type="text" class="form-control" name="WorkSheet[name]"  placeholder="Munkalap neve" value="{{old('name')}}">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-12">
                            <div class="mb-1">
                                <label class="form-label">Hiba leírása</label>
                                <textarea type="text" class="form-control" rows="4" name="WorkSheet[note]"  placeholder="Hiba leírása" value="{{old('note')}}"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-4">
                            <div class="mb-1">
                                <label class="form-label">Tervezett szerelő</label>
                                <select name="WorkSheet[mechanic_user_id]" class="form-select">
                                    @foreach ($mechanics as $mechanic)
                                        <option value="{{$mechanic->id}}">{{$mechanic->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 align-items-stretch">
                <div class="card flex-grow-1 h-100">
                    <div class="card-body">
                        <div class="row align-items-center mb-1">
                            <div class="col-md-6">
                                <h5 class="mb-4">Gépjármű adatai</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-1">
                                        <label class="form-label">Rendszám</label>
                                        <select class="form-select" id="search-vehicle" name="Vehicle[license_plate]" placeholder="Rendszám"></select>
                                    </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-1">
                                        <label class="form-label">Márka, típus</label>
                                        <input type="text" class="form-control" id="vehicle-brand" name="Vehicle[brand]" placeholder="Márka, típus" value="{{old('brand')}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-1">
                                        <label class="form-label">Műszaki érvényesség</label>
                                        <input type="date" class="form-control" id="vehicle-validity_date" name="Vehicle[validity_date]" placeholder="Műszaki érvényesség" value="{{old('validity_date')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-1">
                                        <label class="form-label">Alvázszám</label>
                                        <input type="text" class="form-control" id="vehicle-chasis_num" name="Vehicle[chasis_num]" placeholder="Alvázszám" value="{{old('chasis_num')}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-1">
                                        <label class="form-label">Gyártási év</label>
                                        <input type="text" class="form-control" id="vehicle-man_year" name="Vehicle[man_year]" placeholder="Gyártási év" value="{{old('man_year')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label">Kilóméteróra állása</label>
                                    <input type="text" class="form-control" id="vehicle-speedometer" name="Vehicle[speedometer]" placeholder="Kilóméteróra állása" value="{{old('speedometer')}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label">Motorkód</label>
                                    <input type="text" class="form-control" id="vehicle-engine_code" name="Vehicle[engine_code]" placeholder="Motorkód" value="{{old('engine_code')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label">Kilowatt</label>
                                    <input type="text" class="form-control" id="vehicle-kilowatt" name="Vehicle[kilowatt]" placeholder="Motorkód" value="{{old('kilowatt')}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb1">
                                    <label class="form-label">Gépjármű típusa</label>
                                    <div class="btn-group w-100" role="group" aria-label="Basic radio toggle button group">
                                        <input type="radio" class="btn-check" id="vehicle-type-1" name="Vehicle[type]" value="1"  autocomplete="off" checked>
                                        <label class="btn btn-primary" for="vehicle-type-1"><i class="mdi mdi-car me-1"></i> SZGK</label>
                                        
                                        <input type="radio" class="btn-check" id="vehicle-type-2" name="Vehicle[type]" value="2" autocomplete="off" >
                                        <label class="btn btn-primary" for="vehicle-type-2"><i class="mdi mdi-truck me-1"></i> TGK</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb1">
                                    <label class="form-label">Üzemanyag típusa</label>
                                    <div class="btn-group w-100" role="group" aria-label="Basic radio toggle button group">
                                        <input type="radio" class="btn-check" id="vehicle-fuel_type-1" name="Vehicle[fuel_type]" value="1" autocomplete="off" checked>
                                        <label class="btn btn-info" for="vehicle-fuel_type-1">Benzin</label>
                                        
                                        <input type="radio" class="btn-check" id="vehicle-fuel_type-2" name="Vehicle[fuel_type]" value="2" autocomplete="off">
                                        <label class="btn btn-info" for="vehicle-fuel_type-2">Dízel</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 align-items-stretch">
                <div class="card flex-grow-1 h-100">
                    <div class="card-body">
                        <div class="row align-items-center mb-1">
                            <div class="col-md-6">
                                <h5 class="mb-4">Ügyfél adatai</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label">Ügyfél neve</label>
                                    <select class="form-select" id="search-client" name="Client[name]" placeholder="Ügyfél neve" ></select>
                                    
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label">Ügyfél email címe</label>
                                    <input type="text" class="form-control" id="client-email" name="Client[email]" placeholder="Ügyfél email címe" value="{{old('email')}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label">Ügyfél telefonszám</label>
                                    <input type="text" class="form-control" id="client-phone" name="Client[phone]" placeholder="Ügyfél telefonszám" value="{{old('phone')}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label">Cég neve (cég esetén)</label>
                                    <input type="text" class="form-control" id="client-company_name" name="Client[company_name]" placeholder="Cég neve" value="{{old('company_name')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label">Cég adószáma</label>
                                    <input type="text" class="form-control" id="client-company_vat" name="Client[company_vat]" placeholder="Cég adószáma" value="{{old('company_vat')}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label">Irányítószám</label>
                                    <input type="text" class="form-control" id="client-zip" name="Client[zip]" placeholder="Irányítószám" value="{{old('zip')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label">Település</label>
                                    <input type="text" class="form-control" id="client-city" name="Client[city]" placeholder="Település" value="{{old('city')}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label">Utca</label>
                                    <input type="text" class="form-control" id="client-street" name="Client[street]" placeholder="Utca" value="{{old('street')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label">Házszám</label>
                                    <input type="text" class="form-control" id="client-housenumber" name="Client[housenumber]" placeholder="Házszám" value="{{old('housenumber')}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-label">Megjegyzés</label>
                                <textarea name="Client[note]" class="form-control" id="client-note"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('content-footer')
<div class="footer bg-" style="bottom: 60px; height: 70px; position: fixed;">
    <div class="container-fluid">
        <div class="row justify-content-end">
            <div class="col-md-6 ">
                <input type="submit" class="btn btn-primary float-end" value="Létrehoz" form="worksheet-form"/>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{asset('static/libs/select2/js/select2.full.min.js')}}"></script>
<script>


$('#search-vehicle').select2({
    tags: true,
    minimumInputLength: 2,
    ajax: {
        url: '{{route('api.search.vehicle')}}',
        dataType: 'json'
        // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
    }
});

$('#search-client').select2({
    tags: true,
    minimumInputLength: 2,
    ajax: {
        url: '{{route('api.search.client')}}',
        dataType: 'json'
        // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
    }
});

$('#search-vehicle').on('select2:select', function (e) {
    var data = e.params.data;
    const s = data.id;
    d = /^[0-9A-F]{8}-[0-9A-F]{4}-[0-9A-F]{4}-[0-9A-F]{4}-[0-9A-F]{12}$/i.test(s);
    if(d){
        $('#search-vehicle').after('<input type="hidden" name="Vahicle[id]" value="'+s+'">');
        $('#vehicle-brand').val(data.brand);
        $('#vehicle-validity_date').val(data.validity_date);
        $('#vehicle-chasis_num').val(data.chasis_num);
        $('#vehicle-man_year').val(data.man_year);
        $('#vehicle-engine_code').val(data.engine_code);
        $('#vehicle-speedometer').val(data.speedometer);
        $('#vehicle-kilowatt').val(data.kilowatt);
    }
});

$('#search-client').on('select2:select', function (e) {
    var data = e.params.data;
    const s = data.id;
    d = /^[0-9A-F]{8}-[0-9A-F]{4}-[0-9A-F]{4}-[0-9A-F]{4}-[0-9A-F]{12}$/i.test(s);
    if(d){
        $('#search-client').after('<input type="hidden" name="Client[id]" value="'+s+'">');
        $('#client-email').val(data.email);
        $('#client-phone').val(data.phone);
        $('#client-company_name').val(data.company_name);
        $('#client-company_vat').val(data.company_vat);
        $('#client-zip').val(data.zip);
        $('#client-city').val(data.city);
        $('#client-address').val(data.address);
        $('#client-housenumber').val(data.housenumber);
    }
});


</script>
@endsection