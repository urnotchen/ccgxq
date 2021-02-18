<?php

use yii\db\Schema;
use yii\db\Migration;

class m210204_050605_create_table_book extends Migration
{


    public $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    public function safeUp()
    {

        $this->createTable('book', [

            'id'                => $this->primaryKey(),
            'order_id'           => $this->integer()->notNull(). " COMMENT '项目id'",
            'day_time'           => $this->integer()->unsigned()->notNull(). " COMMENT '标题'",
            'day_book_id'           => $this->integer()->unsigned()->notNull(). " COMMENT ''",
            'book_time_arr_val'           => $this->smallInteger()->unsigned()->notNull(). " COMMENT ''",
            // timestamp
            'book_begin_time'  => $this->integer()->unsigned()->notNull(). " COMMENT '预定起始时间'",
            'book_end_time'  => $this->integer()->unsigned()->notNull(). " COMMENT '预定结束时间'",
            'status'            => $this->smallInteger()->notNull()." COMMENT '状态'",

            'created_at'        => $this->integer()->unsigned(),
            'created_by'        => $this->integer()->unsigned(),
            'updated_at'        => $this->integer()->unsigned(),
            'updated_by'        => $this->integer()->unsigned(),
        ], $this->tableOptions. " COMMENT '预约表'");

        $this->createTable('day_book', [

            'id'                => $this->primaryKey(),
            'order_id'           => $this->integer()->unsigned()->notNull(). " COMMENT '姓名'",
            'day_time'           => $this->integer()->unsigned()->notNull(). " COMMENT ''",
            //时间模式早七点到万八点，半小时一个数据，为1表示次时间段可办公
            'book_time_arr'           => $this->string(1000)->unsigned()->notNull(). " COMMENT '预约时间数组'",
            //时间模式早七点到万八点，半小时一个数据，数据为当前
            'book_num_arr'           => $this->string(1000)->notNull(). " COMMENT '预约人数数组'",
            'pre_half_hour_people'           => $this->integer()->unsigned()->notNull(). " COMMENT '回复'",
            'book_total'           => $this->integer()->unsigned()->notNull(). " COMMENT 可预约总数'",
            'book_num'           => $this->integer()->unsigned()->notNull(). " COMMENT '已预约人数'",
            'status'            => $this->smallInteger()->notNull()." COMMENT '状态'",
            //预约时段 状态数组
            'book_status_arr'            => $this->string(1000)->notNull()." COMMENT '状态数组'",

            'created_at'        => $this->integer()->unsigned(),
            'updated_at'        => $this->integer()->unsigned(),
        ], $this->tableOptions. " COMMENT '预约总表'");


    }

    public function safeDown()
    {
        $this->dropTable($this->tableName);


    }

}
