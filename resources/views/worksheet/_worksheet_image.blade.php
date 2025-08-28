<div class="dz-preview dz-file-preview">
    <div class="dz-details">
        <input type="hidden" name="WorksheetImage[current][{{$item->id}}][id]" value="{{$item->id}}">
        <div class="dz-image"><img data-dz-thumbnail src="{{$item->image}}" /></div>
        <textarea class="form-control" name="WorksheetImage[current][{{$item->id}}][note]" placeholder="Megjegyzés">{{$item->note}}</textarea>
    </div>
    <input type="hidden" name="WorksheetImage[current][{{$item->id}}][image]" class="imagename-input" value="{{$item->image}}"><hr />
    </div>