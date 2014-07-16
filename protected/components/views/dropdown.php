<ul class="dropDown">
<?php foreach ($items as $key => $item): ?>
	<li>
		<?php if ($item['url']): ?>
			<?php echo CHtml::openTag('a', array('href' => $item['url'], 'class' => 'icon')); ?>
		<?php endif; ?>
		<?php if ($item['icon']): ?><img src="<?php echo Yii::app()->baseUrl . '/' . $item['icon'] ?>" alt="<?php echo $item['label'] ?>" title="" /><?php endif; ?>
		<span><?php echo $item['label']; ?><span>
		<?php if ($item['url']): ?>
			<?php echo CHtml::closetag('a'); ?>
		<?php endif; ?>
	</li>
<?php endforeach; ?>
</ul>
