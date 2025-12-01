<div>
    <div>
        <button class="btn btn-primary" wire:click="addBlock">Új blokk +</button>
    </div>
    <hr />
    @foreach ($content as $key => $block)
        @livewire('admin.mainpage.components.'.$block['layout'], ['key' => $key,'data' => $block], key(Str::random(6)))
    @endforeach
</div>
