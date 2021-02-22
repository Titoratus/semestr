<?php
	if(!isset($_COOKIE["admin"])) header("Location: index.php");	
	$page = "Администраторская";
	include("header.php");
?>

<div class="side side-curators">
	<h2 class="side__title side__title_studs">Кураторы</h2>
	<?php
		$curator = $_COOKIE["logged"];
		$getCurators = mysqli_query($con, "SELECT * FROM users WHERE admin='0'");
		if(mysqli_num_rows($getCurators) == 0) echo "Кураторов пока нет.";
		else {
	?>
	<table class="table table_left table_curators">
	<?php
			$k = 1;
			while($row = mysqli_fetch_array($getCurators)) {
	?>
				<tr>
					<td><?php echo $k; ?></td>
					<td><?php echo "<span class='cur_login'>".$row["login"]."</span>".$row["u_name"]; ?></td>
					<td data-curator="<?php echo $row["id"]; ?>"><div class="edit-btn del-curator"></div></td>
				</tr>
	<?php
				$k++;
			}
		}
	?>
	</table>
	<div class="clear"></div>
	<a href="#new_curator" class="popup-add"><div class="add-btn add-stud"></div></a>
	<div id="new_curator" class="form mfp-hide popup-new-stud">
		<form id="add_curator" class="popup_form" action="">
			<h2 class="form__title">Новый куратор</h2>
			<input type="text" class="form__input" name="new_curator" required autocomplete="off" spellcheck="false" placeholder="Введите ФИО куратора">		
			<input type="text" class="form__input" name="new_curator_login" required autocomplete="off" spellcheck="false" placeholder="Введите логин куратора">		
			<input type="text" class="form__input" name="new_curator_pass" required autocomplete="off" spellcheck="false" placeholder="Введите пароль куратора">		
			<label class="form__label form__label_block" for="cur_spec">Специальность</label>
			<select name="new_curator_spec" id="cur_spec" class="form__input" required>
				<option value="Преподавание в начальных классах">Преподавание в начальных классах</option>
				<option value="Дошкольное образование">Дошкольное образование</option>
				<option value="Изобразительное искусство и черчение" selected="">Изобразительное искусство и черчение</option>
				<option value="Физическая культура">Физическая культура</option>
				<option value="Прикладная информатика">Прикладная информатика</option>
				<option value="Социальная работа">Социальная работа</option>
			</select>
			<input type="submit" class="form__btn form__btn_block" value="Добавить">
		</form>
	</div>
</div>
<div class="side side-info">
	<h2 class="side__title side__title_subs">Информация</h2>
	<p class="side-info-text">Выберите куратора.</p>

	<div class="curator_info">
		<div class="container">
			<div class="row">
				<div class="col-3 offset-4">
					<form action="" id="new_cur_login" style="padding: 40px 0">
						<label for="new_login" class="form__label">
							<input type="text" class="form__input" id="new_login" name="new_login" autocomplete="off" placeholder="Введите новый логин" minlength="4" maxlength="20" required>
							<input type="submit" class="form__btn" value="Изменить">
						</label>
					</form>
				</div>
			</div>
			<div class="row">
				<div class="col-3 offset-4">
					<form action="" id="new_cur_pass" style="padding-bottom: 40px">
						<label for="new_pass" class="form__label">
							<input type="text" class="form__input" id="new_pass" autocomplete="off" name="new_pass" placeholder="Введите новый пароль" minlength="6" maxlength="25" required>
							<input type="submit" class="form__btn" value="Изменить">
						</label>
					</form>					
				</div>
			</div>
		</div>
	</div>
</div>
<?php include("footer.php"); ?>