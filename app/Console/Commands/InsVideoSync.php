<?php
/**
 * Created by PhpStorm.
 * User: user009
 * Date: 2018/11/22
 * Time: 9:27
 */

namespace App\Console\Commands;


use App\Http\Controllers\InstagramController;
use App\Http\Controllers\InsVideoSyncController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class InsVideoSync extends Command
{
    protected $signature = 'ins_img';

    protected $description = '上传ins明星图片';

    protected $updateTime;

    private $log;

    public function __construct()
    {
        parent::__construct();
        $this->log = Log::channel();
    }

    public function handle()
    {
        $this->log->info('-----准备上传ins明星图片数据------');
        $time = microtime(true);
        try {

            $insObj = new InstagramController();

            $result = $insObj->dealVideoSync();

        } catch (\Exception $e) {
            echo 'error:' . $e->getMessage() . ', file: ' . $e->getFile() . ', line:' . $e->getLine();
            $this->log->error('error:' . $e->getMessage() . ', line:' . $e->getLine());
        }

        $this->log->info('-----本次上传完成,处理结果:' . json_encode($result) . '-----');
        $this->log->info('-----本次同步完成, 花费时间:' . (microtime(true) - $time) . '-----');
    }

}