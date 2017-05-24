<?php

namespace frontend\modules\v1\traits;

use frontend\modules\v1\models\User;

trait UserRateLimiterTrait
{

    public function getRateLimit($request, $action)
    {
        return [600, 600];
    }

    public function loadAllowance($request, $action)
    {
        return [$this->allowance, $this->allowance_updated_at];
    }

    public function saveAllowance($request, $action, $allowance, $timestamp)
    {
        $this->allowance = $allowance;
        $this->allowance_updated_at = $timestamp;
        $this->scenario = User::SCENARIO_NONE;
        $this->save();
    }

}
