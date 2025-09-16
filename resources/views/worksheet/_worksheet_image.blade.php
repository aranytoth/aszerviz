<div class="dz-preview dz-file-preview">
    <div class="dz-details">
        <input type="hidden" name="WorksheetImage[current][{{$item->id}}][id]" value="{{$item->id}}">
        <div class="dz-image">
            @if ($item->has_video == 'true')
            <video width="200" controls="controls" preload="metadata">
                <source src="{{str_replace('.jpg', '.mp4', $item->image)}}" type="video/mp4">
            </video>
            @else
                <img data-dz-thumbnail src="{{$item->image}}" />
            @endif
            
        </div>
        <textarea class="form-control" name="WorksheetImage[current][{{$item->id}}][note]" placeholder="Megjegyzés">{{$item->note}}</textarea>
    </div>
    <input type="hidden" name="WorksheetImage[current][{{$item->id}}][has_video]" class="imagename-input" value="{{$item->has_video}}">
    <input type="hidden" name="WorksheetImage[current][{{$item->id}}][image]" class="imagename-input" value="{{$item->image}}"><hr />
    </div>