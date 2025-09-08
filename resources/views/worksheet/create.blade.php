@extends('layouts.admin')

@section('content')
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
                                        <input type="text" class="form-control" name="Vehicle[license_plate]" placeholder="Rendszám" value="{{old('license_plate')}}">
                                    </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-1">
                                        <label class="form-label">Márka, típus</label>
                                        <input type="text" class="form-control" name="Vehicle[brand]" placeholder="Márka, típus" value="{{old('brand')}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-1">
                                        <label class="form-label">Műszaki érvényesség</label>
                                        <input type="date" class="form-control" name="Vehicle[alidity_date]" placeholder="Műszaki érvényesség" value="{{old('validity_date')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-1">
                                        <label class="form-label">Alvázszám</label>
                                        <input type="text" class="form-control" name="Vehicle[chasis_num]" placeholder="Alvázszám" value="{{old('chasis_num')}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-1">
                                        <label class="form-label">Gyártási év</label>
                                        <input type="text" class="form-control" name="Vehicle[man_year]" placeholder="Gyártási év" value="{{old('man_year')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label">Kilóméteróra állása</label>
                                    <input type="text" class="form-control" name="Vehicle[speedometer]" placeholder="Kilóméteróra állása" value="{{old('speedometer')}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label">Motorkód</label>
                                    <input type="text" class="form-control" name="Vehicle[engine_code]" placeholder="Motorkód" value="{{old('engine_code')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label">Kilowatt</label>
                                    <input type="text" class="form-control" name="Vehicle[kilowatt]" placeholder="Motorkód" value="{{old('kilowatt')}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb1">
                                    <label class="form-label">Gépjármű típusa</label>
                                    <div class="btn-group w-100" role="group" aria-label="Basic radio toggle button group">
                                        <input type="radio" class="btn-check" name="Vehicle[type]" value="1" id="typeoption1" autocomplete="off" checked>
                                        <label class="btn btn-primary" for="typeoption1"><i class="mdi mdi-car me-1"></i> SZGK</label>
                                        
                                        <input type="radio" class="btn-check" name="Vehicle[type]" value="2" id="typeoption2" autocomplete="off" >
                                        <label class="btn btn-primary" for="typeoption2"><i class="mdi mdi-truck me-1"></i> TGK</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb1">
                                    <label class="form-label">Üzemanyag típusa</label>
                                    <div class="btn-group w-100" role="group" aria-label="Basic radio toggle button group">
                                        <input type="radio" class="btn-check" name="Vehicle[fuel_type]" value="1" id="fuel_typeoption1" autocomplete="off" checked>
                                        <label class="btn btn-info" for="fuel_typeoption1">Benzin</label>
                                        
                                        <input type="radio" class="btn-check" name="Vehicle[fuel_type]" value="2" id="fuel_typeoption2" autocomplete="off">
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
                                    <input type="text" class="form-control" name="Client[name]" placeholder="Ügyfél neve" value="{{old('name')}}">
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label">Ügyfél email címe</label>
                                    <input type="text" class="form-control" name="Client[email]" placeholder="Ügyfél email címe" value="{{old('email')}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label">Ügyfél telefonszám</label>
                                    <input type="text" class="form-control" name="Client[phone]" placeholder="Ügyfél telefonszám" value="{{old('phone')}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label">Cég neve (cég esetén)</label>
                                    <input type="text" class="form-control" name="Client[company_name]" placeholder="Cég neve" value="{{old('company_name')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label">Cég adószáma</label>
                                    <input type="text" class="form-control" name="Client[company_vat]" placeholder="Cég adószáma" value="{{old('company_vat')}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label">Irányítószám</label>
                                    <input type="text" class="form-control" name="Client[zip]" placeholder="Irányítószám" value="{{old('zip')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label">Település</label>
                                    <input type="text" class="form-control" name="Client[city]" placeholder="Település" value="{{old('city')}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label">Utca</label>
                                    <input type="text" class="form-control" name="Client[street]" placeholder="Utca" value="{{old('street')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label">Házszám</label>
                                    <input type="text" class="form-control" name="Client[housenumber]" placeholder="Házszám" value="{{old('housenumber')}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-label">Megjegyzés</label>
                                <textarea name="Client[note]" class="form-control"></textarea>
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
<script>
    document.getElementById('calc_price').addEventListener('input', function(event) {
    let value = this.value.replace(/\D/g, ''); // Csak számjegyek maradnak
    if (value) {
        // Szám formázása szóközökkel (pl. 1234567 -> 1 234 567)
        this.value = Number(value).toLocaleString('hu-HU', { useGrouping: true });
    } else {
        this.value = ''; // Üres input esetén töröljük a tartalmat
    }
});
</script>
@endsection