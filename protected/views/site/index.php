<h2><?php echo Yii::t('core', 'Welcome'); ?>, <?php echo Yii::app()->user->name; ?>!</h2>

<table class="list" style="width: 550px;">
	<colgroup>
		<col style="width: 200px;"></col>
		<col></col>
	</colgroup>
	<thead>
		<tr>
			<th colspan="2"><?php echo Yii::t('core', 'serverInformation'); ?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?php echo Yii::t('core', 'host'); ?></td>
			<td><?php echo Yii::app()->user->host; ?></td>
		</tr>
		<tr>
			<td><?php echo Yii::t('core', 'mysqlServerVersion'); ?></td>
			<td><?php echo Yii::app()->db->getServerVersion(); ?></td>
		</tr>
		<tr>
			<td><?php echo Yii::t('core', 'mysqlClientVersion'); ?></td>
			<td><?php echo Yii::app()->db->getClientVersion(); ?></td>
		</tr>
		<tr>
			<td><?php echo Yii::t('core', 'user'); ?></td>
			<td><?php echo Yii::app()->user->name; ?>@<?php echo Yii::app()->user->host; ?></td>
		</tr>
		<tr>
			<td><?php echo Yii::t('core', 'webserver'); ?></td>
			<td><?php echo $_SERVER['SERVER_SOFTWARE']; ?></td>
		</tr>
		<tr>
			<td><?php echo Yii::t('core', 'chiveVersion'); ?></td>
			<td><?php echo Yii::app()->params->version; ?></td>
		</tr>
	</tbody>
</table>

<br/><br/>

<h3><?php echo Yii::t('core', 'Useful Links'); ?></h3>
<ul>
    <li>
        <?php echo Html::ajaxLink('information/processes', array('class' => 'icon')); ?>
            <?php echo Html::icon('process'); ?>
            <span><?php echo Yii::t('core', 'processes'); ?></span>
        </a>
    </li>
</ul>
