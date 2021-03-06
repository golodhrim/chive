<?php
/**
 * Chive - web based MySQL database management
 * Copyright (C) 2010 Fusonic GmbH
 *
 * This file is part of Chive.
 *
 * Chive is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or (at your option) any later version.
 *
 * Chive is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * General Public License for more details.
 *
 * You should have received a copy of the GNU General Public
 * License along with this library. If not, see <http://www.gnu.org/licenses/>.
 */

class SchemaPrivilege extends CActiveRecord
{
    public static $db;

    /**
     * @see CActiveRecord::model()
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @see CActiveRecord::getDbConnection()
     */
    public function getDbConnection()
    {
        return self::$db;
    }

    /**
     * @see CActiveRecord::tableName()
     */
    public function tableName()
    {
        return 'db';
    }

    /**
     * @see CActiveRecord::primaryKey()
     */
    public function primaryKey() {
        return array(
            'Host',
            'Db',
            'User',
        );
    }

    /**
     * @see CActiveRecord::rules()
     */
    public function rules()
    {
        return array(
            array('Host', 'type', 'type' => 'string'),
            array('User', 'type', 'type' => 'string'),
            array('Db', 'type', 'type' => 'string'),
            array('Privileges', 'type', 'type' => 'string'),
        );
    }

    /**
     * @see CActiveRecord::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'Db' => Yii::t('core', 'schema'),
        );
    }

    private function getPrivilegeColumn($priv)
    {
        switch($priv)
        {
            case 'CREATE TEMPORARY TABLES':
                return 'Create_tmp_table_priv';
            default:
                return ucfirst(strtolower(str_replace(' ', '_', $priv))) . '_priv';
        }
    }

    public function checkPrivilege($priv)
    {
        return $this->attributes[$this->getPrivilegeColumn($priv)] == 'Y';
    }

    /**
     * Returns an array containing all privileges of the user.
     *
     * @param $group
     * @return array privileges
     */
    public function getPrivileges($group = null)
    {
        $res = array();

        $privs = array_keys(self::getAllPrivileges($group));

        foreach ($privs as $priv) {
            if ($this->checkPrivilege($priv)) {
                $res[] = $priv;
            }
        }

        if (count($res) == count($privs)) {
            return array(
                'ALL PRIVILEGES',
            );
        } else {
            return $res;
        }
    }

    public function setPrivileges($data)
    {
        // Set all privileges to No
        foreach (array_keys(self::getAllPrivileges()) as $priv) {
            $this->{$this->getPrivilegeColumn($priv)} = 'N';
        }

        // Set given privileges to Yes
        foreach (array_keys($data) as $priv) {
            $this->{$this->getPrivilegeColumn($priv)} = 'Y';
        }
    }

    public static function getAllPrivileges($group = null)
    {
        $privs = array(
            'data' => array(
                'SELECT' => null,
                'INSERT' => null,
                'UPDATE' => null,
                'DELETE' => null,
            ),
            'structure' => array(
                'CREATE' => null,
                'ALTER' => null,
                'INDEX' => null,
                'DROP' => null,
                'CREATE TEMPORARY TABLES' => null,
                'SHOW VIEW' => null,
                'CREATE ROUTINE' => null,
                'ALTER ROUTINE' => null,
                'EXECUTE' => null,
                'CREATE VIEW' => null,
            ),
            'administration' => array(
                'GRANT' => null,
                'LOCK TABLES' => null,
                'REFERENCES' => null,
            ),
        );

        if ($group) {
            return $privs[$group];
        } else {
            return array_merge($privs['data'], $privs['structure'], $privs['administration']);
        }
    }
}
