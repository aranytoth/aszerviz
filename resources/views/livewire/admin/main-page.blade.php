<div style="padding-bottom: 50px;">
    <div>
        <button class="btn btn-primary" wire:click="addBlock">Új blokk +</button>
    </div>
    <hr />
    @foreach ($content as $key => $block)
        @livewire('admin.mainpage.components.'.$block['layout'], ['key' => $key,'data' => $block], key(Str::random(6)))
    @endforeach
    <div id="operations" style="position: fixed; bottom: 0; background-color: #ddd; width: 100%; left: 0; padding: 10px;">
        <div class="row ">
            <div class="col-md-12 justify-content-end d-flex">
                <button class="btn btn-primary" wire:click="save">{{$page->exists ? 'Mentés' : 'Létrehozás'}}</button>
            </div>
        </div>
        
    </div>
</div>
