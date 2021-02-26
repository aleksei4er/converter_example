<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PlayCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:play';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $t = \DB::select(\DB::raw('
        SELECT u.*, GROUP_CONCAT(b.name) FROM users u 
        LEFT JOIN user_book ub ON (u.id = ub.user_id)
        LEFT JOIN books b ON (b.id = ub.book_id)
        GROUP BY u.id
        HAVING count(b.id) = 2 and COUNT(DISTINCT (b.author)) = 1
        '));
        dd($t);
        return 0;
    }
}
