<?php

namespace App\Console\Commands;


use App\Http\Controllers\InstagramController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

/**
 * ins明星动态同步脚本
 *
 * Class Instagram
 * @package App\Console\Commands
 */
class Instagram extends Command
{
    protected $signature = 'ins';

    protected $description = '同步ins明星动态';

    protected $updateTime;

    private $log;

    public function __construct()
    {
        parent::__construct();
        $this->log = Log::channel('ins');
    }

    public function handle()
    {
        $this->log->info('-----准备同步ins明星动态数据------');
        $time = microtime(true);
        try {

            $insObj = new InstagramController();

            $result = $insObj->handle();

        } catch (\Exception $e) {
            echo 'error:' . $e->getMessage() . ', file: ' . $e->getFile() . ', line:' . $e->getLine();
            $this->log->error('error:' . $e->getMessage() . ', line:' . $e->getLine());
        }

        $this->log->info('-----本次同步完成,处理结果:' . $result . '-----');
        $this->log->info('-----本次同步完成, 花费时间:' . (microtime(true) - $time) . '-----');
    }

}