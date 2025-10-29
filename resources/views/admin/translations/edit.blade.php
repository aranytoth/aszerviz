@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row align-items-center mb-3">
            <div class="col-md-6">
                <h4 class="mb-0">Szerkesztés</h4>
            </div>
        </div>
    {{-- Group váltó --}}
        <form method="POST" action="{{ route('translations.update', ['translation' => $translation->id]) }}">
            @csrf
            @method('PUT')
        <div class="mb-4">
            <label>Csoport:</label>
            <input type="hidden" name="Translation[id]" value="{{$translation->id}}" >
            <select name="Translation[group]" class="form-select">
                @foreach($groups as $g)
                    <option value="{{ $g }}" 
                        {{ $g === $translation->group ? 'selected' : '' }}>
                        {{ $g }}
                    </option>
                @endforeach
            </select>
            <div class="mb-4">
                <label>Név:</label>
                <input type="text" name="Translation[key]" class="form-control" value="{{$translation->key}}">
            </div>
        </div>

        <div class="row">
                    <div class="col-md-10">
                        @foreach ($locales as $locale)
                            <label>{{$locale}}</label>
                            <input name="TranslationValues[{{$locale}}]" class="form-control" value="{{$translation->getValueForLocale($locale)}}">
                        @endforeach
                    </div>
                    
                </div>
        
            
            <button type="submit" class="btn btn-primary">Mentés</button>
        </form>
    </div>
</div>
@endsection