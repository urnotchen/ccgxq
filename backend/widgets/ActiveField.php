<?php

namespace backend\widgets;

use Yii;
use yii\helpers\Html;

/**
 * ActiveField class file.
 *
 * 用于搜索表单
 *
 * @Author haoliang
 * @Date 25.09.2015 14:21
 */
class ActiveField extends \yii\widgets\ActiveField
{

    public $template = "{input}\n{hint}\n{error}";

    public function textInput($options = [])
    {/*{{{*/
        if (empty($options)) {
            $options['placeholder'] = $this->model->getAttributeLabel($this->attribute);
        }

        $options = array_merge($this->inputOptions, $options);
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::activeTextInput($this->model, $this->attribute, $options);

        return $this;
    }/*}}}*/

    public function dropDownList($items, $options = [])
    {/*{{{*/
        if (empty($options)) {
            $options['prompt'] = $this->model->getAttributeLabel($this->attribute);
        }

        $options = array_merge($this->inputOptions, $options);
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::activeDropDownList($this->model, $this->attribute, $items, $options);

        return $this;
    }/*}}}*/

}
