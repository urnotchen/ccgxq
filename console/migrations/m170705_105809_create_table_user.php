<?php

use yii\db\Schema;
use yii\db\Migration;

class m170705_105809_create_table_user extends Migration
{

    public $tableName = 'user';
    public $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB comment "系统用户"';

    public function safeUp()
    {/*{{{*/
        $this->createTable($this->tableName, [

            'id'                   => 'int unsigned not null auto_increment primary key',
            'role_id'              => 'int unsigned comment "角色编号"',
            'username'             => 'string not null comment "用户名"',
            'email'                => 'string not null',

            'avatar'               => 'string not null comment "头像"',
            'real_name'            => 'string comment "真实名"',
            'qq'                   => 'string',
            'alipay'               => 'string comment "支付宝"',
            'mark'                 => 'string comment "标注"',

            'password'             => 'string not null',
            'auth_key'             => 'string not null',
            'password_reset_token' => 'string',

            'status'               => 'tinyint unsigned not null',

            'created_at'           => 'int unsigned not null',
            'created_by'           => 'int unsigned not null',
            'updated_at'           => 'int unsigned not null',
            'updated_by'           => 'int unsigned not null',

        ], $this->tableOptions);

        $this->createIndex('unique_user_username', $this->tableName, 'username', true);
        $this->createIndex('unique_user_email', $this->tableName, 'email', true);
        $user = <<<SQL
INSERT INTO `cmovie`.`user` (`id`, `role_id`, `username`, `email`, `avatar`, `real_name`, `qq`, `alipay`, `mark`, `password`, `auth_key`, `password_reset_token`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES ('1', NULL, 'chenxi', '3463292245@qq.com', 'http://ww3.sinaimg.cn/mw690/65bd3bd8jw1f4s5rp37k1j20280253yf.jpg', '陈曦', '3463292245', '22', 'languo', '', 'kChi9UGYeo-6KAVBbkVEEXiT2SzOOyrY', NULL, '1', '1465693079', '0', '1482990185', '0');
INSERT INTO `cmovie`.`user` (`id`, `role_id`, `username`, `email`, `avatar`, `real_name`, `qq`, `alipay`, `mark`, `password`, `auth_key`, `password_reset_token`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES ('2', NULL, 'moby', 'guu789@163.com', 'https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcSOUuRnFcejlasb15DsqbR664Y6sawzZZx0A25qLREUo-BqmgZqE-gFIZQ', '莫比', '', '', 'moby', '', 'LUm6VkYB3aosmQ99u_NERjCzNB-0zcnU', NULL, '1', '1499242418', '1', '1499242418', '1');
SQL;
        \Yii::$app->db->createCommand($user)->query();

    }/*}}}*/

    public function safeDown()
    {/*{{{*/
        $this->dropTable($this->tableName);
    }/*}}}*/

}
