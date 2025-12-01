<div class="row">
    <div class="col-md-4">
        <label class="form-label">Blokk stílusa</label>
        <select class="form-select" wire:model.change="layout">
            <option value="blank" {{$selected == 'blank' ? 'selected' : ''}}>Blank</option>
            <option value="hero" {{$selected == 'hero' ? 'selected' : ''}}>Hero</option>
        </select>
    </div>
</div>