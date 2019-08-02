<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;


/**
 * 导出数据类
 *
 * Class ExportController
 * @package App\Http\Controllers
 */
class ExportController
{
    /**
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function exportTest1()
    {

//        $cellData[] = [
//            '打款批次表主键ID', '批次UUID', '批次单任务UUID', '批次流水号', '批次号显示名称', '商户UUID', '受托方或称经纪公司UUID',
//            '付款主账户UUID', '付款主账户ID', '付款子账户ID', '该批次的订单总笔数', '付款方式或付款渠道', '通过验证的订单笔数', '验证失败的订单笔数',
//            '存在风险的订单笔数', '总的实际付款订单笔数', '预期付款总金额', '总的核验通过的预期付款总金额', '实际付款总金额', '服务费用',
//            '服务费抵扣金额', '合计退汇金额', '合计冲补金额', '合计税费', '是否删除', '是否锁定', '状态', '批次收款收款账户类型', '创建时间',
//            '更新时间', '本条记录创建人ID', '请求打款时间', '结算时间'
//        ];
//        $data = DB::table('vz_remit_order')
//            ->get(['*'])
//            ->toArray();
//
//        if (!empty($data)) {
//            foreach ($data as $datum) {
//                $cellData[] = (array)$datum;
//            }
//        }

        try {
            if (empty($datas)) {
                return false;
            }

            set_time_limit(0);
            /** @var Spreadsheet $objSpreadsheet */
            $objSpreadsheet = app(Spreadsheet::class);
            /* 设置默认文字居左，上下居中 */
            $styleArray = [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ];
            $objSpreadsheet->getDefaultStyle()->applyFromArray($styleArray);
            /* 设置Excel Sheet */
            $activeSheet = $objSpreadsheet->setActiveSheetIndex(0);

            /* 行数据处理 */
            foreach ($datas as $sKey => $sItem) {
                /* 默认文本格式 */
                $pDataType = DataType::TYPE_STRING;

                /* 设置单元格格式 */
                if (isset($options['format']) && !empty($options['format'])) {
                    $colRow = Coordinate::coordinateFromString($sKey);

                    /* 存在该列格式并且有特殊格式 */
                    if (isset($options['format'][$colRow[0]]) &&
                        NumberFormat::FORMAT_GENERAL != $options['format'][$colRow[0]]) {
                        $activeSheet->getStyle($sKey)->getNumberFormat()
                            ->setFormatCode($options['format'][$colRow[0]]);

                        if (false !== strpos($options['format'][$colRow[0]], '0.00') &&
                            is_numeric(str_replace(['￥', ','], '', $sItem))) {
                            /* 数字格式转换为数字单元格 */
                            $pDataType = DataType::TYPE_NUMERIC;
                            $sItem = str_replace(['￥', ','], '', $sItem);
                        }
                    } elseif (is_int($sItem)) {
                        $pDataType = DataType::TYPE_NUMERIC;
                    }
                }

                $activeSheet->setCellValueExplicit($sKey, $sItem, $pDataType);

                /* 存在:形式的合并行列，列入A1:B2，则对应合并 */
                if (false !== strstr($sKey, ":")) {
                    $options['mergeCells'][$sKey] = $sKey;
                }
            }

            unset($datas);

            /* 设置锁定行 */
            if (isset($options['freezePane']) && !empty($options['freezePane'])) {
                $activeSheet->freezePane($options['freezePane']);
                unset($options['freezePane']);
            }

            /* 设置宽度 */
            if (isset($options['setWidth']) && !empty($options['setWidth'])) {
                foreach ($options['setWidth'] as $swKey => $swItem) {
                    $activeSheet->getColumnDimension($swKey)->setWidth($swItem);
                }

                unset($options['setWidth']);
            }

            /* 设置背景色 */
            if (isset($options['setARGB']) && !empty($options['setARGB'])) {
                foreach ($options['setARGB'] as $sItem) {
                    $activeSheet->getStyle($sItem)
                        ->getFill()->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()->setARGB(Color::COLOR_YELLOW);
                }

                unset($options['setARGB']);
            }

            /* 设置公式 */
            if (isset($options['formula']) && !empty($options['formula'])) {
                foreach ($options['formula'] as $fKey => $fItem) {
                    $activeSheet->setCellValue($fKey, $fItem);
                }

                unset($options['formula']);
            }

            /* 合并行列处理 */
            if (isset($options['mergeCells']) && !empty($options['mergeCells'])) {
                $activeSheet->setMergeCells($options['mergeCells']);
                unset($options['mergeCells']);
            }

            /* 设置居中 */
            if (isset($options['alignCenter']) && !empty($options['alignCenter'])) {
                $styleArray = [
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ];

                foreach ($options['alignCenter'] as $acItem) {
                    $activeSheet->getStyle($acItem)->applyFromArray($styleArray);
                }

                unset($options['alignCenter']);
            }

            /* 设置加粗 */
            if (isset($options['bold']) && !empty($options['bold'])) {
                foreach ($options['bold'] as $bItem) {
                    $activeSheet->getStyle($bItem)->getFont()->setBold(true);
                }

                unset($options['bold']);
            }

            /* 设置单元格边框，整个表格设置即可，必须在数据填充后才可以获取到最大行列 */
            if (isset($options['setBorder']) && $options['setBorder']) {
                $border = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN, // 设置border样式
                            'color' => ['argb' => 'FF000000'], // 设置border颜色
                        ],
                    ],
                ];
                $setBorder = 'A1:' . $activeSheet->getHighestColumn() . $activeSheet->getHighestRow();
                $activeSheet->getStyle($setBorder)->applyFromArray($border);
                unset($options['setBorder']);
            }

            $fileName = !empty($fileName) ? $fileName : (date('YmdHis') . '.xlsx');

            if (!isset($options['savePath'])) {
                /* 直接导出Excel，无需保存到本地，输出07Excel文件 */
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header(
                    "Content-Disposition:attachment;filename=" . iconv(
                        "utf-8", "GB2312//TRANSLIT", $fileName
                    )
                );
                header('Cache-Control: max-age=0');//禁止缓存
                $savePath = 'php://output';
            } else {
                $savePath = $options['savePath'];
            }

            ob_clean();
            ob_start();
            $objWriter = IOFactory::createWriter($objSpreadsheet, 'Xlsx');
            $objWriter->save($savePath);
            /* 释放内存 */
            $objSpreadsheet->disconnectWorksheets();
            unset($objSpreadsheet);
            ob_end_flush();

            return true;
        } catch (\Exception $e) {
            return false;
        }


    }
}