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

class UserSettingsManager
{
    protected $configPath;
    protected $host, $user, $port;
    protected $defaultSettings = array();
    protected $userSettings = array();

    public function __construct($host, $user, $port)
    {
        $this->host = $host;
        $this->user = $user;
        $this->port = $port;

        // Get config path
        $this->configPath = self::getConfigPath();

        // Load settings
        $this->loadSettings();
    }

    /**
     * @return string
     */
    public static function getConfigPath()
    {
        return Yii::app()->getRuntimePath() . DIRECTORY_SEPARATOR . 'user-config' . DIRECTORY_SEPARATOR;
    }

    /**
     * Creates JavaScript representation of settings.
     * @todo (mburtscher): Support arrays.
     * @return	string
     */
    public function getJsObject()
    {
        $jsSettings = 'var userSettings = {};' . "\n";
        foreach ($this->defaultSettings as $key => $value) {
            $value = $value[null];
            if (is_array($value)) {
                continue;
            }
            if (isset($this->userSettings[$key])) {
                foreach ($this->userSettings[$key] as $key2 => $value2) {
                    if (is_array($value2)) {
                        continue;
                    }
                    if (!$key2) {
                        $value = $value2;
                    } else {
                        $jsSettings .= 'userSettings.' . $key . '__' . str_replace('.', '_', $key2) . ' = "' . str_replace('"', '\"', $value2) . '";' . "\n";
                    }
                }
            }
            $jsSettings .= 'userSettings.' . $key . ' = "' . str_replace('"', '\"', $value) . '";' . "\n";
        }
        return $jsSettings;
    }

    public function get($name, $scope = null, $object = null, $attribute = null, $value = null)
    {
        $id = $this->getSettingId($name, $scope);

        if (isset($this->userSettings[$id])) {
            if (isset($this->userSettings[$id][$object])) {
                if ($attribute && $value) {
                    return self::findByAttributeValue($this->userSettings[$id][$object], $attribute, $value);
                } else {
                    return $this->userSettings[$id][$object];
                }
            } elseif (isset($this->userSettings[$id][null])) {
                if ($attribute && $value) {
                    return self::findByAttributeValue($this->userSettings[$id][null], $attribute, $value);
                } else {
                    return $this->userSettings[$id][null];
                }
            }
        } elseif (isset($this->defaultSettings[$id])) {
            if ($attribute && $value) {
                return self::findByAttributeValue($this->defaultSettings[$id][null], $attribute, $value);
            } else {
                return $this->defaultSettings[$id][null];
            }
        } else {
            throw new CException(Yii::t('core','The setting {setting} does not exist.',
                array('{setting}' => $id)));
        }
    }

    public function set($name, $value, $scope = null, $object = null)
    {
        $id = $this->getSettingId($name, $scope);
        if (isset($this->defaultSettings[$id])) {
            $this->userSettings[$id][$object] = $value;
        } else {
            throw new CException(Yii::t('core', 'The setting {setting} does not exist.',
                array('{setting}' => $id)));
        }
    }

    protected function loadSettings()
    {
        // Load settings
        $this->defaultSettings = $this->loadSettingsFile($this->configPath . 'default.xml');
        $userSettingsFilename = $this->configPath . $this->host . "." . $this->user . ".xml";
        if (is_readable($userSettingsFilename)) {
            $this->userSettings = $this->loadSettingsFile($userSettingsFilename);
        }
    }

    /**
     * @param string $filename
     * @return array
     */
    public function loadSettingsFile($filename)
    {
        $defaultXml = new SimpleXMLElement(file_get_contents($filename));
        $settings = array();
        foreach ($defaultXml->children() as $setting) {
            $name = $setting->getName();
            if (isset($setting['serialized'])) {
                $value = unserialize((string) $setting);
            } else {
                $value = (string) $setting;
            }
            $scope = (isset($setting['scope']) ? (string) $setting['scope'] : null);
            $object = (isset($setting['object']) ? (string) $setting['object'] : null);

            $id = $this->getSettingId($name, $scope);

            $settings[$id][$object] = $value;
        }
        return $settings;
    }

    public function saveSettings()
    {
        $xml = new SimpleXmlElement('<settings host="' . $this->host . '" user="' . $this->user . '" port="' . $this->port . '" />');
        foreach ($this->userSettings as $key => $values) {
            list($name, $scope) = $this->getSettingNameScope($key);
            foreach ($values as $object => $value) {
                if (is_array($value)) {
                    $value = serialize($value);
                    $setSerialized = true;
                } else {
                    $setSerialized = false;
                }
                $settingXml = $xml->addChild($name, $value);
                if ($setSerialized) {
                    $settingXml['serialized'] = true;
                }
                if ($scope) {
                    $settingXml['scope'] = $scope;
                }
                if ($object) {
                    $settingXml['object'] = $object;
                }
            }
        }
        $xml->asXML($this->configPath . $this->host . '.' . $this->user . '.xml');
    }

    /**
     * @param string $name
     * @param string $scope
     * @return string
     */
    protected function getSettingId($name, $scope)
    {
        return $name . ($scope ? '__' . str_replace(".", "_", $scope) : '');
    }

    /**
     * @param string
     * @return array
     */
    protected function getSettingNameScope($id)
    {
        $return = explode('__', $id);
        if (is_array($return)) {
            if (isset($return[1])) {
                $return[1] = str_replace("_", ".", $return[1]);
            } else {
                $return[1] = null;
            }
            return $return;
        } else {
            return array($return, null);
        }
    }

    protected function findByAttributeValue($array, $attribute, $value)
    {
        $array = CPropertyValue::ensureArray($array);

        foreach ($array as $key => $entry) {
            if ($entry[$attribute] == $value) {
                return $entry;
            }
        }

        return false;
    }
}
