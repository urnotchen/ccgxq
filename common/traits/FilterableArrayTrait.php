<?php

namespace common\traits;

/**
 * FilterableArrayTrait class file.
 *
 * only for yii\base\Model
 *
 * 此trait是与类似ActiveRecord::dirtyAttributes的, 适用于Model的实现
 *
 * 记录经由 Model::setAttributes()或 load() 输入到Model中的_dirtyAttributes属性,
 * 并依此增加 toFilterArray() 来提供 toArray() 缺少的功能:
 *     `过滤掉 Model中 未被赋值/修改的属性, 不再返回`
 *
 * 注意:
 * 本实现与AR::getDirtyAttributes()的实现很不相同:
 * - self::_dirtyAttributes 类型为list, 只记录经由setAttributes()或load()被修改的属性, 而未记录其值
 * - `$model->someAttribute = 'abc'` 这种形式不会被 `$_dirtyAttributes` 记录
 *
 * @Author haoliang
 * @Date 19.04.2016 11:06
 */
trait FilterableArrayTrait
{

    private $_dirtyAttributes = [];

    public function toFilterArray(array $fields = [], array $expand = [], $recursive = true)
    {
        $filtedFields = array_intersect($this->_dirtyAttributes, $fields);

        if (empty($filtedFields)) return [];

        return $this->toArray($filtedFields, $expand, $recursive);
    }

    public function setAttributes($values, $safeOnly = true)
    {
        if (is_array($values)) {
            $attributes = array_flip($safeOnly ? $this->safeAttributes() : $this->attributes());
            foreach ($values as $name => $value) {
                if (isset($attributes[$name])) {
                    $this->$name = $value;

                    $this->_dirtyAttributes[] = $name;
                } elseif ($safeOnly) {
                    $this->onUnsafeAttribute($name, $value);
                }
            }
        }
    }

}
