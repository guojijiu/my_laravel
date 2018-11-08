<?php

namespace App\Http\Controllers;


use App\Model\Star;
use App\Model\StarRelation;
use App\Model\StarRelationType;
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
}