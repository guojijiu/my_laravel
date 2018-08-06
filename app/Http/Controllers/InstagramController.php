<?php

namespace App\Http\Controllers;

use App\Http\Model\StarDynamic;
use App\Service\Instagram\InstagramScraper\Instagram;
use Illuminate\Support\Facades\Request;

class InstagramController
{
    public function login()
    {
        $this->downloadImg("https://scontent-hkg3-2.cdninstagram.com/vp/093371944c6371b4ac19eee5ea97c23d/5C103F8C/t51.2885-15/e35/14540436_1672617186400129_5915460037328764928_n.jpg");
        echo 'aa';
        exit();
        try {
//            $instagram = Instagram::withCredentials('MrXinrain', 'a5711947');
//            $instagram->login();

            $instagram = new Instagram();

            $account = $instagram->getAccount('kyo1122');
            $imgData = StarDynamic::query()
                ->where('resource_user_id', $account->getId())
                ->get(['id', 'resource_id'])
                ->keyBy('resource_id')
                ->toArray();

            $userCount = count($imgData);

            $number = $userCount >= 100 ? 10 : 100;

            $nonPrivateAccountMedias = $instagram->getMedias('kyo1122', $number);

            if (empty($nonPrivateAccountMedias)) {
                return true;
            }

            $resourceData = [];

            foreach ($nonPrivateAccountMedias as $item) {

                $resourceId = $item->getId();

                //用户信息
                $resourceData[$resourceId]['star_id'] = '11';
                $resourceData[$resourceId]['resource_user_id'] = $account->getId();
//                $resourceData[$key]['user_name'] = $account->getUsername();
//                $resourceData[$key]['full_name'] = $account->getFullName();
//                $resourceData[$key]['pro_file_pic'] = $account->getProfilePicUrl();

                //图片相关

                $resourceData[$resourceId]['resource_id'] = $resourceId;
                $resourceData[$resourceId]['resource_from'] = 'instagram';
                $resourceData[$resourceId]['resource_type'] = $item->getType();
                $resourceData[$resourceId]['img_urls'] = $item->getImageHighResolutionUrl();
                $resourceData[$resourceId]['caption'] = $item->getCaption();
                $resourceData[$resourceId]['created_at'] = date('Y-m-d H:i:s', $item->getCreatedTime());

                //组图相关
                if ($item->getType() == 'sidecar') {
                    $media = $instagram->getMediaByUrl($item->getLink());

                    foreach ($media->getSidecarMedias() as $sidecarMedia) {
                        $resourceData[$resourceId]['img_urls'][] = $sidecarMedia->getImageHighResolutionUrl();
                    }

                }

            }

            $saveData = array_diff_key($resourceData, $imgData);

            if (empty($saveData)) {
                return 'no data';
            }

            array_walk($saveData, function (&$info) {
                $info['img_urls'] = $this->downloadImg($info['img_urls']);
            });

            StarDynamic::query()->insert($saveData);

            return 'save ok!';

        } catch (\Exception $e) {
            throw new \InvalidArgumentException($e->getMessage());
        }
    }

    /**
     * 下载图片
     *
     * @param $imgUrl
     */
    private function downloadImg($imgUrl)
    {
        //todo 定期删除目录下的图片文件

        $img = file_get_contents($imgUrl);
        $down = file_put_contents(__DIR__ . 'backstage/star/', md5($img . time() . rand(1, 99)));

        return $down;

    }

    /**
     * 上传图片
     *
     * @param $filePath
     */
    private function updateImg($filePath)
    {
        $imgObj = new ImageController();

        $imgObj->uploadImage($filePath);
    }
}
