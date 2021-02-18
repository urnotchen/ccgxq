<?php

namespace common\traits;

/**
 * ModelPrepareTrait class file.
 *
 * only for model
 *
 * @Author haoliang
 * @Date 11.05.2016 11:42
 */
trait ModelPrepareTrait
{

    use \common\traits\LoadExceptionTrait;
    use \common\traits\ValidateExceptionTrait;
    use \common\traits\ErrorsJsonTrait;

    public function prepare($rawParams, $runValidation = true)
    {/*{{{*/
        $this->load( $rawParams , '');
        if ($runValidation){

            return $this->validate();
        }

        return true;
    }/*}}}*/
}    
