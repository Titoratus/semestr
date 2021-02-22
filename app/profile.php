<?php
	$page = "Настройки";
	if(!isset($_COOKIE["logged"])){ header("Location: index.php"); }
	include("header.php");

	$query = mysqli_query($con, "SELECT u_name FROM users WHERE id='$curator'");
	$query = mysqli_fetch_array($query);
	$fullname = explode(' ', $query["u_name"]);
?>
	<a href="index.php" class="home">На главную</a>
	<h1 class="set__title">Настройки</h1>
	<div class="container">
		<div class="row">
			<div class="col-10 offset-1">
				<form class="form_sets sets_edit_name">
					<label class="form__label">Имя
						<input class="form__input" name="set_name" type="text" value="<?php echo $fullname[1]; ?>" required autocomplete="off" spellcheck="false">
					</label>
					<label class="form__label">Фамилия
						<input class="form__input" name="set_surname" type="text" value="<?php echo $fullname[0]; ?>" required autocomplete="off" spellcheck="false">
					</label>
					<label class="form__label">Отчество
						<input class="form__input" name="set_father" type="text" value="<?php echo $fullname[2]; ?>" required autocomplete="off" spellcheck="false">
					</label>
					<input class="form__btn" type="submit" value="Изменить">							
				</form>
			</div>
		</div>

		<div class="row">
			<div class="col-10 offset-1">
				<form class="form_sets sets_edit_pass">
					<label class="form__label">Старый пароль
					<input class="form__input" name="set_oldpass" type="password" required>
					</label>
					<label class="form__label">Новый пароль
					<input class="form__input" name="set_newpass" minlength="6" type="password" required>
					</label>
					<label class="form__label">Повтор пароля
					<input class="form__input" name="set_repeat" type="password" required>
					</label>
					<input class="form__btn" type="submit" value="Изменить">
			</form>
			</div>
		</div>
	</div>

<?php include("footer.php"); ?>