<div class="hero mt-2" style="border: 1px solid #ddd; padding: 10px;">
    <div class="d-flex justify-content-between p-2">
        <button class="btn btn-primary" wire:click="addElement">{{ trans_db('site.new_element') }}</button>
        <button class="btn btn-primary" wire:click="$dispatch('deleteBlock', { key: {{ $key }}})"><i class="dripicons-trash"></i></button>
    </div>
    <div
        style="width: 100%; min-height: 160px; background-color: #ddd; display: flex; gap: 10px; padding: 10px; flex-wrap: wrap;">
        @foreach ($data['data'] as $key2 => $elem)
            <div class="slider-element" style="flex: 1; min-height: 150px; background-color: #fff; position: relative;">
                <button class="btn btn-primary" style="position: absolute; right: 0; top :0;" wire:click="deleteElement({{$key2}})"><i class="dripicons-trash"></i></button>

                @if ($elem['image'])
                    <span
                        onclick="gallery.init( {key: {{$key2}}, elem: null,component: '{{$this->getId()}}'}, {callback: 'insertMedia', type: 'livewire'})">
                        <img src="{{$elem['image']}}" width="400" style="width: 100%;" />
                    </span>
                    <input class="form-control" wire:model.change="data.data.{{$key2}}.title" type="text">
                    <textarea class="form-control" style="height: 200px;" wire:model.change="data.data.{{$key2}}.text"></textarea>
                @else
                    <span style="min-height: 50px; display: flex; align-items: center; justify-content: center;"
                        onclick="gallery.init( {key: {{$key2}}, elem: null,component: '{{$this->getId()}}'}, {callback: 'insertMedia', type: 'livewire'})">
                        <div>Kép kiválasztása</div>

                    </span>
                    <input class="form-control" wire:model.change="data.data.{{$key2}}.title" type="text">
                    <textarea class="form-control" style="height: 200px;" wire:model.change="data.data.{{$key2}}.text"></textarea>
                @endif

            </div>
        @endforeach
    </div>
    @include('admin.components.layout-selector', ['selected' => 'hero'])
</div>