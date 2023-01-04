<?php

namespace App\Console\Commands;

use App\Jobs\Queue6;
use Illuminate\Console\Command;

class P6 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'p:q6';

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
        Queue6::dispatch('任务发送时间：' . date('Y-m-d H:i:s'))
            ->delay(now()->addMinute(random_int(0,10)));

        for ($i = 6; $i > 0; $i--) {
            $queue = 'default';
            if ($i%3 == 1) {
                $queue = 'A';
            } else if ($i%3 == 2) {
                $queue = 'B';
            }
            sleep(random_int(0, 2));
            Queue6::dispatch('测试优先级，当前优先队列为：' . $queue . '，入队时间：' . date("Y-m-d H:i:s"))->onQueue($queue);
        }



        return 0;
    }
}
