<?php

namespace App\Model\Prize;

use Illuminate\Database\Eloquent\Model;

/**
 * 奖项资源model
 *
 * @author 刘伟
 */
class PrizeResource extends Model
{
    /**
     * 关联资源数据所属
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function prizes()
    {
        return $this->belongsTo(Prize::class, 'prize_id', 'id');
    }
}