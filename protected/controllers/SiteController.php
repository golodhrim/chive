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

class SiteController extends Controller
{
	public function __construct($id, $module = null)
	{
		$request = Yii::app()->getRequest();

		if ($request->isAjaxRequest) {
			$this->layout = false;
		}

		parent::__construct($id, $module);
	}

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * @see CController::accessRules()
	 */
	public function accessRules()
	{
		return array(
			array('allow',
				'actions' => array('login', 'changeLanguage', 'changeTheme'),
				'users' => array('*'),
			),
			array('deny',
				'users' => array('?'),
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
        if (Yii::app()->getUrlManager()->showScriptName) {
            $scriptUrl = basename($_SERVER['SCRIPT_NAME']);
            if (strpos($_SERVER['REQUEST_URI'], $scriptUrl) === false) {
                header("Location: index.php");
            }
        }

		// Ensure the user config file is always saved, even if no settings have been configured.
		Yii::app()->user->settings->saveSettings();

		$this->render('index', array());
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$this->layout = "login";

		$form = new LoginForm();
		// collect user input data
		$request = Yii::app()->getRequest();
		if ($request->isPostRequest) {
			$form->attributes = array(
				"host" => $request->getPost("host"),
				"port" => $request->getPost("port"),
				"username" => $request->getPost("username"),
				"password" => $request->getPost("password")
			);

			$form->redirectUrl = $request->getPost("redirectUrl");
			// validate user input and redirect to previous page if valid
			if ($form->validate()) {
				$redirectUrl = $request->getPost("redirectUrl");
				// $this->redirect() exits immediately
				if ($redirectUrl !== null && !StringUtil::endsWith($redirectUrl, "site/login")) {
					$this->redirect($redirectUrl);
				} else {
					$this->redirect(Yii::app()->homeUrl);
				}
			}
		}

		// Languages
        $languages = array();
        $files = opendir(Yii::app()->basePath . DIRECTORY_SEPARATOR . 'messages');
        while ($file = readdir($files)) {
            if (preg_match("/^\w\w(_\w\w)?$/", $file)) {
                $languages[] = array(
                    'label'			=> Yii::t('language', $file),
                    'icon'			=> 'images/language/' . $file . '.png',
                    'url'			=> Yii::app()->createUrl('/site/changeLanguage/' . $file),
                    'htmlOptions'	=> array('class' => 'icon'),
                );
            }
        }

		$availableThemes = Yii::app()->getThemeManager()->getThemeNames();
		$activeTheme = Yii::app()->getTheme()->getName();

		$themes = array();
		foreach ($availableThemes as $theme) {
			if ($activeTheme == $theme) {
				continue;
			}

			$themes[] = array(
				'label'			=> ucfirst($theme),
				'icon'			=> '/themes/' . $theme . '/images/icon.png',
				'url'			=> Yii::app()->request->baseUrl . '/site/changeTheme/' . $theme,
				'htmlOptions'	=> array('class' => 'icon'),
			);
		}

		$existingHosts = array();
		$userConfigPath = UserSettingsManager::getConfigPath();
		$hostFiles = glob($userConfigPath . "*.*.xml");
		$counter = 0;
		foreach ($hostFiles as $hostFile) {
			$settings = new SimpleXMLElement(file_get_contents($hostFile));
			$host = (string) $settings["host"];
			if (!isset($existingHosts[$host])) {
				$existingHosts[$host] = array();
			}
			$existingHosts[$host][$counter++] = array(
				"host"		=> (string) $settings["host"],
				"port"		=> (string) $settings["port"],
				"username"	=> (string) $settings["user"],
			);
		}

		$this->render('login', array(
			'form'			=> $form,
			'languages'		=> $languages,
			'existingHosts'	=> $existingHosts,
			'themes'		=> $themes,
		));
	}

	public function actionKeepAlive()
	{
		Yii::app()->end('OK');
	}

	/**
	 * Change the language
	 */
	public function actionChangeLanguage()
	{
		Yii::app()->session->add('language', Yii::app()->getRequest()->getParam('id'));
		$this->redirect(Yii::app()->createUrl('site/login'));
	}

	/**
	 * Change the theme
	 */
	public function actionChangeTheme()
	{
		Yii::app()->session->add('theme', $_GET['id']);
		$this->redirect(Yii::app()->homeUrl);
	}

	/**
	 * Logout the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	public function actionSearch()
	{
		$cmdBuilder = new CDbCommandBuilder(Yii::app()->db->getSchema());

		$criteria = new CDbCriteria;
		$criteria->condition = "TABLE_NAME LIKE :table OR TABLE_SCHEMA LIKE :schema";
		$criteria->params = array(
			":table" => "%" . Yii::app()->getRequest()->getParam('q') . "%",
			":schema" => "%" . Yii::app()->getRequest()->getParam('q') . "%"
		);
		$criteria->order = 'TABLE_SCHEMA, TABLE_NAME';

		$items = array();

		$lastSchemaName = '';
		foreach (Table::model()->findAll($criteria) as $table) {
			if ($table->TABLE_SCHEMA != $lastSchemaName) {
				$items[] = CJSON::encode(array(
					'text' => '<span class="icon schema">' . Html::icon('database') . '<span>' . StringUtil::cutText($table->TABLE_SCHEMA, 30) . '</span></span>',
					'target' => Yii::app()->createUrl('schema/' . $table->TABLE_SCHEMA),
					'plain' => $table->TABLE_SCHEMA,
				));
			}

			$lastSchemaName = $table->TABLE_SCHEMA;

			$items[] = CJSON::encode(array(
				'text' => '<span class="icon table">' . Html::icon('table') . '<span>' . StringUtil::cutText($table->TABLE_NAME, 30) . '</span></span>',
				'target' => Yii::app()->createUrl('schema/' . $table->TABLE_SCHEMA) . '#tables/' . $table->TABLE_NAME . '/browse',
				'plain' => $table->TABLE_NAME
			));
		}

		Yii::app()->end(implode("\n", $items));
	}
}
