<?php
	//Вход
	if(!isset($_COOKIE["logged"])){
	$page = "Вход";
	include("header.php");		
?>

<div class="form-wrap">
	<h1 class="login-title">Semester</h1>
	<form class="login_form" action="" method="POST">
		<div class="owl">
			<div class="eyes"></div>
			<div class="arm-up-right"></div>
			<div class="arm-up-left"></div>
			<div class="arm-down-left"></div>
			<div class="arm-down-right"></div>
		</div>
		<input type="text" class="login__field" name="login" placeholder="Логин" autocomplete="off" required>
		<input type="password" class="login__field login__pass" name="password" placeholder="Пароль" required>
		<div class="form-actions">
			<input type="submit" class="login__btn" value="Вход">
			<div class="login__error"></div>
		</div>
	</form>
	<div class="form-info">Для регистрации в веб-системе обратитесь к IT-инженеру.</div>
</div>

<?php }
	//Основная страница после входа
	else {
		if(isset($_COOKIE["admin"])) header("Location: admin.php");
		$curator = $_COOKIE["logged"];
		$page = "SEMESTER";
		include("header.php");
		$hasGroup = mysqli_query($con, "SELECT * FROM groups WHERE g_curator='$curator'");
		//Ввод группы в первый раз
		if(!isset($_COOKIE["admin"]) && mysqli_num_rows($hasGroup) == 0){
?>
			<div class="form-first">
				<h1 class="first-title">Введите номер вашей группы</h1>
				<input type="text" class="first-group" autocomplete="off" maxlength="3" autofocus>
				<input type="button" class="first-group-btn" value="Создать">
			</div>
<?php
		}
		else {
?>

<div class="side side-studs">
	<h2 class="side__title side__title_studs">Студенты</h2>
	<?php
		$curator = $_COOKIE["logged"];
		$group = $_COOKIE["group"];
		$getStuds = mysqli_query($con, "SELECT * FROM students WHERE s_group='$group' ORDER BY s_name ASC");
		if(mysqli_num_rows($getStuds) == 0) echo "Студентов пока нет.";
		else {
	?>
	<div class="side__tools">
		<div class="tools__btn sem-report">
			Успеваемость
			<div class="choose-sem">Выберите семестр:
			<a href="sem_report.php?sem=1">1</a>
			<a href="sem_report.php?sem=2">2</a>
			<a href="sem_report.php?sem=3">3</a>
			<a href="sem_report.php?sem=4">4</a>
			<a href="sem_report.php?sem=5">5</a>
			<a href="sem_report.php?sem=6">6</a>
			<a href="sem_report.php?sem=7">7</a>
			<a href="sem_report.php?sem=8">8</a></div>
		</div>
		<div class="tools__btn show-pupil">Показать отличников</div>
	</div>
	<table class="table table_left">
	<?php
			$k = 1;
			while($row = mysqli_fetch_array($getStuds)){
	?>
				<tr>
					<td><?php echo $k; ?></td>
					<td class="student_name"><?php echo $row["s_name"]; ?></td>
					<td><div class="edit-btn edit-stud"></div></td>
					<td class="student_id" data-stud="<?php echo $row['id']; ?>" data-grade="<?php echo $row["grade_11"]; ?>"><div class="edit-btn del-stud"></div></td>
				</tr>
	<?php
				$k++;
			}
		}
	?>
	</table>
	<div class="clear"></div>
	<a href="#new_student" class="popup-add"><div class="add-btn add-stud"></div></a>
	<div id="new_student" class="form mfp-hide popup-new-stud">
		<form id="add_stud" class="popup_form" action="">
			<h2 class="form__title">Новый студент</h2>
			<input type="text" class="form__input" name="new_stud" required autocomplete="off" spellcheck="false" placeholder="Введите ФИО студента">		
			<input class="input_hidden" id="grade_11" type="checkbox" name="grade_11">
			<label for="grade_11" class="form__chkbox"><span class="label__checkbox"></span>После 11-го класса</label>
			<input type="submit" class="form__btn form__btn_block" value="Добавить">
		</form>
	</div>
</div>


<div class="side side-subs">
	<h2 class="side__title side__title_subs"><span data-tab="tab_subs" class="tab__btn tab__btn_active">Предметы</span><span data-tab="tab_practice" class="tab__btn">Практика</span></h2>
	<div class="tab_subs tab_content tab_active">
	<?php
		$getSubs = mysqli_query($con, "SELECT * FROM subs_curators WHERE cur_id='$curator'");
		if(mysqli_num_rows($getSubs) == 0) echo "Предметов пока нет.";
		else {
	?>
	<table class="table table_right">
	<?php
			$k = 1;
			while($row = mysqli_fetch_array($getSubs)){
				$id = $row["sub_id"];
				$getName = mysqli_query($con, "SELECT * FROM subjects WHERE id='$id' ORDER BY sub_name ASC");
				$getName = mysqli_fetch_array($getName);
				$name = $getName["sub_name"];
	?>
				<tr>
					<td><?php echo $k; ?></td>
					<td class="sub_name"><?php echo $name; ?></td>
					<td class="sub_id" data-sub="<?php echo $id; ?>"><div class="edit-btn del-sub"></div></td>
				</tr>
	<?php
				$k++;
			}
		}
	?>
	</table>
	<div class="clear"></div>
	<a href="#new_subject" class="popup-add"><div class="add-btn add-sub"></div></a>
		<div id="new_subject" class="form mfp-hide popup-new-stud">		
			<form id="add_sub" class="popup_form" action="">
				<h2 class="form__title">Новый предмет</h2>
				<input type="text" class="form__input" name="new_sub" required autocomplete="off" spellcheck="false" placeholder="Введите название предмета">		
				<input type="submit" class="form__btn form__btn_block" value="Добавить">
			</form>
		</div>		
	</div>

	<div class="tab_practice tab_content">
		<?php
			$query = mysqli_query($con, "SELECT * FROM mods_curators WHERE cur_id='$curator'");
			if(mysqli_num_rows($query) != 0){
		?>
			<table class="table table_practice">
				<?php
					$k = 1;
					while($row = mysqli_fetch_array($query)){
						$mid = $row["m_id"];
						$module = mysqli_query($con, "SELECT * FROM modules WHERE id='$mid'");
						$module = mysqli_fetch_array($module);
				?>
						<tr>
							<td><?php echo $k; ?></td>
							<td class="m_name" data-mid="<?php echo $mid; ?>"><?php echo $module["m_name"]; $k++; ?></td>
							<td data-pr="<?php echo $row["m_id"]; ?>"><div class="edit-btn del-practice"></div></td>
						</tr>
				<?php } ?>
			</table>
		<?php } else { ?>
			<p style="text-align: center">Пусто.</p>
		<?php } ?>
		<div class="clear"></div>
		<a href="#new_practice" class="popup-add"><div class="add-btn add-practice"></div></a>
		<div id="new_practice" class="form mfp-hide popup-new-stud">		
			<form id="add_practice" class="popup_form" action="">
				<h2 class="form__title">Новый модуль</h2>
				<input type="text" class="form__input" name="new_practice" required autocomplete="off" spellcheck="false" placeholder="Введите название модуля">		
				<input type="submit" class="form__btn form__btn_block" value="Добавить">
			</form>
		</div>			
	</div>
	</div>	
</div>

<div class="marks-wrap">
	<div class="marks-form">
		<div class="marks-close"></div>
		<div class="marks-content"></div>
	</div>
</div>
<?php
		}
	}
	include("footer.php");
?>