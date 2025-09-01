<?php

namespace App\Console\Commands;

use App\Mail\Test as MailTest;
use App\Models\Worksheet;
use App\Models\WorksheetItem;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use SzamlaAgent\Buyer;
use SzamlaAgent\Document\Invoice\Invoice;
use SzamlaAgent\Item\InvoiceItem;
use SzamlaAgent\SzamlaAgentAPI;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $model = Worksheet::with('items')->where('id', '01990509-dcc9-709f-bbe5-df9f4aa53788')->first();

        //Mail::to('aranytoth.tibor@gmail.com')->send(new MailTest());
        $szamlazz = SzamlaAgentAPI::create('qwd4jiyr796mzq9jcbybc67fpsezrzw4imwe32ta4v', true, 1);

        $invoice = new Invoice();
        $invoice->setBuyer(new Buyer('Arany-Tóth Tibor','1136','Budapest', 'Szegő utca 11'));

        foreach($model->items as $item){
            $netPrice = $item->unit_price*$item->quantity;
            $vatAmount = $item->unit_price*$item->quantity/100*$item->vat;
            $invoiceItem = new InvoiceItem($item->item_name, $item->unit_price, $item->quantity, $item->unitName, strval($item->vat));
            $invoiceItem->setNetPrice($netPrice);
            $invoiceItem->setVatAmount($vatAmount);
            $invoiceItem->setGrossAmount($netPrice+$vatAmount);
            $invoice->addItem($invoiceItem);
        }

        $result = $szamlazz->generateInvoice($invoice);

        if($result->isSuccess()){
            dd($result);
        }


        
    }
}
