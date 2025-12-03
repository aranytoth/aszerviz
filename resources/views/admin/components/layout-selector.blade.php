<div class="row justify-content-between">
    <div class="col-md-4">
        <label class="form-label">Blokk stílusa</label>
        <select class="form-select" wire:model.change="data.layout">
            <option value="blank" >Blank</option>
            <option value="hero">Hero</option>
            <option value="text-block" >Text Block</option>
        </select>
    </div>
    <div class="col-md-4">
        <div class="arrows float-end">
            <button wire:click="$dispatch('reArrange', { key: {{ $key }}, pos: -1 })" class="d-block btn"><i class="dripicons-arrow-up"></i></button>
            <button wire:click="$dispatch('reArrange', { key: {{ $key }}, pos: 1 })" class="d-block btn"><i class="dripicons-arrow-down"></i></button>
        </div>
    </div>
</div>