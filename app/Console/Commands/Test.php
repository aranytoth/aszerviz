<?php

namespace App\Console\Commands;

use App\Mail\Test as MailTest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

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
        Mail::to('aranytoth.tibor@gmail.com')->send(new MailTest());
    }
}
