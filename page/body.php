	<body>	
		<div class="wrap">
			<?php include './page/components/menu.php'; ?>
			
			<div style="clear:both;"></div>
			<div id="content">
				<?php echo $content; ?>
			</div>
		</div>
		<div class="wrap messages">
		    Здравствуйте, <?= isset($userData['login']) ? $userData['login'] : 'Гость! Авторизируйтесь или зарегестрируйтесь и авторизируйтесь пожалуйста'; ?>
		</div>
		<div class="wrap errors">
			 <?php
		        // Проверяем, есть ли ошибка в сессии
			        if (isset($_SESSION['error_message'])) {
			            echo $_SESSION['error_message'];
			     		// Удаляем ошибку из сессии, чтобы она не выводилась снова
		            	unset($_SESSION['error_message']);
			        }

					
				?>
		</div>
		<div class="wrap debug-zone">
			сессия: <?php var_dump($_SESSION)?><br/>
			<!-- сервер: <?php var_dump($_SERVER)?><br/> -->
			<?php loadZoneFile($user); ?>
		</div>

	

	
<!-- футер -->
