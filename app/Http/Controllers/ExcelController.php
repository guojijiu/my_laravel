<?php

namespace App\Http\Controllers;


use App\Model\Prize\Prize;
use App\Model\Prize\PrizeMold;
use App\Model\Prize\PrizeResource;
use App\Model\SeriesSeason;
use App\Model\Star;
use App\Model\StarRelation;
use App\Model\StarRelationType;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelController
{
    /**
     * @return array|bool
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function starRelation()
    {
        $path = '/usr/local/upload/star_relation.xlsx';

        $reader = IOFactory::createReader('Xlsx');
        $sheet = $reader->load($path); //载入excel表格

        $worksheet = $sheet->getActiveSheet();
        $highestRow = $worksheet->getHighestRow(); // 总行数
        $highestColumn = $worksheet->getHighestColumn(); // 总列数

        $lines = $highestRow - 1;
        if ($lines <= 0) {
            return false;
        }

        $starRelationType = StarRelationType::query()
            ->where('status', 1)
            ->get(['id', 'name'])
            ->keyBy('name')
            ->toArray();

        $stars = Star::query()
            ->where('status', 1)
            ->get(['id', 'name'])
            ->keyBy('name')
            ->toArray();

        $data = [];
        for ($row = 3; $row <= $highestRow; $row++) {
            for ($column = 'B'; $column <= $highestColumn; $column++) {
                $value = $worksheet->getCell($column . $row)->getValue();
                if (empty($value)) {
                    continue;
                }
                $data[] = [
                    'star_name' => $worksheet->getCell('A' . $row)->getValue(),
                    'relation_star_name' => $worksheet->getCell($column . $row)->getValue(),
                    'relation' => $worksheet->getCell($column . 2)->getValue()
                ];
            }
        }

        if (empty($data)) {
            return $data;
        }

        $saveData = [];
        foreach ($data as $key => $datum) {
            if (isset($stars[$datum['star_name']])) {
                $saveData[$key]['star_id'] = $stars[$datum['star_name']]['id'];
            }
            if (isset($stars[$datum['relation_star_name']])) {
                $saveData[$key]['relation_star_id'] = $stars[$datum['relation_star_name']]['id'];
            }
            if (isset($starRelationType[$datum['relation']])) {
                $saveData[$key]['relation_type'] = $starRelationType[$datum['relation']]['id'];
            }

            $saveData[$key]['status'] = 1;
        }

        StarRelation::query()->insert(array_values($saveData));

        return $saveData;


    }

    /**
     * @return array|bool
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */

    public function PrizeRelation()
    {
        $path = '/usr/local/upload/2017SBS.xlsx';

        $reader = IOFactory::createReader('Xlsx');
        $sheet = $reader->load($path); //载入excel表格

        $worksheet = $sheet->getActiveSheet();
        $highestRow = $worksheet->getHighestRow(); // 总行数
        $highestColumn = $worksheet->getHighestColumn(); // 总列数

        $lines = $highestRow - 1;
        if ($lines <= 0) {
            return false;
        }

        $prizeMold = PrizeMold::query()->where('status', 1)->get(['id', 'title'])->toArray();

        $title = $worksheet->getCell("A" . 1)->getValue();
        $time = $worksheet->getCell("C" . 2)->getValue();
        //windows是25569，linux是24107
        $openTime = gmdate("Y-m-d H:i:s", intval(($time - 24107) * 3600 * 24));
        $type = $worksheet->getCell("C" . 3)->getValue();
        $cover = $worksheet->getCell("C" . 4)->getValue();
        $city = $worksheet->getCell("C" . 5)->getValue();
        $prizeMoldId = array_map(function ($prizeInfo) use ($type) {
            if (strpos($prizeInfo['title'], $type) !== false) {
                return $prizeInfo['id'];
            }
        }, $prizeMold);
        $prizeMoldId = implode(',', array_filter($prizeMoldId));
        $prizeData = [
            'prize_mold_id' => $prizeMoldId,
            'cover' => $cover,
            'title' => $title,
            'open_time' => $openTime,
            'host_city' => $city
        ];

        $prizeResource = [];
        $key = 0;
        $starRelationMax = 0;
        for ($row = 7; $row <= $highestRow; $row++) {
            $prizeName = $worksheet->getCell("A" . $row)->getValue();
            $isAward = $worksheet->getCell("B" . $row)->getValue();
            $star = $worksheet->getCell("C" . $row)->getValue();
            $season = $worksheet->getCell("D" . $row)->getValue();
            $prizeResource[$key] = [
                'prize_name' => $prizeName,
                'is_award' => $isAward == '获奖' ? 1 : 2,
            ];

            if (!empty($star)) {
                if (strpos($star, '&') !== false) {
                    $starArr = explode('&', $star);
                    if (!empty($starRelationMax) && $starRelationMax != 0) {
                        $starRelationMax++;
                    } else {
                        $starRelation = PrizeResource::query()->where('status', 1)->max('star_relation');
                        $starRelation++;
                        $starRelationMax = $starRelation;
                    }
                    foreach ($starArr as $starKey => $item) {
                        $starInfo = Star::query()->where('name', $item)->first(['id', 'name']);
                        if (!empty($season)) {
                            $seasonInfo = SeriesSeason::query()->where('name', $season)->first(['id', 'name']);
                            $prizeResource[$key]['star'][$starKey]['relation_id'] = $seasonInfo['id'];
                        }
                        $prizeResource[$key]['star'][$starKey]['resource_id'] = $starInfo['id'];
                        $prizeResource[$key]['star'][$starKey]['resource_type'] = 9;
                        $prizeResource[$key]['star'][$starKey]['star_relation'] = $starRelationMax;
                    }
                } else {
                    $starInfo = Star::query()->where('name', $star)->first();
                    $prizeResource[$key]['resource_id'] = $starInfo['id'];
                    $prizeResource[$key]['resource_type'] = 9;
                    if (!empty($season)) {
                        $seasonInfo = SeriesSeason::query()->where('name', $season)->first(['id', 'name']);
                        $prizeResource[$key]['relation_id'] = $seasonInfo['id'];
                    }

                }
            } else {
                $seasonInfo = SeriesSeason::query()->where('name', $season)->first(['id', 'name']);
                $prizeResource[$key]['resource_id'] = $seasonInfo['id'];
                $prizeResource[$key]['resource_type'] = 2;
            }
            if (empty($prizeResource[$key]['resource_id'])) {
                unset($prizeResource[$key]);
            }
            $key++;
        }

        $extraResource = [];
        foreach ($prizeResource as $prizeKey => &$prizeItem) {
            $prizeItem['relation_id'] = 0;
            $prizeItem['star_relation'] = 0;
            if ($prizeItem['prize_name'] == '最佳情侣奖') {
                foreach ($prizeItem['star'] as $key => $prize) {
                    $extraResource[$key][] = [
                        'prize_name' => '最佳情侣奖',
                        'is_award' => $prizeItem['is_award'],
                        'resource_id' => $prize['resource_id'],
                        'resource_type' => $prize['resource_type'],
                        'relation_id' => $prize['relation_id'],
                        'star_relation' => $prize['star_relation']
                    ];
                }
                unset($prizeResource[$prizeKey]);
            }
        }
        $extraResource = collect($extraResource)->collapse()->sortBy('star_relation')->toArray();

        $prizeResource = array_merge($prizeResource, $extraResource);
        DB::beginTransaction();
        try {

            $prizeId = Prize::query()->insertGetId($prizeData);

            array_walk($prizeResource, function (&$resource) use ($prizeId) {
                $resource['prize_id'] = $prizeId;
            });

            PrizeResource::query()->insert($prizeResource);

            DB::commit();
        } catch (\Exception $e) {

            DB::rollBack();
            throw new Exception($e->getMessage());
        }

        return $prizeResource;


    }
}