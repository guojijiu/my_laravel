<?php

namespace App\Model\Prize;

use Illuminate\Database\Eloquent\Model;

/**
 * 奖项model
 *
 * @author 刘伟
 */
class Prize extends Model
{
    /**
     * 关联所有的资源数据
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prizeResources()
    {
        return $this->hasMany(PrizeResource::class, 'prize_id', 'id');
    }

    /**
     * 关联资源类型
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function hasPrizeMold()
    {
        return $this->hasOne(PrizeMold::class, 'prize_mold_id', 'id');
    }
}