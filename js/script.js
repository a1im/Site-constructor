function headertop() {
	var bo = $(this).scrollTop();
	//подняться вверх
	if (bo > 200) 
	{
		$('#vverh').stop(false,false).animate({right: '10px'},500);
	}
	if (bo <= 200) 
	{
		$('#vverh').stop(false,false).animate({right: '-200px'},500);
	}
}

function addDownloadImg(tmp) {
	tmp.each(function() {
		if ($(this).attr('download') != 1 && $(this).siblings('a').attr('download') != 1) {
			if (!$(this).hasClass('img')) {
				$(this).addClass('img');
				$(this).wrap("<p class='blkImg'></p>");
			}
			$(this).after(" | <a class='imgDownload' href='"+$(this).attr('href')+"' download='1'>скачать</a>");
		}
	});
}

function fancyboxFunc(tmp) {
	tmp.fancybox({
		'transitionIn'	: 'elastic',
		'transitionOut'	: 'elastic',
		'autoScale'			: true
	});
}

$(document).ready(function() {

	
	addDownloadImg($("td a"));	//скачать фото
 	fancyboxFunc($("td a.img")); //увеличить фото
	headertop();
	
	$(this).scroll(function(){
		headertop();
	});
	
	$('#vverh').click(function() {
		$('html, body').stop().animate({scrollTop: 0}, 700);
	});

	$('.podpiska form').submit(function() {
		var email = $(this).find("input[type='email']").val();
		if (email == "") {
			alert('Заполните поле E-mail');
		} else {
			$.ajax({
				type: "POST",
				url: "send.php",
				data: "email="+email+"",
				success: function(data) {
					alert(data);
				}
			});
		}
		return false;
	});
});

function shiwHiddenTable(btn) {
	if (btn.siblings(".blkTable").hasClass('hidden')) {
		btn.find("span").addClass('minus');
		btn.find("span").removeClass('plus');
		btn.siblings(".blkTable").removeClass('hidden');
	}
	else {
		btn.find("span").addClass('plus');
		btn.find("span").removeClass('minus');
		btn.siblings(".blkTable").addClass('hidden');
	}
}

function shiwHiddenNews() {
	if ($('#hiddenNews').hasClass('hidden')) {
		$('#hiddenNews').removeClass('hidden');
	}
	else {
		$('#hiddenNews').addClass('hidden');
	}
}

function linkTd(btn) {
	var name = btn.attr("link");
	var td = $("#td" + name);
	$(".blkTable").each(function() {
		if ($(this).find("#td" + name).html() != null) {
			if ($(this).hasClass('hidden')) {
				$(this).siblings('p[class*=h]').find("span").addClass('minus');
				$(this).siblings('p[class*=h]').find("span").removeClass('plus');
				$(this).removeClass('hidden');
			}
		}
	});
	$('html, body').stop().animate({scrollTop: td.offset().top}, 700);
}