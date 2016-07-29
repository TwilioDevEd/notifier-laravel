<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

class Setup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate required resources for the project to work';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info(PHP_EOL . "Setting up Notifier-Laravel..." . PHP_EOL);

        @unlink(base_path(".env"));
        copy(base_path(".env.example"), base_path(".env"));
        $this->comment("Replaced enviroment variables for the project");

        $this->call("key:generate");
    }
}
