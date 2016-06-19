$(document).ready(function() {
	
	tinymce.init({
		selector: 'textarea',
		language: 'ru',
		height: 400,
		plugins: [
		'link image',
		'contextmenu'
		],
		//menubar: "insert",
		/* toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image' */
		toolbar: 'browse  link | outdent indent | bold italic',
	   setup: function(ed) {
		  ed.addButton('browse', {
			 title: 'Link',
			 classes: 'calssLink',
			 //image: '../js/tinymce/plugins/example/img/example.gif',
			 onclick: function() {
				//ed.insertContent('Hello world!!');
			 }
		  });
	   }
	}).then(function(ed){

		var btnUpload = $('.mce-calssLink');
		new AjaxUpload(btnUpload, {
			action: 'upload-file.php',
			name: 'uploadfile',
			onSubmit: function(file, ext){
				 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
					// extension is not allowed 
					//ed.insertContent('Поддерживаемые форматы JPG, PNG или GIF');
					return false;
				}
				//ed.insertContent('Загрузка...');
				//status.text('Загрузка...');
			},
			onComplete: function(file, response){
				//On completion clear the status
				//status.text('');
				//Add uploaded file to list
				if(response==="success"){
					tinymce.get('tdText').insertContent("<a href='uploads/"+file+"'>"+file.replace(/\.(jpg|png|jpeg|gif)$/gi,'')+"</a>");
					//$('<li></li>').appendTo('#files').html('<img src="./uploads/'+file+'" alt="" /><br />'+file).addClass('success');
				} else {
					tinymce.get('tdText').insertContent('Файл не загружен' + file);
					//ed.setContent('Файл не загружен' + file);
					//$('<li></li>').appendTo('#files').text('Файл не загружен' + file).addClass('error');
				}
			}
		});
	}); 
	
	$('#formEditText .tenb').click(function() {
		$('#formEditText').addClass('hidden');
	});
});

//Добавление удаление обновление бд через Ajax
function postFunc(btn) {
	
	var field = new Array("idRazdel","idTable","idTrTd","idNews","name","paragraf","indexTable","tr","td");
	var error = 0;
	var dataPOST = 'func='+btn.attr("name")+'';

	btn.siblings(":input").each(function() {						// проверяем каждое поле в форме
		for(var i=0; i < field.length; i++){ 							// если поле присутствует в списке обязательных
			if($(this).attr("name") == field[i]){ 						//проверяем поле формы на пустоту
				if(!$(this).val()){										// если в поле пустое
					$(this).css('border', 'red 1px solid');				// устанавливаем рамку красного цвета
					error = 1;										// определяем индекс ошибки 
				}
				else{
					$(this).css('border', 'gray 1px solid');			// устанавливаем рамку обычного цвета
				}
			}     
			dataPOST = dataPOST + '&' + $(this).attr("name") + '=' + encodeURIComponent($(this).val()) + '';
		}
	});
	if (btn.siblings("textarea").attr("name") == "tdText") {
		var tdText = tinymce.get('tdText').getContent();
		tdText = encodeURIComponent(tdText);
		dataPOST = dataPOST + '&' + "tdText=" + tdText + "";
	}
	
	switch(btn.attr("name"))
	{
	case 'delRazdel':
	case 'delTable':
	case 'delNews':
	case 'delTr':
	case 'delTd':
		var result = confirm("Точно удалить?");
		if (!result)
		{
			error = 2;
		}
		break;
	}
	
	//alert(dataPOST);
	
	if (error == 0)
	{
		$.ajax({
			type: 'POST',
			url: 'lib/printFunc.php',
			data: dataPOST,
			success: function(data) {
				//alert(data);
				switch(btn.attr("name"))
				{
					case 'delRazdel': 
						btn.parent('.postFunc').parent('.razdel').remove();
						break;
					case 'delTable': 
						btn.parent('.postFunc').parent('.razdelTable').remove();
						break;
					case 'delNews':
						btn.parent('.postFunc').parent('.news').remove();
						break;
					case 'insertRazdel':
						$("#moneyRazdel").append(data);
						break;
					case 'insertTable':
						btn.parent('.postFunc').siblings('.razdelTables').append(data);
						break;
					case 'delTr':
					case 'delTd':
						var idTable = btn.siblings("input[name='idTable']").val();
						$('#table'+idTable).html(data);
						break;
					case 'insertTr':
					case 'insertTd':
						btn.parent('.postFunc').siblings('.tableMoney').html(data);
						break;
					case 'insertNews':
						$('#newsRazdel').prepend(data);
						break;
					case 'updateTable':
						btn.parent('.postFunc').parent('.blkTable').parent('.razdelTable').parent('.razdelTables').parent('.razdel').replaceWith(data);
						break;
					case 'updateTd':
						$("#td"+btn.siblings("input[name='idTrTd']").val()).html(tinymce.get('tdText').getContent());
						addDownloadImg($("#td"+btn.siblings("input[name='idTrTd']").val()+" a"));
						fancyboxFunc($("#td"+btn.siblings("input[name='idTrTd']").val()+" a.img"));
						$('#formEditText').addClass('hidden');
						break;
				}
			}
		});
	} else {if (error == 1) alert('заполните все поля!')}
}

function shiwEditText(btn) {
	btn = btn.find('.tdClass');
	editor = $('#formEditText');
	//console.log(tinymce.get('tdText').getContent());
	tinymce.get('tdText').setContent(btn.html());
	
		//tinyMCE.get('tdText').focus();      
		//imageUrl = '".CUtil::JSEscape($arResult["URL_IMG"])."';      
		//imageName = '".CUtil::JSEscape($_REQUEST["name"])."';      
		//var el = tinyMCE.get('tdText').dom.create('a', {'href' : imageUrl, 'alt': imageName, 'text': imageName}, 'dsg');  
		//tinyMCE.get('tdText').selection.setNode(el);

	//editor.find('textarea').val(btn.html());
	editor.find("input[name='idTrTd']").val(btn.siblings("input[name='idTrTd']").val());
	editor.removeClass('hidden');
}