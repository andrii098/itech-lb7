<?php
	require 'conn.php';
?>


<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Библиотека</title>
	<link rel="stylesheet" href="style.css">
	<script type="text/javascript" src="index.js" defer></script>
</head>
<body>
	<h1>Библиотека</h1>
	<p>
		<label for="publisher">
			Книги издательства:
		</label>
		<select name="publ" id="publisher">
			<?php
				$stm = "SELECT DISTINCT publisher FROM `literature`
							WHERE type LIKE 'Book';";
                foreach ($pdo->query($stm) as $row) {
                    $publ = $row['publisher'];
                    echo "<option>"
                        . $publ 
                    	. "</option>";
                }
			?>
		</select>
		<button id="btnShow1">Показать</button>

	<div id="tbl_1">
		<p><button id="btnHide1">Скрыть</button><p>
	<table border="1">
		<thead>
			<th>Название</th>
			<th>Год выпуска</th>
			<th>Количество</th>
			<th>ISBN</th>
			<th>Автор</th>
			<th>Приложение</th>			
		</thead>
		<tbody id="tBodyPubl">
		</tbody>
	</table>
	</div>
	</p>
	
	<p>
		Вся литература за период с 
		<input type="date" id="from">
		<label for="to">по</label>
		<input type="date" id="to">
		<button id="btnShow2">Показать</button>
	
	<div id="tbl_2">
		<p><button id="btnHide2">Скрыть</button><p>
	<table border="1">
		<thead>
			<th>Название</th>
			<th>Год выпуска</th>
			<th>Количество</th>
			<th>ISBN</th>
			<th>Автор</th>
			<th>Приложение</th>			
		</thead>
		<tbody id="tBodyPeriod">
		</tbody>
	</table>
	</div>
	</p>

	<p>
		Книги автора 
		<select id="auth_id">
			<?php
				$stm = "
SELECT id, name FROM authors;";
				foreach ($pdo->query($stm) as $row) {
					echo "<option value='"
						. $row['id'] . "'>"
						. $row['name'] 
						. "</option>";
				}
			?>
		</select>
		<button id="btnShow3">Показать</button>

		<div id="tbl_3">
			<p><button id="btnHide3">Скрыть</button></p>
			<table border="1" id="tblAuth">
				<thead>
					<th>Название</th>
					<th>Год выпуска</th>
					<th>Количество</th>
					<th>ISBN</th>
					<th>Приложение</th>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</p>
</body>
</html>