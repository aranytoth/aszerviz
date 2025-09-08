<!DOCTYPE html>
<html lang="en">
<head>
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
    <title>Warranty</title><style>
       
        @font-face {
            font-family: 'Arial';
            font-style: normal;
            font-weight: normal;
            src: url('{{ public_path("static/fonts/Arial/ARIAL.TTF") }}');
        }
        @font-face {
            font-family: 'Arial';
            font-style: normal;
            font-weight: bold;
            src: url('{{ public_path("static/fonts/Arial/ARIALBD.TTF") }}');
        }
        @font-face {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: normal;
            src: url('{{ public_path("static/fonts/Roboto/Roboto_Condensed-Medium.ttf") }}');
        }
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
        }
    </style>
</head>
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
        <h1>Jótállási jegy</h1>
    </div>
    <div id="basic-data">
        <div class="data-col-70">
            <span class="data-title">ÜGYFÉL</span>
            <span class="data-name">{{$worksheet->client->name}}</span>
            <span>{{$worksheet->client->phone}}</span>
            <span>{{$worksheet->client->email}}</span>
            @if (!empty($worksheet->client->zip) || !empty($worksheet->client->city) || !empty($worksheet->client->address))
                <span>{{$worksheet->client->zip}} {{$worksheet->client->city}}, {{$worksheet->client->address}} {{$worksheet->client->housenum}}</span>
            @endif
            
        </div>
        <div class="data-col-30">
            <span class="data-title">GÉPJÁRMŰ</span>
            <span class="data-name">{{$worksheet->vehicle->license_plate}} - {{$worksheet->vehicle->brand}}</span>
        </div>
    </div>
    <div id="data-content">
    <p>A számla tételeire az alábbi feltételek szerint vonatkozik jótállás</p>
    <p>249/2004. (VIII. 27.) Korm. rendelet az egyes javító-karbantartó szolgáltatásokra vonatkozó kötelező jótállásról</p>
    <p>Ha a Polgári Törvénykönyv szerinti fogyasztó és vállalkozás közötti szerződés tárgya a fogyasztó által megrendelt, a Mellékletben felsorolt
    javító-karbantartó szolgáltatás (a továbbiakban: szolgáltatás), és a szolgáltatásnak az általános forgalmi adót és az anyagköltséget is magában foglaló díja
    a húszezer forintot meghaladja, a szolgáltatást nyújtó vállalkozást jótállási kötelezettség terheli. A jótállásból eredő jogokat a szolgáltatás tárgyát képező
    dolog (a továbbiakban: dolog) tulajdonosa érvényesítheti, feltéve, hogy fogyasztónak minősül.</p>
    <p>E rendelet hatálya nem terjed ki arra a szolgáltatásra, amelyet a szolgáltatás tárgyát képező dologra vonatkozó szavatossági vagy jótállási igény alapján
    teljesítettek.</p>
    <p>Az e rendeletben előírt jótállás érvényességéhez, valamint a jótállásból eredő jogok érvényesítéséhez a vállalkozás az e rendeletben foglaltakon túl további
    követelményt nem támaszthat a fogyasztóval szemben.</p>
    <p>A fogyasztó és vállalkozás közötti szerződésben semmis az a kikötés, amely e rendelet rendelkezéseitől a fogyasztó hátrányára tér el. Az érvénytelen
    megállapodás helyébe e rendelet rendelkezései lépnek.</p>
    <p>A jótállás időtartama hat hónap. E határidő elmulasztása jogvesztéssel jár.</p>
    <p>A jótállási határidő a szolgáltatás elvégzése után a dolognak a fogyasztó vagy megbízottja részére való átadásával, vagy - ha az üzembe helyezést a
    vállalkozás végzi - az üzembe helyezés napjával kezdődik.</p>
    <p>A vállalkozás a szolgáltatás díjának átvételekor vagy a dolognak a fogyasztó vagy megbízottja részére történő átadásakor jótállási jegyet köteles a
    fogyasztó rendelkezésére bocsátani olyan formában, amely a jótállási határidő végéig biztosítja a jótállási jegy tartalmának jól olvashatóságát.</p>
    <p>A jótállási jegyet közérthetően és egyértelműen, magyar nyelven kell megfogalmazni.</p>
    <p>A jótállási jegynek utalnia kell arra, hogy a jótállás a fogyasztó jogszabályból eredő jogait nem érinti.</p>
    <p>A jótállásból eredő jogok a jótállási jeggyel érvényesíthetők. A jótállási jegy szabálytalan kiállítása vagy a fogyasztó rendelkezésére bocsátásának
    elmaradása a jótállás érvényességét nem érinti.</p>
    <p>A jótállási jegy fogyasztó rendelkezésére bocsátásának elmaradása esetén a szerződés megkötését bizonyítottnak kell tekinteni, ha az ellenérték
    megfizetését igazoló bizonylatot - az általános forgalmi adóról szóló törvény alapján kibocsátott számlát vagy nyugtát - a fogyasztó bemutatja. Ebben az
    esetben a jótállásból eredő jogok az ellenérték megfizetését igazoló bizonylattal érvényesíthetőek.</p>
    <p>A vállalkozás a fogyasztó jótállási igényéről jegyzőkönyvet köteles felvenni. Kötelező tartalmáról szintén e jogszabály rendelkezik.<br />
    Ha a jótállási igény rendezésének módja a fogyasztó igényétől eltér, ennek indokolását a jegyzőkönyvben meg kell adni.</p>
    <p>A jegyzőkönyv másolatát haladéktalanul, igazolható módon a fogyasztó rendelkezésére kell bocsátani.</p>
    <p>Ha a vállalkozás a fogyasztó jótállási igényének teljesíthetőségéről annak bejelentésekor nem tud nyilatkozni, álláspontjáról - az igény elutasítása esetén
    az elutasítás indokáról és a békéltető testülethez fordulás lehetőségéről is - öt munkanapon belül, igazolható módon köteles értesíteni a fogyasztót.</p>
    <p>A vállalkozás a kijavítás vagy a munka újbóli elvégzésének határidejét a Polgári Törvénykönyvről szóló 2013. évi V. törvény 6:159. § (4) bekezdésére
    figyelemmel köteles megállapítani és a fogyasztót a vállalt határidőről a bejelentéskor vagy a (4) bekezdésben meghatározott esetben az ott megjelölt
    időtartamon belül tájékoztatni.</p>
    <p>A vállalkozás a fogyasztó jótállási igényéről felvett jegyzőkönyvet az annak felvételétől számított három évig köteles megőrizni, és azt az ellenőrző hatóság
    kérésére bemutatni.</p>
    <p>A vállalkozás a dolgot kijavításra elismervény ellenében köteles átvenni. Az elismervényen fel kell tüntetni a fogyasztó nevét és címét, a dolog
    azonosításához szükséges adatokat, a dolog átvételének idejét és azt az időpontot, amikor a fogyasztó a kijavított dolgot átveheti.</p>
    <p>A vállakozás nem köteles gondoskodni járművek, továbbá a 10 kg-nál kisebb tömegű és tömegközlekedési járművön szállítható dolgok visszaszállításáról.</p>
    <p>A rendelkezések megsértése esetén a fogyasztóvédelmi hatóság jár el a fogyasztóvédelemről szóló szóló törvényben meghatározott szabályok szerint.</p>
    <p>A megjavított gépjármű fogyasztó részére történő átadásának ideje (jótállás kezdete): {{date('Y-m-d')}}</p>
    </div>
</body>
</html>

<style>
    body {
        padding: 25px 10px 0;
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
        margin-top: 10px;
        padding-bottom: 10px;
        clear: both;
        height: auto;
    }
    #basic-data span {
        display: block;
        font-size: 10px;
    }
    .data-title {
        font-weight: 400;
        font-size: 10px;
    }
    .data-name {
        font-weight: 700;
    }
    #data-content {
        clear: both;
        font-size: 10px;
        line-height: 11px;
        padding-top: 20px;
    }
    #data-content p {
        margin: 3px 0;
        padding: 0;
        color: #444;
    }
</style>