<?php

use yii\db\Schema;
use yii\db\Migration;

class m210121_050605_create_tables_project extends Migration
{



    public $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    public function safeUp()
    {
        /*
         *
         * 项目分类表
         * */
        $this->createTable('project_category', [

            'id'                => $this->primaryKey(),
            'name'              => $this->string()->notNull(). " COMMENT '标题'",
            'category_id'       => $this->smallInteger()->notNull(). " COMMENT '类别'",
            'status'            => $this->smallInteger()->notNull()." COMMENT '状态'",

            'created_at'        => $this->integer()->unsigned(),
            'created_by'        => $this->integer()->unsigned(),
            'updated_at'        => $this->integer()->unsigned(),
            'updated_by'        => $this->integer()->unsigned(),
        ], $this->tableOptions. " COMMENT '办事项目表'");

        /*
         *
         * 具体项目表
         * */
        $this->createTable('project', [

            'id'                => $this->primaryKey(),
            'project_category_id'              => $this->integer()->notNull(). " COMMENT '项目分类id'",
            'name'              => $this->string()->notNull(). " COMMENT '标题'",
            'sxlx'              => $this->string()->notNull(). " COMMENT '标题'",
            'kbbm'              => $this->string()->notNull(). " COMMENT '标题'",
            'sszt'              => $this->string()->notNull(). " COMMENT '标题'",
            'xscj'              => $this->string()->notNull(). " COMMENT '标题'",
            'sdyj'              => $this->text()->notNull(). " COMMENT '标题'",
            'qlly'              => $this->string()->notNull(). " COMMENT '标题'",
            'status'            => $this->smallInteger()->notNull()." COMMENT '状态'",

            'created_at'        => $this->integer()->unsigned(),
            'created_by'        => $this->integer()->unsigned(),
            'updated_at'        => $this->integer()->unsigned(),
            'updated_by'        => $this->integer()->unsigned(),
        ], $this->tableOptions. " COMMENT '办事项目表'");

        /*
         *
         * 审批表
         * */
        $this->createTable('approval', [

            'id'                => $this->primaryKey(),
            'project_id'        => $this->integer()->notNull(). " COMMENT '项目id'",
            'name'              => $this->string()->notNull(). " COMMENT '业务名称'",
            'sequence'        => $this->smallInteger()->notNull(). " COMMENT '业务序号'",
            'agency'              => $this->string()->notNull(). " COMMENT '办理机构'",

            'basic_sxlx'              => $this->string()->notNull(). " COMMENT '事项类型'",
            'basic_bjlx'              => $this->string()->notNull(). " COMMENT '办件类型'",
            'basic_sszt'              => $this->string()->notNull(). " COMMENT '实施主体'",
            'basic_xscj'              => $this->string()->notNull(). " COMMENT '行使层级'",
            'basic_cnbjsx'              => $this->string()->notNull(). " COMMENT '承诺办结时限'",
            'basic_fdbjsx'              => $this->string()->notNull(). " COMMENT '法定办结时限'",
            'basic_is_charge'              => $this->smallInteger()->notNull(). " COMMENT '是否收费'",
            'basic_dbsxccs'              => $this->string()->notNull(). " COMMENT '到办事现场次数'",
            'basic_zxfs'              => $this->string()->notNull(). " COMMENT '咨询方式'",
            'basic_jdtsfs'              => $this->string()->notNull(). " COMMENT '监督投诉方式'",
            'basic_blsj'              => $this->string()->notNull(). " COMMENT '办理时间'",
            'basic_bldd'              => $this->string()->notNull(). " COMMENT '办理地点'",

            'process'              => $this->string()->notNull(). " COMMENT '办理流程'",
            'blclml'              => $this->text()->notNull(). " COMMENT '办理材料目录'",
            'sltj'              => $this->text()->notNull(). " COMMENT '受理条件'",
            'sfbz'              => $this->string()->notNull(). " COMMENT '收费标准'",
            'sdyj'              => $this->text()->notNull(). " COMMENT '设定依据'",
            'question'              => $this->text()->notNull(). " COMMENT '常见问题'",

            'is_online'              => $this->smallInteger()->notNull(). " COMMENT '是否在线办理'",

            'status'            => $this->smallInteger()->notNull()." COMMENT '状态'",

            'created_at'        => $this->integer()->unsigned(),
            'created_by'        => $this->integer()->unsigned(),
            'updated_at'        => $this->integer()->unsigned(),
            'updated_by'        => $this->integer()->unsigned(),
        ], $this->tableOptions. " COMMENT '项目审批表'");
    }



}
