<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 col-md-2">
                <label class="form-label">Cikkszám</label>
                <input type="text" class="form-control" name="WorksheetItem[current][{{$item->id}}][item_num]" value="{{$item->item_num}}" placeholder="Cikkszám">
            </div>
            <div class="col-sm-12  col-md-2">
                <input type="hidden" name="WorksheetItem[current][{{$item->id}}][is_work]" value="0">
                <label class="form-label">Megnevezés (Munkaóra <input type="checkbox" class="form-check-input is-work-checkbox" name="WorksheetItem[current][{{$item->id}}][is_work]" {{$item->is_work ? 'checked' : ''}} value="1">)</label>
                <input type="text" class="form-control" name="WorksheetItem[current][{{$item->id}}][item_name]" value="{{$item->item_name}}" placeholder="Megnevezés">
                <select class="form-select worker-selector mt-2" style="{{$item->is_work ? 'display: inline-block' : 'display: none'}}" name="WorksheetItem[current][{{$item->id}}][worker_user_id]">
                    @foreach ($mechanics as $mechanic)
                        <option value="{{$mechanic->id}}" {{$mechanic->id == $item->worker_user_id ? 'selected' : ''}}>{{$mechanic->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-12  col-md-1">
                <label class="form-label">Mennyiség</label>
                <input type="text" class="form-control counter quantity-price" name="WorksheetItem[current][{{$item->id}}][quantity]" value="{{$item->quantity}}" placeholder="Mennyiség">
            </div>
            <div class="col-sm-12  col-md-1">
                <label class="form-label">Egység</label>
                <select class="form-select" name="WorksheetItem[current][{{$item->id}}][unit]">
                    <option value="1" {{$item->unit == 1 ? 'selected' : ''}}>darab</option>
                    <option value="2" {{$item->unit == 2 ? 'selected' : ''}}>óra</option>
                    <option value="3" {{$item->unit == 3 ? 'selected' : ''}}>liter</option>
                    <option value="4" {{$item->unit == 4 ? 'selected' : ''}}>kg</option>
                </select>
            </div>
            <div class="col-sm-12  col-md-2">
                <label class="form-label">Egységár (nettó)</label>
                <input type="text" class="form-control counter unit-price" name="WorksheetItem[current][{{$item->id}}][unit_price]" value="{{$item->unit_price}}" placeholder="Egységár (nettó)">
            </div>
            <div class="col-sm-12 col-md-1">
                <label class="form-label">ÁFA</label>
                <select class="form-select counter vat-price" name="WorksheetItem[current][{{$item->id}}][vat]">
                    <option value="27" selected>27%</option>
                    <option value="5">5%</option>
                    <option value="18">18%</option>
                    <option value="0">AAM</option>
                </select>
            </div>
            <div class="col-sm-12 col-md-2">
                <label class="form-label">Tétel összesen</label>
                <div class="item-fullprice"><span>{{number_format($item->quantity * $item->unit_price,0," "," ")}}</span> Ft</div>
            </div>
            <div class="col-sm-12 col-md-1 d-flex align-items-center justify-items-center">
                 @role('admin|manager')
                <a href="" class="item-to-trash"><i class="dripicons-trash"></i></a>
                @endrole
            </div>
        </div>
    </div>
</div>