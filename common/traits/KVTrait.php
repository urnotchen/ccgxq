<?php

namespace common\traits;

use Yii;
use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;

/**
 * KVTrait class file.
 * for model
 * @Author haoliang
 * @Date 13.05.2015 14:33
 */
trait KVTrait
{

    /**
     * @brief 获取kv数组
     * @param $key
     * @param $value
     * @param $closure => function ($query) {
     * $query->where([
     * 'package_uuid' => array_keys($form->packages),
     * ]);
     * }
     *
     * @return  array|mixed kv.array
     */
    public static function kv($key, $value, $closure = false)
    {/*{{{*/

        $query = static::find()->select([$key, $value]);

        if ($closure instanceof \Closure) {
            $closure($query);
        }

        $raw = $query->asArray()->all();

        $val = empty($raw) ? [] : ArrayHelper::map($raw, $key, $value);

        return $val;
    }/*}}}*/

    /**
     * @brief 获取kv数组
     * @param $key
     * @param $value
     * @param array $condition => ['where' => [], 'orderBy' => mixed ]
     * @param bool $useCache 是否使用缓存，默认不使用
     * @param int $duration 默认缓存永不过期
     * @param null $dependency 缓存依赖
     * @return array|mixed kv.array
     * @throws InvalidConfigException
     */
    public static function k_v($key, $value, array $condition = [], $useCache = false, $duration = 0, $dependency = null)
    {
        if ($useCache) {
            # 确保是该函数完全同样的使用
            $params = func_get_args();
            $params[] = __CLASS__ . __METHOD__;
            $cacheKey = md5(json_encode($params));
            $cache = Yii::$app->cache;
            if (($cacheValue = $cache->get($cacheKey)) !== false) {
                return $cacheValue;
            }
        }

        $query = static::find()->select([$key, $value]);

        if (!empty($condition)) {

            foreach ($condition as $property => $v) {

                if ( ! method_exists($query, $property))
                    throw new InvalidConfigException(" {$query::className()} does not has property: {$property}");

                $query->$property($v);
            }

        }

        $raw = $query->asArray()->all();

        $val = empty($raw) ? [] : ArrayHelper::map($raw, $key, $value);

        if ($useCache) {
            $cache->set($cacheKey, $val, $duration, $dependency);
        }

        return $val;
    }

    /**
     * @param $key
     * @param $value1
     * @param $value2
     * @param bool $closure
     * @return array
     */
    public static function kv_v($key, $value1, $value2, $closure = false)
    {
        $query = static::find()->select([$key, $value1, $value2]);

        if ($closure instanceof \Closure) {
            $closure($query);
        }

        $raws = $query->asArray()->all();
        $value = [];
        foreach($raws as $row) {
            $value[$row[$key]] = $row[$value1].'-'.$row[$value2];
        }

        return $value;
    }

}
