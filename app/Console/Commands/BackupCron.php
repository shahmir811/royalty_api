<?php

namespace App\Console\Commands;

use Log;
use Artisan;
use Illuminate\Console\Command;

class BackupCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Take regular backup after two hours.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Log::info("Cron is working fine!");
        
        // start the backup process
        Artisan::call('backup:run',['--only-db' => true]);
        $output = Artisan::output();
        // log the results
        Log::info("Backpack\BackupManager -- new backup started from admin interface \r\n" . $output);

        return Command::SUCCESS;
    }
}
