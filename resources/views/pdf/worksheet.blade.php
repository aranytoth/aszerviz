<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
    <title>Worksheet</title><style>
       
        @font-face {
            font-family: 'Arial';
            font-style: normal;
            font-weight: normal;
            src: url('{{ storage_path("fonts/Arial/ARIAL.TTF") }}');
        }
        @font-face {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: normal;
            src: url('{{ storage_path("fonts/Roboto/Roboto_Condensed-Medium.ttf") }}');
        }
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div id="heading">
        <div>
            <img src="{{$worksheet->garage->company->company_logo}}" width="80"/>
            <div id="company-data">
                <span><b>{{$worksheet->garage->company->company_name}}</b></span>
                <span>{{$worksheet->garage->company->company_zip}} {{$worksheet->garage->company->company_city}}, {{$worksheet->garage->company->company_address}} {{$worksheet->garage->company->company_house_num}}.</span>
                <span>{{$worksheet->garage->phone}}</span>
                <span>{{$worksheet->garage->company->company_email}}</span>
            </div>
        </div>
        <div></div>
    </div>
    <div id="title">
        <span>{{$worksheet->worksheet_id}}</span>
        <h1>ÁRAJÁNLAT / MUNKALAP</h1>
    </div>
    <div id="basic-data">
        <div class="data-col-70">
            <span class="data-title">ÜGYFÉL</span>
            <span class="data-name">{{$worksheet->client->name}}</span>
            <span>{{$worksheet->client->phone}}</span>
            <span>{{$worksheet->client->email}}</span>
            <span>{{$worksheet->client->zip}} {{$worksheet->client->city}}, {{$worksheet->client->address}} {{$worksheet->client->housenum}}</span>
        </div>
        <div class="data-col-30">
            <span class="data-title">GÉPJÁRMŰ</span>
            <span class="data-name">{{$worksheet->vehicle->license_plate}} - {{$worksheet->vehicle->brand}}</span>
            <span>Évjárat: {{$worksheet->vehicle->man_year}}</span>
            @if (!empty($worksheet->vehicle->chasis_num))
                <span>Alvázszám: {{$worksheet->vehicle->chasis_num}}</span>
            @endif
            <span>Km óra állása: {{$worksheet->vehicle->speedometer}}</span>
        </div>
    </div>
    <div id="problem-block">
        <span id="problem-title">Hiba leírása</span>
        <div id="problem-desc">{{$worksheet->note}}</div>
        @if (!empty($worksheet->calc_price))
            <div id="calc-price">Várható javítási költség: {{number_format((int) $worksheet->calc_price, 0, ' ', ' ')}} Ft</div>    
        @endif
    </div>
    <table id="data-table" cellpadding="0" cellspacing="0">
        <tr class="table-head">
            <td class="item-id">Azonosító</td>
            <td>Megnevezés</td>
            <td>Menny.</td>
            <td>Egységár (nettó)</td>
            <td>Nettó ár</td>
            <td>ÁFA</td>
            <td class="data-brutto-price">Bruttó ár</td>
        </tr>
        @foreach ($worksheet->items as $key => $item)
            <tr class="{{$key % 2 == 1 ? 'backgrounded' : ''}}">
                <td class="item-id">{{$item->item_num}}</td>
                <td>{{$item->item_name}}</td>
                <td>{{$item->quantity}} {{$item->unitName}}</td>
                <td>{{number_format($item->unit_price, 0, ' ', ' ')}} Ft</td>
                <td>{{number_format($item->unit_price * $item->quantity, 0, ' ', ' ')}} Ft</td>
                <td>{{$item->vat}} %</td>
                <td class="data-brutto-price">{{number_format(($item->unit_price * $item->quantity + ($item->unit_price * $item->quantity / 100 * $item->vat)), 0, ' ', ' ')}} Ft</td>
            </tr>
        @endforeach
    </table>
    
    <div id="items-total">
        <div class="items-unit"><span class="total-name">Nettó számlaérték:</span><span class="total-value">{{number_format($worksheet->totalNetto, 0, ' ', ' ')}} Ft</span></div>
        <div class="items-unit"><span class="total-name">Áfa:</span><span class="total-value">{{number_format($worksheet->totalVat, 0, ' ', ' ')}} Ft</span></div>
        <div class="items-unit"><span class="total-name">Bruttó számlaérték:</span><span class="total-value">{{number_format(($worksheet->totalNetto + $worksheet->totalVat), 0, ' ', ' ')}} Ft</span></div>
    </div>
    <div id="worksheet-other">
        <div>[{{$worksheet->warranty ? 'X' : ' '}}] A szerviz a munkáért garanciát vállal</div>
        <div>[{{$worksheet->old_parts ? 'X' : ' '}}] A lecserélt alkatrészek tulajdonjogáról a szolgáltató részére lemondok</div>
        <div> A szerviz általános szerződési feltételeit és adatkezelési tájékoztatóját megismertem, azokat elfogadom.</div>
        <div>A gépjármű műszaki állapotából adódó károkért felelősséget nem vállalunk</div>
        <div>[ ] Hozzájárulok, hogy a szerviz, mint adatkezelő a személyes adataimat marketing célokra kezelje, részemre akcióiról, szolgáltatásairól, tájékoztatókat és ajánlatokat küldjön.</div>
    </div>
    <div class="worksheet-signals">
        <div>Az ajánlatot elfogadom, a munkát megrendelem</div>
        <div>A megrendelésben szereplő munka elvégzésére a gépjárművet átvettem</div>
    </div>
    <div class="divider"></div>
    <div class="worksheet-signals">
        <div>A javított gépjárművet átvetttem</div>
        <div>Az elvégzett munkáról tájékoztattam az ügyfelet.</div>
    </div>
</body>
</html>



<style>
    body {
        padding: 25px 15px;
    }
    #heading {
       padding-bottom: 10px;
    }
    #heading img {
        float: left;
        width: 80px;
        height: auto;
        margin-right: 20px;
    }
    #heading span {
        display: block;
        font-size: 12px;
        line-height: 14px;
    }
    #title {
        clear: both;
        position: relative;
        padding-bottom: 5px;
        border-bottom: 2px solid #E41F26;
    }
    h1 {
        font-size: 22px;
        line-height: 22px;
        margin-bottom: 0;
    }
    #title span {
       float: right;
       font-size: 14px;
       position: absolute;
       margin-top: 18px;
    }
    .data-col-70 {
        float: left;
        width: 70%;
    }
    .data-col-30 {
        float: left;
        width: 30%;
    }
    #basic-data {
        margin-top: 20px;
        padding-bottom: 50px;
        clear: both;
        height: auto;
    }
    #basic-data span {
        display: block;
        font-size: 12px;
    }
    .data-title {
        font-weight: 400;
        font-size: 12px;
    }
    .data-name {
        font-weight: 700;
    }
    #problem-block {
        clear:both;
        padding-top: 30px;
    }
    #problem-title {
        font-weight: 700;
        display: block;
        margin-bottom: 5px;
    }
    #problem-desc {
        background-color: #f3f3f3;
        padding: 5px;
    }
    #calc-price {
        text-align: right;
        font-weight: 700;
        margin-top: 10px;
    }
    #data-table {
        width: 100%;
        margin-top: 20px;
    }

    #data-table td {
        padding-bottom: 8px;
        padding-top: 8px;
    }

    .table-head td {
        font-weight: 700;
        
        border-bottom: 1px solid #E41F26;
    }
    .item-id {
        padding-left: 5px;
    }
    .data-brutto-price {
        text-align: right;
        padding-right: 5px;
    }

    .backgrounded td {
        background-color: #f3f3f3;
    }
    .items-unit {
        margin-top: 10px;
    }
    #items-total {
        width: 40%;
        float: right;
    }
    .total-value {
        float: right;
        text-align: right;
        font-weight: 700;
    }
    #worksheet-other {
        clear: both;
    }
    .worksheet-signals {
        padding: 10px 0;
        width: 70%;
        margin-left: 10%;
        clear: both;
    }

    .worksheet-signals div {
        border-bottom: 1px solid #000;
        height: 100px;
        float: left;
        width: 50%;
        margin: 10px 20px;
    }
    .divider {
        clear: both;
        width: 100%;
        border-top: 1px dashed #9c9a9a;
    }
</style>