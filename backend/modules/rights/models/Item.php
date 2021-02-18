<?php

namespace backend\modules\rights\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\base\Exception;
use yii\base\UserException;
use yii\web\HttpException;

use yii\rbac\Item as BaseItem;
use yii\rbac\Role as BaseRole;

class Item extends \yii\base\Model
{

    public $name, $type, $description, $roles = [], $permissions = [];

    public $isNewRecord = true;

    private $_oldAttributes = [];

    public function rules()
    {/*{{{*/
        return [
            [['name'], 'required'],

            ['description', 'string'],
            ['name', 'string', 'max' => 64],

            [['roles', 'permissions'], 'each', 'rule' => ['string']],
        ];
    }/*}}}*/

    public function attributeLabels()
    {/*{{{*/
        return [
            'name'        => '名称',
            'description' => '描述',
            'roles'       => '拥有的角色',
            'permissions' => '拥有的权限',
        ];
    }/*}}}*/

    public function save($runValidation = true)
    {/*{{{*/
        if ($runValidation && ! $this->validate()) return false;

        $transaction = Yii::$app->db->beginTransaction();

        try {

            $auth = Yii::$app->authManager;

            /* role */

            $role = $auth->createRole($this->name);
            $role->type = $this->type;
            $role->description = $this->description;

            if (! $this->exists()) {
                $auth->add($role);
            } else {
                $auth->update($this->_oldAttributes['name'], $role);
                # 旧的不去，新的不来
                $auth->removeChildren($role);
            }

            /* child */

            if (!empty($this->roles)) {
                foreach ($this->roles as $i) {
                    # 避免 `我是我儿，我爹是我`
                    if ($i == $role->name) {
                        throw new UserException('self-swallowing set is not allowed.');
                    }
                    if (($oi = $auth->getRole($i))=== null) {
                        throw new HttpException(400, 'bad request, given role name does not exists.');
                    }
                    $auth->addChild($role, $oi);
                }
            }

            if (!empty($this->permissions)) {
                foreach ($this->permissions as $i) {
                    if (($oi = $auth->getPermission($i))=== null) {
                        throw new HttpException(400, 'bad request, given permission name does not exists.');
                    }
                    $auth->addChild($role, $oi);
                }
            }

            $transaction->commit();

            return true;

        } catch (Exception $e) {
            $transaction->rollback();
            throw $e;
        }

    }/*}}}*/

    public function loadFromRole(BaseRole $role)
    {/*{{{*/
        $this->name = $role->name;
        $this->type = $role->type;
        $this->description = $role->description;
        # todo load roles, and permissions
        $children = static::getChildren($this->name);
        unset($children['roles'][$this->name]);
        $this->roles = array_keys($children['roles']);
        $this->permissions = array_keys($children['permissions']);

        $this->isNewRecord = false;

        $this->_oldAttributes = $this->attributes;
    }/*}}}*/

    /**
     * @brief 获取单个角色
     *
     * @param $name
     *
     * @return \yii\rbac\Role | null
     */
    public static function getRole($name)
    {/*{{{*/
        return Yii::$app->authManager->getRole($name);
    }/*}}}*/

    /**
     * @brief 获取已有的所有角色
     *
     * @return [name => desc, ]
     */
    public static function getAllRoles(array $exclude = [])
    {/*{{{*/
        $roles = Yii::$app->authManager->getRoles();
        if (!empty($exclude)) {
            foreach ($exclude as $i) {
                unset($roles[$i]);
            }
        }
        return ArrayHelper::map($roles, 'name', 'description');
    }/*}}}*/

    /**
     * @brief 获取已有的所有权限
     *
     * @return [name => desc, ]
     */
    public static function getAllPermissions()
    {/*{{{*/
        return ArrayHelper::map(
            Yii::$app->authManager->getPermissions(),
            'name', 'description'
        );
    }/*}}}*/

    /**
     * @brief 获取给定item下的所有直接子类,并依据 typ 分离存储
     *
     * @param $name
     *
     * @return [roles => [name => desc,], permissions => [name => desc,]]
     */
    public static function getChildren($name)
    {/*{{{*/
        $children = Yii::$app->authManager->getChildren($name);

        $roles = [];
        $permissions = [];

        foreach ($children as $i) {
            switch ($i->type) {
            case BaseItem::TYPE_ROLE:
                $roles[$i->name] = $i->description;
                break;
            case BaseItem::TYPE_PERMISSION:
                $permissions[$i->name] = $i->description;
                break;
            default:
                # let it leak.
                break;
            }
        }

        return compact('roles', 'permissions');
    }/*}}}*/

    public static function delete(BaseRole $role)
    {/*{{{*/
        return Yii::$app->authManager->remove($role);
    }/*}}}*/

    public function exists()
    {/*{{{*/
        $item = Yii::$app->db
            ->createCommand('select * from auth_item where name=:name', [':name' => $this->name])
            ->queryOne();

        if (empty($item)) return false;

        $this->_oldAttributes = $item;

        return true;
    }/*}}}*/
}
