<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

use App\Jobs\DeleteOldTasksJob;

class DeleteOldTasksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-old-tasks-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete tasks older than 30 days.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('Triggering......DeleteOldTasksJob');
        DeleteOldTasksJob::dispatch();
    }
}
