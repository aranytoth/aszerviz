<?php

namespace App\Console\Commands;

use App\Mail\Test as MailTest;
use App\Models\Worksheet;
use App\Models\WorksheetItem;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Process\Process;
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

    public $videoPath;
    public $videoOptimized;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /*
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

        */

        $this->videoPath = '/var/www/aszerviz.aranytoth.hu/storage/app/public/2025/09/09/BSejJC03UVXyE6ebkPlbyDgoiOgTNP9Iop30KJbq.mp4';
        $this->videoOptimized = '/var/www/aszerviz.aranytoth.hu/storage/app/public/2025/09/09/BSejJC03UVXyE6ebkPlbyDgoiOgTNP9Iop30KJbq-optimized.mp4';
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $ffmpegPath = 'C:\\ffmpeg\\ffmpeg.exe'; // Windows elérési út
        } else {
            $ffmpegPath = 'ffmpeg'; // Linux/Mac elérési út
        }
        /*$videoOutputPath = str_replace('.mp4', '_optimized.mp4', $this->videoPath);
        

        $process = new Process([
            $ffmpegPath,
            '-i', $this->videoPath,
            '-vf', 'scale=1280:720',
            '-c:v', 'libx265',
            '-crf', '28',
            '-c:a', 'aac',
            $videoOutputPath
        ]);

        $process->setTimeout(200);
        $result = $process->run();
        */

        $cmd = "{$ffmpegPath} -i {$this->videoPath} -vf scale=1280:720 -c:v libx265 -crf 28 -c:a aac {$this->videoOptimized}";
        shell_exec($cmd);
        
    }
}
