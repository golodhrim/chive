<div id="languageDialog" title="<?php echo Yii::t('core', 'chooseLanguage'); ?>">
	<table style="width: 100%">
		<tr>
		<?php if (count($languages) > 0): ?>
			<td style="width: 50%; vertical-align: top">
				<?php $i = 0; ?>
				<?php $languageCount = count($languages); ?>
				<?php foreach ($languages as $language): ?>
					<a href="<?php echo $language['url']; ?>" class="icon" style="display: block; margin-bottom: 3px">
						<img class="icon icon16" src="<?php echo BASEURL . '/' . $language['icon']; ?>" alt="<?php echo $language['label']; ?>" />
						<span><?php echo $language['label']; ?></span>
					</a>
					<?php $i++; ?>
					<?php if ($i == ceil($languageCount / 2)): ?>
						</td>
						<td style="width: 50%; vertical-align: top">
					<?php endif; ?>
				<?php endforeach; ?>
			</td>
		<?php else: ?>
			<td>
				<?php echo Yii::t('core', 'noOtherLanguagesAvailable'); ?>
			</td>
		<?php endif; ?>
		</tr>
	</table>
</div>

<div id="themeDialog" title="<?php echo Yii::t('core', 'chooseTheme'); ?>">
	<table style="width: 100%">
		<tr>
		<?php if (count($themes) > 0): ?>
			<?php $i = 0; ?>
			<?php $themeCount = count($themes); ?>
			<?php foreach ($themes as $theme): ?>

				<td style="width: 150px; vertical-align: top">
					<a href="<?php echo $theme['url']; ?>" class="icon">
						<img class="icon icon16" src="<?php echo BASEURL . '/' . $theme['icon']; ?>" alt="<?php echo $theme['label']; ?>" />
						<span><?php echo $theme['label']; ?></span>
					</a>
				</td>

				<?php $i++; ?>
				<?php if ($i % 3 == 0 && $themeCount > $i): ?>
					</tr><tr>
				<?php endif; ?>

			<?php endforeach; ?>
		<?php else: ?>
			<td>
				<?php echo Yii::t('core', 'noOtherThemesAvailable'); ?>
			</td>
		<?php endif; ?>
		</tr>
	</table>
</div>

<div id="login">
	<div id="login-logo">
		<img src="<?php echo BASEURL; ?>/images/logo-big.png" alt="chive" title="" />
	</div>

	<?php echo CHtml::errorSummary($form, '', ''); ?>

	<div id="login-form">
		<?php echo CHtml::form(); ?>
		<?php echo CHtml::activeHiddenField($form, "redirectUrl", array("name" => "redirectUrl", "id" => "redirectUrl")); ?>
		<div class="formItems non-floated" style="text-align: left;">
			<div class="item row1">
				<div class="left">
					<span class="icon">
						<?php echo CHtml::activeLabel($form, 'host'); ?>
					</span>
				</div>
				<div class="right">
					<?php echo CHtml::activeTextField($form, 'host', array('class' => 'text', 'name' => 'host')); ?>
				</div>
			</div>
			<div class="item row2">
				<div class="left">
					<span class="icon">
						<?php echo CHtml::activeLabel($form, 'port'); ?>
					</span>
				</div>
				<div class="right">
					<?php echo CHtml::activeTextField($form, 'port', array('class' => 'text', 'name' => 'port')); ?>
				</div>
			</div>
			<div class="item row1">
				<div class="left" style="float: none;">
					<span class="icon">
						<?php echo CHtml::activeLabel($form, 'username'); ?>
					</span>
				</div>
				<div class="right">
					<?php echo CHtml::activeTextField($form, 'username', array('class' => 'text', 'name' => 'username')) ?>
				</div>
			</div>
			<div class="item row2">
				<div class="left">
					<span class="icon">
						<?php echo CHtml::activeLabel($form, 'password'); ?>
					</span>
				</div>
				<div class="right">
					<?php echo CHtml::activePasswordField($form, 'password', array('class' => 'text', 'value' => '', 'name' => 'password', 'autocomplete' => "off")); ?>
				</div>
			</div>
		</div>

		<div class="buttons">
			<?php echo CHtml::submitButton(Yii::t('core', 'login')); ?>
		</div>

		<?php echo CHtml::closeTag('form'); ?>
	</div>
</div>

<script type="text/javascript">
$(function() {
	$('#LoginForm_username').focus();

	if ($('#redirectUrl').val() == "") {
		$('#redirectUrl').val(location.href);
	}
});
</script>
