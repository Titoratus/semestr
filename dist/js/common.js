$(".noscript").removeClass("noscript");


if(navigator.userAgent.toLowerCase().indexOf('firefox') > -1){
	jQuery('.side').bind('mousewheel', function(event) {
	  event.preventDefault();
	  var scrollTop = this.scrollTop;
	  this.scrollTop = (scrollTop + ((event.deltaY * event.deltaFactor) * -1));
	  //console.log(event.deltaY, event.deltaFactor, event.originalEvent.deltaMode, event.originalEvent.wheelDelta);
	});     
}

//При входе сова закрывает глаза
$(".login__pass").focus(function(){
	$(".owl").addClass("pass");
});

$(".login__pass").blur(function(){
	$(".owl").removeClass("pass");
});

$(document).ready(function() {
  $(".popup-add").magnificPopup({type: "inline"});
});

//Табы
$(document).on("click", ".tab__btn", function(){
	if($(this).hasClass("tab__btn_active")) return false;
	else {
		$(this).parent().find(".tab__btn_active").removeClass("tab__btn_active");
		$(this).parent().parent().find(".tab_active").removeClass("tab_active");
		$(this).addClass("tab__btn_active");
		var tab = "."+$(this).attr("data-tab");
		$(tab).addClass("tab_active");

		if($(".marks-wrap").is(":visible")){
			$(".new_adding").hide();
			$(".add_work").show();	
		}
	}
});


//Добавление курсовой
$(document).on("click", ".add_work", function(){
	$(this).hide();
	$(this).parent().find(".new_adding").css("display", "inline-block");
});

//Добавление группы в первый раз
$(document).on("click", ".first-group-btn", function(){
	if(!$.isNumeric($(".first-group").val())) return false;

	$.ajax({
		data: "first-group="+$(".first-group").val(),
		type: "post",
		url: "functions.php",
		success: function(data) {
			location.reload();
		}
	});
});

//Добавленик курсовой
$(document).on("submit", ".new_work", function(e){
	var form = $(this);
	var stud_id = $(".marks__title").attr("data-stud");
	$.ajax({
		 data: form.serialize()+"&stud_id="+stud_id,
		 type: "post",
		 url: "functions.php",
		 success: function(data) {
		 		if($.trim(data) == "error") $(form).parent().parent().html("Не удалось добавить работу :(");
		 		else $(form).parent().parent().html(data);
		 } 
	});	
	e.preventDefault();
});

//Добавление приказа
$(document).on("submit", ".new_order", function(e){
	var form = $(this);
	var stud_id = $(".marks__title").attr("data-stud");
	$.ajax({
		 data: form.serialize()+"&stud_id="+stud_id,
		 type: "post",
		 url: "functions.php",
		 success: function(data) {
		 		if($.trim(data) == "error") $(form).parent().parent().html("Не удалось добавить приказ :(");
		 		else $(form).parent().parent().html(data);
		 } 
	});	
	e.preventDefault();
});

//Добавление дипломной
$(document).on("submit", ".new_diploma", function(e){
	var form = $(this);
	var stud_id = $(".marks__title").attr("data-stud");
	$.ajax({
		 data: form.serialize()+"&stud_id="+stud_id,
		 type: "post",
		 url: "functions.php",
		 success: function(data) {
		 		if($.trim(data) == "error") $(form).parent().parent().html("Не удалось добавить работу :(");
		 		else $(form).parent().parent().html(data);
		 } 
	});	
	e.preventDefault();
});

$(document).on("submit", ".login_form", function(e){
	var form = $(this);
	$.ajax({
		 data: form.serialize(),
		 type: "post",
		 url: "functions.php",
		 success: function(data) {
		 		if($.trim(data) == "error") $(".login__error").html("Ой. Что-то не так :(");
		 		else location.reload();
		 } 
	});
	e.preventDefault();
});

$(document).on("keypress", ".g_name_first", function(e){
	if(e.which == 13){
		$.ajax({
			 data: "create_group="+$(this).val(),
			 type: "post",
			 url: "functions.php",
			 success: function(data) {
			 		if($.trim(data) == "error") alert("Не удалось добавить группу!");
			 		else window.location.href = "index.php";
			 }
		});		
	}
});

//Меню настроек
$(document).on("click", function(e){
	if(e.target.className == "settings") return false;
	if(e.target.className === "settings-btn"){
		if($(".settings-btn").hasClass("settings-btn_active")) $(".settings-btn").removeClass("settings-btn_active");
		else $(".settings-btn").addClass("settings-btn_active");
		$(".settings").toggle();
	}
	else {
		if($(".settings-btn").hasClass("settings-btn_active")) {
			$(".settings-btn").removeClass("settings-btn_active");
			$(".settings").toggle();
		}
	}
});


//Выход
$(document).on("click", ".exit", function(){
	if(!confirm("Вы уверены, что хотите выйти?")) return false;
});

//Новый студент
$(document).on("submit", "#add_stud", function(e){
	var form = $(this);
	$.ajax({
		 data: form.serialize(),
		 type: "post",
		 url: "functions.php",
		 success: function(data) {
		 		location.reload();
		 } 
	});
	e.preventDefault();
});

//Удаление студента
$(document).on("click", ".table_left .del-stud", function(){
	if(confirm("Вы уверены, что хотите удалить студента?")){
		var stud = $(this).parent();
		$.ajax({
			 data: "del_stud="+stud.attr("data-stud"),
			 type: "post",
			 url: "functions.php",
			 success: function(data) {
			 		location.reload();
			 } 
		});		
	}
});

//Удаление модуля
$(document).on("click", ".table_practice td:last-of-type", function(){
	if(confirm("Вы уверены, что хотите удалить модуль?")){
		var pr = $(this);
		$.ajax({
			 data: "del_practice="+pr.attr("data-pr"),
			 type: "post",
			 url: "functions.php",
			 success: function(data) {
			 		location.reload();
			 } 
		});		
	}
});

//Новый модуль практики
$(document).on("submit", "#add_practice", function(e){
	var form = $(this);
	$.ajax({
		 data: form.serialize(),
		 type: "post",
		 url: "functions.php",
		 success: function(data) {
		 		location.reload();
		 } 
	});
	e.preventDefault();
});

//Удаление курсовой
$(document).on("click", ".w_del", function(){
	if(confirm("Вы уверены, что хотите удалить курсовую?")){
		var work = $(this).attr("data-wid");
		$.ajax({
			 data: "del_work="+work,
			 type: "post",
			 url: "functions.php",
			 success: function(data) {
			 		location.reload();
			 } 
		});		
	}
});

//Удаление приказа
$(document).on("click", ".o_del", function(){
	if(confirm("Вы уверены, что хотите удалить приказ?")){
		var order = $(this).attr("data-oid");
		$.ajax({
			 data: "del_order="+order,
			 type: "post",
			 url: "functions.php",
			 success: function(data) {
			 		location.reload();
			 } 
		});		
	}
});


//Удаление предмета
$(document).on("click", ".table_right .del-sub", function(){
	if(confirm("Вы уверены, что хотите удалить предмет?")){
		var sub = $(this).parent();
		$.ajax({
			 data: "del_sub="+sub.attr("data-sub"),
			 type: "post",
			 url: "functions.php",
			 success: function(data) {
			 		location.reload();
			 } 
		});		
	}
});

//Удаление дипломной
$(document).on("click", ".d_del", function(){
	if(confirm("Вы уверены, что хотите удалить дипломную?")){
		var sub = $(this);
		$.ajax({
			 data: "del_dip="+sub.attr("data-did"),
			 type: "post",
			 url: "functions.php",
			 success: function(data) {
			 		location.reload();
			 } 
		});		
	}
});

//Новый предмет
$(document).on("submit", "#add_sub", function(e){
	var form = $(this);
	$.ajax({
		 data: form.serialize(),
		 type: "post",
		 url: "functions.php",
		 success: function(data) {
		 		location.reload();
		 } 
	});
	e.preventDefault();
});

//Редактирование студента
$(document).on("click", ".edit-stud", function(){
	var name = $(this).parent().parent().find($(".student_name"));
	var old = name.text();
	name.html("<input value='" + old + "'>");
	$(this).remove();
});

//Открытие окна для семестровых отметок (студенты)
$(document).on("click", ".table_left td:not(:last-of-type)", function(){
	var name = $(this).parent().find(".student_name").text();
	id = $(this).parent().find(".student_id").attr("data-stud");
	sub_exist = 0;
	grade = $(this).parent().find(".student_id").attr("data-grade");

	//Есть ли предметы
	if($(".table_right").length) sub_exist = 1;

	$.ajax({
		 data: "stud_name="+name+"&show_stud="+id+"&sub_exist="+sub_exist+"&grade_11="+grade,
		 type: "post",
		 url: "functions.php",
		 success: function(data) {
		 		$(".marks-content").html(data);
		 		$(".marks-wrap").show();

				//Подсчёт дипломной оценки
				$(".marks-form").find("tr:not(:first-of-type), tr:not(:nth-of-type(2))").each(function(){
					var sum = 0;
							num = 0;					
					$(this).find("td:not(:first-of-type), td:not(:last-of-type)").each(function(){						
						if($.isNumeric($(this).find("input").val())) {
							num++;
							sum = sum + Number($(this).find("input").val());
						}
					});
					if(num != 0) $(this).find("td").find("input[name='diploma']").attr("placeholder", (sum/num).toFixed(2));
				});		 		
		 } 
	});	
});

//Закрытие окна при клике НЕ на окно
$(document).on("click", ".marks-wrap", function(e){
	if(e.target !== this) return;
	$(".marks-wrap").hide();
	$(".marks-content").html("");
});

$(document).on("click", ".marks-close", function(e){
	$(".marks-wrap").hide();
	$(".marks-content").html("");
});

//Открытие окна для семестровых отметок (предметы)
$(document).on("click", ".table_right td:not(:last-of-type)", function(){
	var name = $(this).parent().find(".sub_name").text();
	id = $(this).parent().find(".sub_id").attr("data-sub");
	stud_exist = 0;

	//Есть ли предметы
	if($(".table_left").length) stud_exist = 1;

	$.ajax({
		 data: "sub_name="+name+"&show_sub="+id+"&stud_exist="+stud_exist,
		 type: "post",
		 url: "functions.php",
		 success: function(data) {
		 		$(".marks-content").html(data);
		 		$(".marks-wrap").show();

				//Подсчёт дипломной оценки
				$(".marks-form").find("tr:not(:first-of-type), tr:not(:nth-of-type(2))").each(function(){
					var sum = 0;
							num = 0;					
					$(this).find("td:not(:first-of-type), td:not(:last-of-type)").each(function(){						
						if($.isNumeric($(this).find("input").val())) {
							num++;
							sum = sum + Number($(this).find("input").val());
						}
					});
					if(num != 0) $(this).find("td").find("input[name='diploma']").attr("placeholder", (sum/num).toFixed(2));
				});
		 } 
	});
});

//Открытие окна практики
$(document).on("click", ".table_practice td:not(:last-of-type)", function(){
	var name = $(this).parent().find(".m_name").text();
	id = $(this).parent().find(".m_name").attr("data-mid");

	$.ajax({
		 data: "show_pr="+id+"&m_name="+name,
		 type: "post",
		 url: "functions.php",
		 success: function(data) {
		 		$(".marks-content").html(data);
		 		$(".marks-wrap").show();
		 } 
	});
});

//Проверка поля фио студента на кол-во символов
$("input[name='new_stud']").on("keyup", function(){
	if($(this).val().length > 32){
		$(this).css({"border-color" : "#f77482"});
		$(this).parent().find(".form__btn").attr("disabled", true);
		$(this).parent().find(".form__btn").addClass("form__btn_disabled");
	}
	else {
		$(this).css({"border-color" : "#d6d6d6"});
		$(this).parent().find(".form__btn").removeAttr("disabled");
		$(this).parent().find(".form__btn").removeClass("form__btn_disabled");
	}
});

$("input[name='new_sub']").on("keyup", function(){
	if($(this).val().length > 60){
		$(this).css({"border-color" : "#f77482"});
		$(this).parent().find(".form__btn").attr("disabled", true);
		$(this).parent().find(".form__btn").addClass("form__btn_disabled");
	}
	else {
		$(this).css({"border-color" : "#d6d6d6"});
		$(this).parent().find(".form__btn").removeAttr("disabled");
		$(this).parent().find(".form__btn").removeClass("form__btn_disabled");
	}
});

$(document).on("focus", ".marks__mark, .m_marks__mark", function(){
	$(this).attr("maxlength", 1);
});

//Запрет ввода символов, кроме цифр - только цифры от 2 и 5
$(document).on("keydown keyup", ".marks__mark", function(e){

	//Удаление символа
	if(e.which == 8) {
		$(this).removeClass("mark_2 mark_3 mark_4 mark_5");
		if($(this).val().length == 0) return false;

		$.ajax({
			 data: "del_mark=1&sub="+$(this).parent().parent().find(".sub").attr("data-subid")+"&sem="+$(this).parent().index()+"&stud="+$(".marks__title").attr("data-stud"),
			 type: "post",
			 url: "functions.php"
		});
	}

	//Перемещение стрелками
	else if(e.type == "keyup") if(e.which == 37 || e.which == 38 || e.which == 39 || e.which == 40){
    var $table = $(this).parent().parent().parent();
    var $active = $('input:focus', $table);
    var $next = null;
    var focusableQuery = 'input:visible';
    var position = parseInt($active.closest('td').index()) + 1;
    switch(e.which){
        case 37: // <Left>
            $next = $active.parent('td').prev().find(focusableQuery);   
            break;
        case 38: // <Up>                    
            $next = $active
                .closest('tr')
                .prev()                
                .find('td:nth-child(' + position + ')')
                .find(focusableQuery)
            ;
            
            break;
        case 39: // <Right>
            $next = $active.closest('td').next().find(focusableQuery);            
            break;
        case 40: // <Down>
            $next = $active
                .closest('tr')
                .next()                
                .find('td:nth-child(' + position + ')')
                .find(focusableQuery)
            ;
            break;
    }       
    if($next && $next.length)
    {        
        $next.focus();
    }		
	}
	else if(!$.isNumeric(e.key)) return false;
	else if(parseInt(e.key) < 2 || parseInt(e.key) > 5) return false;

	$(this).attr("class", "cleanstate");
	$(this).addClass("marks__mark");
	switch($(this).val()) {
		case "5":
			 $(this).addClass("mark_5");
			 break;
		case "4":
			 $(this).addClass("mark_4");
			 break;
		case "3":
			 $(this).addClass("mark_3");
			 break;
		case "2":
			 $(this).addClass("mark_2");
			 break;			 			 
	}
});

//Добавление оценки при потере фокуса input
$(document).on("blur", ".marks__mark", function(){
	if($(this).val() == "") return false;

	//Номер семестра
	var num = $(this).parent().index();
			//Кол-во всех td в tr (для дипломной оценки у тех, у кого 6 семестров)
			sum = $(this).parent().parent().children("td").length;

	//Оценка
	value = $(this).val();
	tr = $(this).parent().parent();
	subid = tr.find(".sub").attr("data-subid");

	//Значит отметка ставится через предметы
	if(subid == undefined){
		stud = tr.find(".stud").attr("data-stud");
		var subid = $(".marks__title").attr("data-sub");
	}
	else var stud = $(".marks__title").attr("data-stud");

	notEmpty = false;

	//Поле теряет фокус - проверяем есть ли значения в других полях
	//Первый td пропускаем (это название предмета)
	tr.find("td").not(":first-of-type").each(function(){

		//Если есть хоть одно поле со значением
		if($(this).find("input").val() != "") {
			notEmpty = true;
			return false;
		}

	});

	//Если есть хоть одно поле со значением
	if(notEmpty) {
		$.ajax({
			 data: "add_mark=1&subid="+subid+"&sem="+num+"&value="+value+"&stud="+stud+"&sum="+sum,
			 type: "post",
			 url: "functions.php"
		});		
	}
	//Оценка для предмета добавляется впервые
	else {
		$.ajax({
			 data: "first=1&subid="+subid+"&sem="+num+"&value="+value+"&stud="+stud+"&sum="+sum,
			 type: "post",
			 url: "functions.php"
		});
	}
});

//Добавление оценки (практика) при потере фокуса input
$(document).on("blur", ".m_marks__mark", function(){
	if($(this).val() == "") return false;

	//Номер семестра
	var num = $(this).parent().index();

	//Оценка
	value = $(this).val();
	tr = $(this).parent().parent();
	mid = $(".marks__title").attr("data-mid");
	stud = tr.find($(".stud")).attr("data-stud");

	//Значит ввод в форме студента
	if(stud == null) {
		stud = $(".marks__title").attr("data-stud");
		mid = tr.find(".m_name").attr("data-mid");
	}

	notEmpty = false;

	//Поле теряет фокус - проверяем есть ли значения в других полях
	//Первый td пропускаем (это ФИО студента)
	tr.find("td").not(":first-of-type").each(function(){

		//Если есть хоть одно поле со значением
		if($(this).find("input").val() != "") {
			notEmpty = true;
			return false;
		}

	});

	//Если есть хоть одно поле со значением
	if(notEmpty) {
		$.ajax({
			 data: "add_mod_mark=1&mid="+mid+"&sem="+num+"&value="+value+"&stud="+stud,
			 type: "post",
			 url: "functions.php"
		});		
	}
	//Оценка для предмета добавляется впервые
	else {
		$.ajax({
			 data: "mod_first=1&mid="+mid+"&sem="+num+"&value="+value+"&stud="+stud,
			 type: "post",
			 url: "functions.php"
		});
	}
});


//Добавление оценки (практика) - ввод
$(document).on("keydown keyup", ".m_marks__mark", function(e){
	if(parseInt(e.key) > 5 || parseInt(e.key) < 2) return false;

	if(e.which == 8) {
		$(this).removeClass("mark_2 mark_3 mark_4 mark_5");
		if($(this).val().length == 0) return false;

		var mid = $(this).parent().parent().find(".m_name").attr("data-mid");
				stud = $(".marks__title").attr("data-stud");
		if(mid == null) {
			mid = $(".marks__title").attr("data-mid");
			stud = $(this).parent().parent().find(".stud").attr("data-stud");
		}

		$.ajax({
			 data: "del_mark=1&mid="+mid+"&sem="+$(this).parent().index()+"&stud="+stud,
			 type: "post",
			 url: "functions.php"
		});
	}
});

$(document).on("focus", ".marks__mark", function(){
	$(this).attr("autocomplete", "off");
});


//Сохранение настроек пользователя
$(document).on("submit", ".sets_edit_name", function(e){
	var form = $(this);
	$.ajax({
		 data: form.serialize(),
		 type: "post",
		 url: "functions.php",
		 success: function(data) {
		 		if($.trim(data) == "error") alert("Что-то пошло не так.");
		 		else location.reload();
		 } 
	});
	e.preventDefault();
});

$(document).on("submit", ".sets_edit_pass", function(e){
	if(!($("input[name='set_repeat']").val() == $("input[name='set_newpass']").val())) {
		alert("Пароли не совпадают!");
		return false;
	}
	var form = $(this);
	$.ajax({
		 data: form.serialize(),
		 type: "post",
		 url: "functions.php",
		 success: function(data) {
		 		if($.trim(data) == "error") alert("Что-то пошло не так.");
		 		else location.reload();
		 } 
	});
	e.preventDefault();
});

//Изменение пароля
$(document).on("keyup keydown", "input[name='set_oldpass']", function(){
	if($("input[name='set_oldpass']").val() != ""){
		$("input[name='set_newpass']").prop("required", true);
		$("input[name='set_repeat']").prop("required", true);
	}
	else {
		$("input[name='set_newpass']").prop("required", false);
		$("input[name='set_repeat']").prop("required", false);
	}
});

//--------------Администраторская-------------------

//Удаление куратора
$(document).on("click", ".table_left td:last-child", function(){
	if(confirm("Все данные студентов и куратора будут удалены. Вы уверены?")){
		var cur = $(this);
		$.ajax({
			 data: "del_curator="+cur.attr("data-curator"),
			 type: "post",
			 url: "functions.php",
			 success: function(data) {
			 		location.reload();
			 } 
		});		
	}
});

$(document).on("keypress", ".form__input", function(){
	$(this).removeClass("form__input_invalid");
});

//Новый куратор
$(document).on("submit", "#add_curator", function(e){

	var k = false;
	$.each($("#add_curator .form__input"), function(){
		if($.trim($(this).val()) == "") {
			k = true;
			return false;
		}
	});

	if(k) {
		alert("Заполните все поля!");
		return false;
	}

	if($("input[name='new_curator_login']").val().indexOf(' ') >= 0) {
		alert("Логин содержит пробелы!");
		$("input[name='new_curator_login']").addClass("form__input_invalid");
		return false;
	}

	$.each($(".cur_login"), function(){
		 if($("input[name='new_curator_login']").val() == $(this).text()) {
		 		alert("Такой логин уже занят!");
		 		$("input[name='new_curator_login']").addClass("form__input_invalid");
		 		k = true;
		 		return false;
		 }
	});

	if(k) {
		return false;
	}

	if($("input[name='new_curator']").val().split(' ').length != 3) {
		alert("Введите полное ФИО!");
		$("input[name='new_curator']").addClass("form__input_invalid");
		return false;
	}

	var cur = $(this).serialize();
	$.ajax({
		 data: cur,
		 type: "post",
		 url: "functions.php",
		 success: function(data) {
		 		location.reload();
		 } 
	});
	e.preventDefault();
});

//Клик на куратора
$(document).on("click", ".table_curators tr td:not(:last-child)", function(){
	$(".side-info-text").remove();
	$(".curator_info").show();
	$(".table_tr_active").removeClass("table_tr_active");
	$(this).parent().addClass("table_tr_active");
});


//Изменение логина
$(document).on("submit", "#new_cur_login", function(e){
	if($.trim($("#new_login").val()) == "") {
		$("#new_login").val("");
		return false;
	}
	var cur = $(".table_tr_active").find(".del-curator").parent().attr("data-curator");
	var form = $(this);
	$.ajax({
		 data: form.serialize()+"&new_cur_login="+cur,
		 type: "post",
		 url: "functions.php",
		 success: function(data) {
		 		if($.trim(data) == "error") alert("Такой логин уже занят!");
		 		else location.reload();
		 } 
	});
	e.preventDefault();
});

//Изменение пароля
$(document).on("submit", "#new_cur_pass", function(e){
	if($.trim($("#new_pass").val()) == "") {
		$("#new_pass").val("");
		return false;
	}	
	var cur = $(".table_tr_active").find(".del-curator").parent().attr("data-curator");
	var form = $(this);
	$.ajax({
		 data: form.serialize()+"&new_cur_pass="+cur+"&set_oldpass=1",
		 type: "post",
		 url: "functions.php",
		 success: function(data) {
				location.reload();
		 } 
	});
	e.preventDefault();
});

$(document).on("click", ".sem-report", function(e){
	e.stopPropagation();
	$(".choose-sem").toggle();
});

//Успеваемость
$(document).on("click", ".choose-sem span", function(){
	$.ajax({
		 data: "sem="+$(this).text(),
		 type: "post",
		 url: "sem_report.php",
		 success: function(data) {
	
		 } 
	});
});