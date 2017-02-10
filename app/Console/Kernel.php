<?php namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \Hexcores\Api\Console\ApiKeyGenerate::class,
        \App\Console\Commands\ImportCandidateCommand::class,
        \App\Console\Commands\MongoImportCommand::class,
        \App\Console\Commands\DropCommand::class,
        \App\Console\Commands\DropByElectionYearCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //
    }
}
