<ul class="tabMenu">
	<?php foreach ($items as $item): ?>
		<?php echo CHtml::openTag('li', $item['htmlOptions']); ?>
			<?php echo Html::ajaxLink($item['a']['href'], $item['a']['htmlOptions']); ?>
				<?php if($item['icon']): ?>
					<?php echo Html::icon($item['icon']); ?>
				<?php endif; ?>
				<span><?php echo $item['label']; ?></span>
			<?php echo CHtml::closeTag('a'); ?>
		<?php echo CHtml::closeTag('li'); ?>

	<?php endforeach; ?>
</ul>
<div class="clear"></div>
