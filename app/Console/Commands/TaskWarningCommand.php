<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\{User, Task, Submission};

class TaskWarningCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:warning';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command For Giving Warning to an Unprocessed Task';

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
        return 0;
    }
}
