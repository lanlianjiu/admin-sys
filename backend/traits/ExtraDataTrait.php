<?php
/**
 * @author: jiangyi
 * @date: 下午9:28 2018/8/29
 */

namespace backend\traits;

use yii\helpers\ArrayHelper;

/**
 * Trait ExtraDataTrait
 * @package backend\modules\admin\traits
 * @property array $extra_data
 */
trait ExtraDataTrait
{
    public function getExtraData($key = null, $default = null)
    {
        return $key === null ? $this->extra_data : ArrayHelper::getValue($this->extra_data, $key, $default);
    }

    public function setExtraData($key, $value = null)
    {
        is_array($key) ? $this->extra_data = $key : ArrayHelper::setValue($this->extra_data, $key, $value);
    }
}
