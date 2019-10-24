<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * 用户组表
 *
 * Class Group
 * @package App\Models\Mysql
 */
class Group extends Model
{

    protected $table = self::TABLE_NAME;

    public $guard_name = 'default';

    protected $primaryKey = self::ID;

    protected $dateFormat = 'U';

    const CREATED_AT = 'createdAt';

    const DATABASE_CONF = 'mysql';

    const TABLE_NAME = 'vz_group';

    const ID = 'ID';
    const NAME = 'name';//组名称
    const PARENT_ID = 'parentID';//父级ID
    const PLATFORM = 'platform';//适用平台，1-后台，2-前台
    const DESCRIPTION = 'description';//角色描述
    const IS_DEL = 'isDel';//是否删除，0-默认未删除，1-已删除
    const UPDATED_AT = 'updatedAt';//更新时间

}
