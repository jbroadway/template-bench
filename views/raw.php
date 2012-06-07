<h1><?php echo $data['title']; ?></h1>

<?php if ($data['show_people']): ?>
	<ul>
	<?php foreach ($data['people'] as $person): ?>
		<li><?php echo $person; ?></li>
	<?php endforeach; ?>
	</ul>
<?php endif; ?>
