<div class="hero mt-2">
    <button class="btn btn-primary" wire:click="addElement">{{ trans_db('site.new_element') }}</button>
    <div style="width: 100%; min-height: 100px; background-color: #ddd; display: flex; ">
        @foreach ($data['data'] as $key2 => $elem)
            <div class="slider-element" style="width: 20%;">
                <h2>{{$elem['title']}}</h2>
                
                @if ($elem['image'])
                    <span onclick="gallery.init( {key: {{$key2}}, elem: null,component: '{{$this->getId()}}'}, {callback: 'insertMedia', type: 'livewire'})">
                    <img src="{{$elem['image']}}" width="400" style="width: 100%;"/>
                    </span>
                    <input wire:model.change="data.data.{{$key}}.title" type="text">
                @else
                    <span onclick="gallery.init( {key: {{$key2}}, elem: null,component: '{{$this->getId()}}'}, {callback: 'insertMedia', type: 'livewire'})">
                        <div>Kép kiválasztása</div>
                    </span>
                @endif
                
            </div>
        @endforeach
        

    </div>
    {{var_dump($test)}}
        {{var_dump($data)}}
    @include('admin.components.layout-selector', ['selected' => 'hero'])
</div>