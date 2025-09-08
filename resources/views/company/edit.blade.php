@extends('layouts.admin')

@section('content')

<link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css" />
<div class="card">
    <div class="card-body">
        <form action="{{route('company.update', ['company' => $company->id])}}" id="company-update" method="POST">
            @csrf
            @method('PUT')
            <div class="row align-items-center mb-3">
                <div class="col-md-6">
                    <h4 class="mb-4">Cég szerkesztése</h4>
                </div>
                <div class="col-md-6">
                    @if ($company->status == App\Models\Company::STATUS_LIVE)
                        <button class="btn btn-danger float-end" type="submit" name="status" onclick="suspendConfirm()" value="{{App\Models\Company::STATUS_SUSPENDED}}">Felfüggesztés</button>
                    @else
                        <button class="btn btn-success float-end" type="submit" name="status" value="{{App\Models\Company::STATUS_LIVE}}">Élesítés</button>
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label class="form-label">Név</label>
                                            <input class="form-control" type="text" placeholder="Cég neve" name="company_name" value="{{old('company_name') ?? $company->company_name}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label class="form-label">Email cím</label>
                                            <input class="form-control" type="text" placeholder="Cég email címe" name="company_email" value="{{old('company_email') ?? $company->company_email}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label class="form-label">Irányítószám</label>
                                            <input class="form-control" type="text" placeholder="Irányítószám" name="company_zip" value="{{old('company_zip') ?? $company->company_zip}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label class="form-label">Település</label>
                                            <input class="form-control" type="text" placeholder="Település" name="company_city" value="{{old('company_city') ?? $company->company_city}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label class="form-label">Cím</label>
                                            <input class="form-control" type="text" placeholder="Cím" name="company_address" value="{{old('company_address') ?? $company->company_address}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label class="form-label">Házszám</label>
                                            <input class="form-control" type="text" placeholder="Házszám" name="company_house_num" value="{{old('company_house_num') ?? $company->company_house_num}}">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label class="form-label">Adószám</label>
                                            <input class="form-control" type="text" placeholder="Adószám" name="company_tax_number" value="{{old('company_tax_number') ?? $company->company_tax_number}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label class="form-label">Számlázz.hu API kulcs</label>
                                            <input class="form-control" type="text" placeholder="Számlázz.hu API kulcs" name="szamlazz_api_key" value="{{old('szamlazz_api_key') ?? $company->szamlazz_api_key}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Hozzárendelt felhasználó</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" disabled value="{{$company->user->name}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Cég logo</label>
                        <div id="company_logo">
                            <div class="image-preview">
                            @if (!empty($company->company_logo))
                           
                                <div class="image-click"></div>
                                <div class="dz-preview">
                                    <div class="dz-details">
                                        <div class="dz-image"><img src="{{$company->company_logo}}" /></div>
                                    </div>
                                </div>
                            @else
                            </div>
                            <div class="image-click"></div>
                            @endif
                        </div>
                    </div>
                </div>
                <div>
                    <button class="btn btn-primary" type="submit">Mentés</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>
<script>
    $(function(){
        
        $("div#company_logo").dropzone({
             url: "{{route('image.upload')}}",
             paramName: "image",
             clickable: '.image-click',
             previewsContainer: ".image-preview",
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
             success: function(file, response) {
                prevFile = file;
                $(file.previewElement).find('img').attr('src', response.path)
                $(file.previewElement).find('input').val(response.filename)
             },
             
             sending: function(){
                if(this.element.querySelector('.dz-preview')){
                   // this.element.querySelector('.dz-preview').remove();
                }
             },
             previewTemplate: `<div class="dz-preview dz-file-preview">
                <div class="dz-details">
                    <div class="dz-image"><img data-dz-thumbnail /></div>
                </div>
                <input type="hidden" name="company_logo" value="">
             </div>`
        });
    })
function suspendConfirm() {
    if(confirm("Biztosan fel akarod függeszteni a fiókot?")) {
        document.getElementById('company-update').submit();
    }
}
</script>

<style>
    #company_logo {
        min-height: 150px;
        padding: 10px;
        text-align: center;
        width: 100%;
        min-height: 100px; 
        border: 1px solid #ddd; 
        cursor:pointer;
        position: relative;
    }

    #company_logo .image-click {
        position: absolute;
        width: 100%;
        height: 100%;
        cursor: pointer;
        top: 0;
        left: 0;
    }

    #company_logo img {
        max-height: 200px;
        width: auto;
    }
</style>

@endsection