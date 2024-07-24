<?php
$result = toggleStyle();
$style_link = $result['style_link'];
$style_param = $result['style_param'];
?>

<div id="menu">
	<div class="menu">
		<ul>
			<li><a href="<?php echo EPP_HOST; ?>">Главная</a></li>
			<li>
		  		<?php if(isset($_SESSION['user'])){ ?>
					<a href="<?php echo EPP_HOST; ?>?mode=auth&exit=true">Выйти</a>
				<?php } else { ?>
					<a href="<?php echo EPP_HOST; ?>?mode=auth">Войти</a>
				<?php } ?>

			</li>
			<li><a href="<?php echo $style_link; ?>"><?php echo ucfirst($style_param); ?></a></li>
		</ul>
	</div>
</div>