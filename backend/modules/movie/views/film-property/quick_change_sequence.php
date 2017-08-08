<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/8/7
 * Time: 12:00
 */

echo "

<input type=text id=quick_change_sequence_val property_id={$propertyId} val={$sequence}>
<button id = submit_quick_change_sequence>提交</button>";

$this->registerJs(<<<Js
$("#submit_quick_change_sequence").on("click",submitQuickChangeSequence);

Js
);
?>
