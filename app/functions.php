<?php
	include("db.php");

	//Вход
	if(isset($_POST["login"])){
		$login = $_POST["login"];
		$pass = $_POST["password"];
		$query = mysqli_query($con, "SELECT * FROM users WHERE login='$login'");
		$user = mysqli_fetch_array($query);
		include("password.php");
		$hash = $user["pass"];

		if(password_verify($pass, $hash)){
			//В куки будет хранится ID куратора
			$uid = $user["id"];
			setcookie("logged", "$uid", time() + 3600);

			if($user["admin"] == 1) setcookie("admin", "1", time() + 3600);
			else {
				$group = mysqli_query($con, "SELECT * FROM groups WHERE g_curator='$uid'");
				$group = mysqli_fetch_array($group);
				$group = $group["g_name"];
				setcookie("group", "$group", time() + 3600);
			}
		}
		else echo "error";
	}

	//Ввод группы в первый раз
	if(isset($_POST["create_group"])){
		$group = $_POST["create_group"];
		$id = $_COOKIE["logged"];
		$query = mysqli_query($con, "INSERT INTO groups (`g_name`, `g_curator`) VALUES ('$group', '$id')") or die("error");
	}

	//Новый студент
	if(isset($_POST["new_stud"])){
		$stud = ucwords($_POST["new_stud"]);
		$grade = isset($_POST["grade_11"]) ? "1" : "0";
		$group = $_COOKIE["group"];
		$query = mysqli_query($con, "INSERT INTO students (`id`, `s_name`, `s_group`, `grade_11`) VALUES (NULL, '$stud', '$group', '$grade')") or die(mysqli_error($con));
	}

	//Новый модуль практики
	if(isset($_POST["new_practice"])){
		$pr = $_POST["new_practice"];
		$cur_id = $_COOKIE["logged"];
		$query = mysqli_query($con, "INSERT INTO modules (`id`, `m_name`) VALUES (NULL, '$pr')") or die(mysqli_error($con));
		if($query) {
			$getId = mysqli_query($con, "SELECT * FROM modules WHERE m_name='$pr'");
			$getId = mysqli_fetch_array($getId);
			$id = $getId["id"];			
		}
		$query = mysqli_query($con, "INSERT INTO mods_curators (`m_id`, `cur_id`) VALUES ('$id', '$cur_id')") or die(mysqli_error($con));
	}	

	//Удаление студента
	if(isset($_POST["del_stud"])){
		$stud = $_POST["del_stud"];
		$query = mysqli_query($con, "DELETE FROM students WHERE id='$stud'") or die("Не удалось удалить студента!");
	}

	//Удаление модуля
	if(isset($_POST["del_practice"])){
		$pr = $_POST["del_practice"];
		$query = mysqli_query($con, "DELETE FROM modules WHERE id='$pr'") or die("Не удалось удалить модуль!");
	}

	//Удаление куратора
	if(isset($_POST["del_curator"])){
		$cur = $_POST["del_curator"];
		$query = mysqli_query($con, "DELETE FROM users WHERE id='$cur'") or die("Не удалось удалить куратора!");
	}	

	//Удаление предмета
	if(isset($_POST["del_sub"])){
		$sub = $_POST["del_sub"];
		$cur = $_COOKIE["logged"];
		$query = mysqli_query($con, "DELETE FROM subs_curators WHERE cur_id='$cur' AND sub_id='$sub'") or die("Не удалось удалить предмет!");
	}

	//Новый предмет
	if(isset($_POST["new_sub"])){
		$sub = $_POST["new_sub"];
		$group = $_COOKIE["group"];
		$query = mysqli_query($con, "INSERT INTO subjects (`id`, `sub_name`) VALUES (NULL, '$sub')") or die(mysqli_error($con));
		if($query){
			$getId = mysqli_query($con, "SELECT * FROM subjects WHERE sub_name='$sub'");
			$getId = mysqli_fetch_array($getId);
			$id = $getId["id"];
		}
		$cur = $_COOKIE["logged"];
		$query = mysqli_query($con, "INSERT INTO subs_curators (`sub_id`, `cur_id`) VALUES ($id, '$cur')") or die(mysqli_error($con));
	}

	//Отметка семестровых оценок
	if(isset($_POST["show_stud"])){
		$stud_id = $_POST["show_stud"];
		$stud_name = $_POST["stud_name"];
	?>
		<h2 class="marks__title" data-stud="<?php echo $stud_id; ?>"><span><?php echo $stud_name; ?><a href="make_report.php?sid=<?php echo $stud_id; ?>"><div class="print_stud"></div></a></span></h2>
		<div class="tab_stud">
			<button data-tab="tab_subs" class="tab__btn tab__btn_active">Предметы</button> /
			<button data-tab="tab_vkr" class="tab__btn">КР ВКР</button> /
			<button data-tab="tab_practice" class="tab__btn">Практика</button>
		</div>

		<div class="tab_subs tab_content tab_active">
	<?php
		if($_POST["sub_exist"] == 0) die("Предметов пока нет.");
	?>
		<table class="marks__table">
			<tr>
				<td rowspan="2" style="text-align: center">Предметы</td>
				<td colspan="<?php echo $_POST["grade_11"] == 0 ? "8" : "6" ?>">Семестры</td>
				<td rowspan="2">Диплом</td>
			</tr>
			<tr>
				<td style="text-align: center;">1</td>
				<td>2</td>
				<td>3</td>
				<td>4</td>
				<td>5</td>
				<td>6</td>
				<?php
					//Если после 9-го класса, то на 2 семестра больше
					if($_POST["grade_11"] == 0){
				?>				
					<td>7</td>
					<td>8</td>
				<?php } ?>
			</tr>
		<?php
			$curator = $_COOKIE["logged"];
			$query = mysqli_query($con, "SELECT * FROM subs_curators WHERE cur_id='$curator'");
			while($row = mysqli_fetch_array($query)){
				$sub_id= $row["sub_id"];
		?>
			<tr>
				<td class="sub" data-subid="<?php echo $sub_id; ?>"><?php $getName = mysqli_query($con, "SELECT * FROM subjects WHERE id='$sub_id'"); $getName = mysqli_fetch_array($getName); echo $getName["sub_name"]; ?></td>
				<?php $mark = mysqli_query($con, "SELECT * FROM marks WHERE sub_id='$sub_id' AND s_id='$stud_id'"); $mark = mysqli_fetch_array($mark);
					for($i=1; $i<=6; $i++){
				?>
						<td><input type="text" class="marks__mark <?php $s = 's'.$i; echo $mark[$s] > 0 ? "mark_".$mark[$s] : ""; ?>" value="<?php echo $mark[$s] > 0 ? $mark[$s] : ""; ?>"></td>
				<?php
					}
					//Если после 9-го класса, то на 2 семестра больше
					if($_POST["grade_11"] == 0){
				?>
				<td><input type="text" class="marks__mark <?php echo $mark['s7'] > 0 ? "mark_".$mark['s7'] : ""; ?>" value="<?php echo $mark['s7'] > 0 ? $mark['s7'] : ""; ?>"></td>
				<td><input type="text" class="marks__mark <?php echo $mark['s8'] > 0 ? "mark_".$mark['s8'] : ""; ?>" value="<?php echo $mark['s8'] > 0 ? $mark['s8'] : ""; ?>"></td>				
				<?php
					}
				?>
				<td><input type="text" class="marks__mark <?php echo "mark_".$mark["diploma"]; ?>" name="diploma" <?php echo $mark["diploma"] > 0 ? "value=".$mark["diploma"] : ""; ?>></td>
		<?php
			}
		?>
			</tr>	
		</table>
		</div>

		<div class="tab_practice tab_content">
		<?php
			$query = mysqli_query($con, "SELECT * FROM mods_curators WHERE cur_id='$curator'");
			if(mysqli_num_rows($query) != 0){
		?>
			<table class="marks__table">
				<tr>
					<td rowspan="2" style="text-align: center;">Наименование</td>
					<td colspan="8">Семестры</td>
				</tr>
				<tr>
					<td>1</td>
					<td>2</td>
					<td>3</td>
					<td>4</td>
					<td>5</td>
					<td>6</td>
					<td>7</td>
					<td>8</td>
				</tr>
				<?php
					$k = 1;
					while($row = mysqli_fetch_array($query)){
						$mid = $row["m_id"];
						$module = mysqli_query($con, "SELECT * FROM modules WHERE id='$mid'");
						$module = mysqli_fetch_array($module);
				?>
						<tr>
							<td class="m_name" data-mid="<?php echo $mid; ?>"><?php echo $module["m_name"]; $k++; ?></td>
							<?php $marks = mysqli_query($con, "SELECT * FROM mods_marks WHERE m_id='$mid' AND stud_id='$stud_id'");
										$marks = mysqli_fetch_array($marks);

								for($p = 1; $p <= 8; $p++) { ?>
								<td><input type="text" class="m_marks__mark <?php echo "mark_".$marks["s".$p]; ?>" maxlength="1" value="<?php echo $marks["s".$p] != 0 ? $marks["s".$p] : ""; ?>"></td>
							<?php } ?>
						</tr>
				<?php } } ?>
			</table>			
		</div>

		<div class="tab_content tab_vkr">
			<div class="work_wrap">
				<h4 class="work_name">Курсовые</h4>
				<?php
					//Курсовые
					$query = mysqli_query($con, "SELECT * FROM works WHERE w_student = '$stud_id'");
					if(mysqli_num_rows($query) == 0) echo "<p>Пусто.</p>";
					else {
				?>
				<table class="works_table marks__table">
					<tr rowspan="2">
						<td>Название</td>
						<td>Оценка</td>
					</tr>
					<tr></tr>
					<?php
						while($row = mysqli_fetch_array($query)){
					?>
						<tr>
							<td><?php echo $row["w_name"]; ?></td>
							<td><?php echo $row["w_mark"]; ?><div class="w_del" data-wid="<?php echo $row["id"]; ?>"></div></td>
						</tr>
					<?php
						}
					}
					?>
				</table>
				
				<?php if(mysqli_num_rows($query) == 0){ ?>
				<button class="add_work">Добавить</button>

				<div class="add_tools">
					<form class="new_work new_adding">
						<label class="w_label" for="w_name">
							Название:
							<input id="w_name" class="w_input" name="w_name" type="text" required></label>
						<label class="w_label" for="w_mark">
							Оценка:
							<input id="w_mark" class="w_input" name="w_mark" type="text" pattern= "[0-9]" title="Только цифры!" maxlength="1" required>
						</label>
						<input type="submit" class="w_submit" value="">
					</form>
				</div>
				<?php } ?>
			</div>

			<div class="work_wrap">
				<h4 class="work_name">Приказы</h4>
			<?php
					//Приказы
					$query = mysqli_query($con, "SELECT * FROM orders WHERE o_student = '$stud_id'");
					if(mysqli_num_rows($query) == 0) echo "<p>Пусто.</p>";
					else {
				?>
				<table class="marks__table">
					<tr rowspan="2">
						<td>Название</td>
						<td>Дата</td>
					</tr>
					<tr></tr>
					<?php
						while($row = mysqli_fetch_array($query)){
					?>
						<tr>
							<td><?php echo $row["o_name"]; ?></td>
							<td><?php echo date('d.m.Y', strtotime($row["o_date"])); ?><div class="o_del" data-oid="<?php echo $row["id"]; ?>"></div></td>
						</tr>
					<?php
						}
					}
					?>
				</table>
				<button class="add_work">Добавить</button>

				<div class="add_tools">
					<form class="new_order new_adding">
						<label class="w_label" for="o_name">
							Название:
							<input id="o_name" class="w_input" name="o_name" type="text" required></label>
						<label class="w_label" for="o_date">
							Дата:
							<input id="o_date" class="w_input" name="o_date" type="date" required>
						</label>
						<input type="submit" class="w_submit" value="">
					</form>
				</div>
				</div>

			<div class="work_wrap">
			
				<h4 class="work_name">Дипломная</h4>
			<?php
				//Диплом
				$query = mysqli_query($con, "SELECT * FROM diploma WHERE d_student = '$stud_id'");
				if(mysqli_num_rows($query) == 0) echo "<p>Пусто.</p>";
				else {
			?>
			<table class="marks__table">
				<tr rowspan="2">
					<td>Название</td>
					<td>Оценка</td>
				</tr>
				<tr></tr>
				<?php
					while($row = mysqli_fetch_array($query)){
				?>
					<tr>
						<td>Дипломная работа</td>
						<td><?php echo $row["d_mark"]; ?><div class="d_del" data-did="<?php echo $row["id"]; ?>"></div></td>
					</tr>
				<?php
					}
				}
				?>
			</table>

			<?php if(mysqli_num_rows($query) == 0){ ?>
			<button class="add_work">Добавить</button>

			<div class="add_tools">
				<form class="new_diploma new_adding">
					<label class="w_label" for="d_name">
						<input id="o_name" class="w_input" name="d_name" type="text" value="Дипломная работа" disabled></label>
					<label class="w_label" for="d_mark">
						Оценка:
						<input id="o_date" class="w_input" name="d_mark" pattern= "[0-9]" title="Только цифры!" maxlength="1" type="text" required>
					</label>
					<input type="submit" class="w_submit" value="">
				</form>
			</div>			
		<?php } ?>
				
			</div>
		</div>

	<?php
	}

	//Вывод модулей практики
	if(isset($_POST["show_pr"])){
		$m_id = $_POST["show_pr"];
		$name = $_POST["m_name"];
		$group = $_COOKIE["group"];
  ?>
  <h2 class="marks__title" data-mid="<?php echo $m_id; ?>"><span><?php echo $name; ?></span></h2>
		<table class="marks__table">
			<tr>
				<td rowspan="2" style="text-align: center">Студенты</td>
				<td colspan="8">Семестры</td>
			</tr>
			<tr>
				<td style="text-align: center;">1</td>
				<td>2</td>
				<td>3</td>
				<td>4</td>
				<td>5</td>
				<td>6</td>
				<td>7</td>
				<td>8</td>
			</tr>
			<?php
				$query = mysqli_query($con, "SELECT * FROM students WHERE s_group='$group' ORDER BY s_name ASC");
				while($row = mysqli_fetch_array($query)){
					$grade = $row["grade_11"];
			?>
				<tr>
					<td class="stud" data-stud="<?php echo $row["id"]; ?>"><?php echo $row["s_name"]; ?></td>
					<?php
						$s_id = $row["id"];
						$marks = mysqli_query($con, "SELECT * FROM mods_marks WHERE stud_id='$s_id' AND m_id='$m_id'");
						$mark = mysqli_fetch_array($marks);

						if($grade == 1) $grade = 6;				
						else $grade = 8;

						for ($i = 1; $i <= $grade; $i++){
							$s = "s".$i;
					?>					
							<td><input type="text" class="m_marks__mark <?php echo "mark_".$mark[$s]; ?>" value="<?php echo $mark[$s] > 0 ? "$mark[$s]" : ""; ?>"></td>
						<?php
						}
						
						if($grade == 6){
						?>
							<td class="mark_disabled"></td>
							<td class="mark_disabled"></td>
						<?php } ?>						
				</tr>
			<?php
				}
			?>
		</table>  
  <?php  
	}

	//Оценка для предмета добавляется впервые
	if(isset($_POST["first"])){
		$subid = $_POST["subid"];
		$sem = $_POST["sem"];
		$value = $_POST["value"];
		$stud = $_POST["stud"];

		$query = mysqli_query($con, "SELECT * FROM marks WHERE sub_id='$subid' AND s_id='$stud'");
		if(mysqli_num_rows($query) == 0) {

			$query = mysqli_query($con, "INSERT INTO `marks` (`sub_id`, `s_id`, `s1`, `s2`, `s3`, `s4`, `s5`, `s6`, `s7`, `s8`, `diploma`) VALUES ('$subid', '$stud', '0', '0', '0', '0', '0', '0', '0', '0', '0')");
			$sem = "s".$sem;
			$query = mysqli_query($con, "UPDATE `marks` SET $sem='$value' WHERE sub_id='$subid' AND s_id='$stud'");
		}
	}

	//Оценка для модуля добавляется впервые
	if(isset($_POST["mod_first"])){
		$mid = $_POST["mid"];
		$sem = "s".$_POST["sem"];
		$value = $_POST["value"];
		$stud = $_POST["stud"];

		$query = mysqli_query($con, "SELECT * FROM mods_marks WHERE m_id='$subid' AND stud_id='$stud'");
		if(mysqli_num_rows($query) == 0) {
			$query = mysqli_query($con, "INSERT INTO `mods_marks` (`m_id`, `stud_id`, `s1`, `s2`, `s3`, `s4`, `s5`, `s6`, `s7`, `s8`) VALUES ('$mid', '$stud', '0', '0', '0', '0', '0', '0', '0', '0')");
			$query = mysqli_query($con, "UPDATE `mods_marks` SET $sem='$value' WHERE m_id='$subid' AND stud_id='$stud'");
		}
	}	

	//Оценка для предмета добавляется НЕ впервые
	if(isset($_POST["add_mark"])){
		$subid = $_POST["subid"];
		//Выбранный семестр может быть "Дипломной оценкой". Sum - всего td в таблице, не считая названия предмета
		$sem = $_POST["sem"] == ($_POST["sum"] - 1) ? "diploma" : "s".$_POST["sem"];
		$value = $_POST["value"];
		$stud = $_POST["stud"];

		$query = mysqli_query($con, "SELECT * FROM marks WHERE sub_id='$subid' AND s_id='$stud'");
		if(mysqli_num_rows($query) == 0)
				$query = mysqli_query($con, "INSERT INTO `marks` (`sub_id`, `s_id`, `s1`, `s2`, `s3`, `s4`, `s5`, `s6`, `s7`, `s8`, `diploma`) VALUES ('$subid', '$stud', '0', '0', '0', '0', '0', '0', '0', '0', '0')");			
		$query = mysqli_query($con, "UPDATE `marks` SET $sem='$value' WHERE sub_id='$subid' AND s_id='$stud'");		
	}

	//Оценка для модуля добавляется НЕ впервые
	if(isset($_POST["add_mod_mark"])){
		$mid = $_POST["mid"];
		$value = $_POST["value"];
		$stud = $_POST["stud"];
		$sem = "s".$_POST["sem"];

		$query = mysqli_query($con, "SELECT * FROM mods_marks WHERE m_id='$mid' AND stud_id='$stud'");
		if(mysqli_num_rows($query) == 0)
				$query = mysqli_query($con, "INSERT INTO `mods_marks` (`m_id`, `stud_id`, `s1`, `s2`, `s3`, `s4`, `s5`, `s6`, `s7`, `s8`) VALUES ('$mid', '$stud', '0', '0', '0', '0', '0', '0', '0', '0')");							
		$query = mysqli_query($con, "UPDATE `mods_marks` SET $sem='$value' WHERE m_id='$mid' AND stud_id='$stud'");		
	}	

	//Отметка семестровых оценок (предметы)
	if(isset($_POST["show_sub"])){
		$sub_id = $_POST["show_sub"];
		$sub_name = $_POST["sub_name"];		
		$group = $_COOKIE["group"];
	?>
		<h2 class="marks__title" data-sub="<?php echo $sub_id; ?>"><span><?php echo $sub_name; ?></span></h2>
	<?php
		if($_POST["stud_exist"] == 0) die("Студентов пока нет.");
	?>
		<table class="marks__table">
			<tr>
				<td rowspan="2" style="text-align: center">Студенты</td>
				<td colspan="8">Семестры</td>
				<td rowspan="2">Диплом</td>
			</tr>
			<tr>
				<td style="text-align: center;">1</td>
				<td>2</td>
				<td>3</td>
				<td>4</td>
				<td>5</td>
				<td>6</td>
				<td>7</td>
				<td>8</td>
			</tr>
			<?php
				$query = mysqli_query($con, "SELECT * FROM students WHERE s_group='$group' ORDER BY s_name ASC");
				while($row = mysqli_fetch_array($query)){
					$grade = $row["grade_11"];
			?>
				<tr>
					<td class="stud" data-stud="<?php echo $row["id"]; ?>"><?php echo $row["s_name"]; ?></td>
					<?php
						$s_id = $row["id"];
						$marks = mysqli_query($con, "SELECT * FROM marks WHERE s_id='$s_id' AND sub_id='$sub_id'");
						$mark = mysqli_fetch_array($marks);

						if($grade == 1) $grade = 6;				
						else $grade = 8;

						for ($i = 1; $i <= $grade; $i++){
							$s = "s".$i;
					?>					
							<td><input type="text" class="marks__mark <?php echo "mark_".$mark[$s]; ?>" value="<?php echo $mark[$s] > 0 ? "$mark[$s]" : ""; ?>"></td>
						<?php
						}
						
						if($grade == 6){
						?>
							<td class="mark_disabled"></td>
							<td class="mark_disabled"></td>
						<?php } ?>
						<td><input type="text" class="marks__mark <?php echo "mark_".$mark["diploma"]; ?>" name="diploma" <?php echo $mark["diploma"] > 0 ? "value=".$mark["diploma"] : ""; ?>></td>
				</tr>
			<?php
				}
			?>
		</table>	
<?php
	}

	//Удаление оценки
	if(isset($_POST["del_mark"])){
		//Удаление оценки практики
		if(isset($_POST["mid"])) $mid = $_POST["mid"];
		else $sub = $_POST["sub"];

		$sem = "s".$_POST["sem"];
		$stud = $_POST["stud"];

		if(isset($_POST["mid"])) $query = mysqli_query($con, "UPDATE mods_marks SET $sem='0' WHERE m_id='$mid' AND stud_id='$stud'");
		else $query = mysqli_query($con, "UPDATE marks SET $sem='0' WHERE sub_id='$sub' AND s_id='$stud'");
	}

	//Добавление курсовой
	if(isset($_POST["w_name"])){
		$name = $_POST["w_name"];
		$mark = $_POST["w_mark"];
		$stud_id = $_POST["stud_id"];
		$query = mysqli_query($con, "INSERT INTO works (`id`, `w_name`, `w_mark`, `w_student`) VALUES (NULL, '$name', '$mark', '$stud_id')");
		if(!$query) die("error");
		else {
				$query = mysqli_query($con, "SELECT * FROM works WHERE w_student = '$stud_id'");
			?>
			<table class="marks__table">
				<tr rowspan="2">
					<td>Название</td>
					<td>Оценка</td>
				</tr>
				<tr></tr>
				<?php
					while($row = mysqli_fetch_array($query)){
				?>
					<tr>
						<td><?php echo $row["w_name"]; ?></td>
						<td><?php echo $row["w_mark"]; ?><div class="w_del" data-wid="<?php echo $row["id"]; ?>"></div></td>
					</tr>
				<?php
					}
				?>
			</table>
	<?php
		}
	}

	//Удаление курсовой
	if(isset($_POST["del_work"])){
		$wid = $_POST["del_work"];
		$query = mysqli_query($con, "DELETE FROM works WHERE id = '$wid'");
	}

		//Удаление приказа
	if(isset($_POST["del_order"])){
		$oid = $_POST["del_order"];
		$query = mysqli_query($con, "DELETE FROM orders WHERE id = '$oid'");
	}


		//Удаление приказа
	if(isset($_POST["del_dip"])){
		$did = $_POST["del_dip"];
		$query = mysqli_query($con, "DELETE FROM diploma WHERE id = '$did'");
	}

	//Добавление приказа
	if(isset($_POST["o_name"])){
		$name = $_POST["o_name"];
		$date = $_POST["o_date"];
		$stud_id = $_POST["stud_id"];
		$query = mysqli_query($con, "INSERT INTO orders (`id`, `o_name`, `o_date`, `o_student`) VALUES (NULL, '$name', '$date', '$stud_id')");
		if(!$query) die("error");
		else {
				$query = mysqli_query($con, "SELECT * FROM orders WHERE o_student = '$stud_id'");
			?>
			<table class="marks__table">
				<tr rowspan="2">
					<td>Название</td>
					<td>Дата</td>
				</tr>
				<tr></tr>
				<?php
					while($row = mysqli_fetch_array($query)){
				?>
					<tr>
						<td><?php echo $row["o_name"]; ?></td>
						<td><?php echo date('d.m.Y', strtotime($row["o_date"])); ?><div class="o_del" data-oid="<?php echo $row["id"]; ?>"></div></td>
					</tr>
				<?php
					}
				?>
			</table>
			<button class="add_work">Добавить</button>
			<div class="add_tools">
				<form class="new_order new_adding">
					<label class="w_label" for="o_name">
						Название:
						<input id="o_name" class="w_input" name="o_name" type="text" required></label>
					<label class="w_label" for="o_date">
						Дата:
						<input id="o_date" class="w_input" name="o_date" type="date" required>
					</label>
					<input type="submit" class="w_submit" value="">
				</form>
			</div>			
	<?php
		}
	}

	//Добавление дипломной
	if(isset($_POST["d_mark"])){
		$mark = $_POST["d_mark"];
		$stud_id = $_POST["stud_id"];
		$query = mysqli_query($con, "INSERT INTO diploma (`id`, `d_mark`, `d_student`) VALUES (NULL, '$mark', '$stud_id')");
		if(!$query) die("error");
		else {
				$query = mysqli_query($con, "SELECT * FROM diploma WHERE d_student = '$stud_id'");
			?>
			<table class="marks__table">
				<tr rowspan="2">
					<td>Название</td>
					<td>Оценка</td>
				</tr>
				<tr></tr>
				<?php
					while($row = mysqli_fetch_array($query)){
				?>
					<tr>
						<td>Дипломная работа</td>
						<td><?php echo $row["d_mark"]; ?><div class="d_del" data-did="<?php echo $row["id"]; ?>"></div></td>
					</tr>
				<?php
					}
				?>
			</table>
	<?php
		}
	}

	//Добавление куратора
	if(isset($_POST["new_curator"])){
		$name = $_POST["new_curator"];
		$login = $_POST["new_curator_login"];
		include("password.php");
		$pass = password_hash($_POST["new_curator_pass"], PASSWORD_DEFAULT);
		$spec = $_POST["new_curator_spec"];
		$query = mysqli_query($con, "INSERT INTO users (`id`, `login`, `pass`, `u_name`, `admin`, `u_spec`) VALUES (NULL, '$login', '$pass', '$name', '0', '$spec')");
	}

	//Добавление группы в первый раз
	if(isset($_POST["first-group"])){
		$name = $_POST["first-group"];
		$uid = $_COOKIE["logged"];
		$query = mysqli_query($con, "INSERT INTO groups (`g_name`, `g_curator`) VALUES ('$name', '$uid')");
		if($query) {
			$group = $name;
			setcookie("group", "$group", time() + 3600);			
		}
	}	

	//Настройки пользователя
	if(isset($_POST["set_name"])){
		$res = $_POST["set_surname"]." ".$_POST["set_name"]." ".$_POST["set_father"];
		$uid = $_COOKIE["logged"];
		$query = mysqli_query($con, "UPDATE users SET u_name = '$res' WHERE id='$uid'");
		if(!$query) die("error");
	}

	if(isset($_POST["set_oldpass"])){
		include("password.php");
		//Изменение пароля в админке
		if(isset($_POST["new_cur_pass"])){
			$uid = $_POST["new_cur_pass"];
			$newpass = password_hash($_POST["new_pass"], PASSWORD_DEFAULT);
			$setpass = mysqli_query($con, "UPDATE users SET pass = '$newpass' WHERE id = '$uid'");
		}
		else {
			$oldpass = $_POST["set_oldpass"];
			$newpass = $_POST["set_newpass"];

			$uid = $_COOKIE["logged"];
			$query = mysqli_query($con, "SELECT * FROM users WHERE id='$uid'");
			$query = mysqli_fetch_array($query);
			if(password_verify($oldpass, $query["pass"])){
				$newpass = password_hash($newpass, PASSWORD_DEFAULT);
				$setpass = mysqli_query($con, "UPDATE users SET pass = '$newpass' WHERE id = '$uid'");
			}
			else die("error");
		}
	}

	//Изменение логина куратора
	if(isset($_POST["new_cur_login"])){
		$cur = $_POST["new_cur_login"];
		$new = $_POST["new_login"];
		$query = mysqli_query($con, "SELECT * FROM users WHERE login = '$new'");
		if(mysqli_num_rows($query) != 0) die("error");
		else $query = mysqli_query($con, "UPDATE users SET login = '$new' WHERE id = '$cur'");
	}

	mysqli_close($con);
?>