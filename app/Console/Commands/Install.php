<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install';

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

        copy(base_path(".env.example"), base_path(".env"));
        $this->comment("Replaced enviroment variables for the project");

        $this->call("key:generate");

        $this->info(PHP_EOL . "Setting up database notifier.sqlite...". PHP_EOL);
        @unlink(database_path('notifier.sqlite'));
        touch(database_path('notifier.sqlite'));

        $this->call("migrate");
        $this->call("db:seed");
    }

}
