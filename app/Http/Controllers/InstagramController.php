<?php

namespace App\Http\Controllers;

use App\Model\Star;
use App\Model\StarDynamic;
use App\Service\Instagram\InstagramScraper\Instagram;
use Illuminate\Support\Facades\Redis;

class InstagramController
{

    //设置明星前缀
    const STAR_PRI = 'star:ins_star_';

    //设置过期时间
    const EXPIRE_TIME = 7200;

    /**
     * 倒ins明星数据接口
     */
    public function handle()
    {
        //不设置执行时间
        ini_set('max_execution_time', '0');
        $res = [];
        Star::query()
            ->where('social_account', '<>', '')
            ->chunk(5, function ($starData) use (&$res) {
                foreach ($starData as $starInfo) {
                    $socialAccount = json_decode($starInfo['social_account'], true);

                    if (in_array('ig', array_keys($socialAccount))) {

                        $accountCache = Redis::get(self::STAR_PRI . $socialAccount['ig']);

                        if (isset($accountCache)) {
                            continue;
                        }

                        $result = $this->save($starInfo['id'], $socialAccount['ig']);

                        $res[] = [$socialAccount['ig'] => $result];

                    }
                }
            });

        return $res;
    }

    public function save($starId, $igName)
    {

        try {
//            $instagram = Instagram::withCredentials('MrXinrain', 'a5711947');
//            $instagram->login();

            $instagram = new Instagram();

            //根据用户名获取instagram账号基本信息
            $account = $instagram->getAccount($igName);

            //获取当前明星已存数据
            $imgData = StarDynamic::query()
                ->where(['resource_user_id' => $account->getId(), 'resource_from' => 'instagram'])
                ->get(['id', 'resource_id'])
                ->keyBy('resource_id')
                ->toArray();

            $userCount = count($imgData);

            $number = $userCount >= 100 ? 5 : 100;

            //根据用户名获取instagram账号动态信息
            $nonPrivateAccountMedias = $instagram->getMedias($igName, $number);

            if (empty($nonPrivateAccountMedias)) {
                return true;
            }

            $resourceData = [];

            foreach ($nonPrivateAccountMedias as $item) {

                $resourceId = $item->getId();

                //用户信息
                $resourceData[$resourceId]['star_id'] = $starId;
                $resourceData[$resourceId]['resource_user_id'] = $account->getId();
//                $resourceData[$key]['user_name'] = $account->getUsername();
//                $resourceData[$key]['full_name'] = $account->getFullName();
//                $resourceData[$key]['pro_file_pic'] = $account->getProfilePicUrl();

                //图片相关

                $resourceData[$resourceId]['resource_id'] = $resourceId;
                $resourceData[$resourceId]['resource_from'] = 'instagram';
                $resourceData[$resourceId]['resource_type'] = $item->getType();
                $resourceData[$resourceId]['caption'] = $item->getCaption();
                $resourceData[$resourceId]['created_at'] = date('Y-m-d H:i:s', $item->getCreatedTime());

                //组图相关
                if ($item->getType() == 'sidecar') {

                    $media = $instagram->getMediaByUrl($item->getLink());

                    $imgUrls = [];
                    foreach ($media->getSidecarMedias() as $sidecarMedia) {

                        $imgUrl = $sidecarMedia->getImageThumbnailUrl();

                        //图片上传到七牛服务器
//                        $fileName = $this->downloadImg($imgUrl);

                        $imgUrls[] = $imgUrl;
                    }

                    $resourceData[$resourceId]['img_urls'] = implode(',', $imgUrls);

                } else {
                    //单图

                    $imgUrl = $item->getImageThumbnailUrl();

                    //图片上传到七牛服务器
//                    $fileName = $this->downloadImg($imgUrl);

                    $resourceData[$resourceId]['img_urls'] = $imgUrl;
                }

            }

            $saveData = array_diff_key($resourceData, $imgData);

            if (empty($saveData)) {
                Redis::setex(self::STAR_PRI . $igName, self::EXPIRE_TIME, true);
                return 'deal ok,on data!';
            }

            StarDynamic::query()->insert($saveData);

            return 'deal ok，number:' . count($saveData);

        } catch (\Exception $e) {
            throw new \InvalidArgumentException($e->getMessage());
        }
    }

    /**
     * 处理脚本数据
     */
    public function dealImg()
    {
        //不设置执行时间
        ini_set('max_execution_time', '0');
        $dealCount = 0;
        StarDynamic::query()
            ->where(['is_dealed' => '2', 'resource_from' => 'instagram'])
            ->chunk(10, function ($starData) use (&$dealCount) {

                if (empty($starData)) {
                    return true;
                }

                foreach ($starData as $starInfo) {

                    if (strpos($starInfo['img_urls'], ',')) {

                        $imgUrls = explode(',', $starInfo['img_urls']);

                        $fileName = [];

                        array_walk($imgUrls, function ($imgUrl) use (&$fileName) {
                            $fileName[] = $this->downloadImg($imgUrl);
                        });

                    } else {

                        $fileName = $this->downloadImg($starInfo['img_urls']);
                    }

                    $updateFileName = is_array($fileName) ? implode(',', $fileName) : $fileName;

                    $starInfo->update(['is_dealed' => 1, 'img_urls' => $updateFileName]);

                    $dealCount++;
                }
            });

        return 'deal ok，number：' . $dealCount;
    }

    /**
     * 下载图片
     *
     * @param $imgUrl
     * @return mixed
     */
    private function downloadImg($imgUrl)
    {
        $suffix = substr(strrchr($imgUrl, '.'), 1);

        $img = file_get_contents($imgUrl);

        $path = '/usr/local/src/images/';
        if (!is_dir($path)) {
            mkdir("$path", 0777, true);
        }

        $fileName = $path . date('YmdHis') . rand(1, 99) . '.' . $suffix;

        file_put_contents($fileName, $img);

        return $this->updateImg($fileName);

    }

    /**
     * 上传图片
     *
     * @param $filePath
     * @return mixed
     */
    private function updateImg($filePath)
    {

        $imgObj = new ImageController();

        $key = 'backstage/star/' . md5(basename($filePath) . time() . rand(1, 99));

        $imgObj->uploadImage($key, $filePath);

        if (file_exists($filePath)) {
            unlink($filePath);
        }

        return $key;
    }
}
