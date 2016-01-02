function clearContent(name){
	var item = document.getElementById(name);
	item.value = "";
}

function getExercises() {
	$.ajax({
		type: "POST",
		url: "exercises_listing.php",
		data: '',
		cache: false,
		success: function(html) {
			$("#exercise-pane").html(html);		
		}
	});

}

function updateMarks() {
	$.ajax({
		type: "POST",
		url: "update_marks.php",
		data: '',
		cache: false,
		success: function(html) {
			html = html.trim();
			$("#marks").html(html);		
		}
	});

}

function compileFunct(filename, exerid) {
	//var code = document.getElementById("code").value;
	var code = editor.getValue();

	if (code == '' || code == '... enter code here!!!') {
		$("#result").html('<span class=\'error\'>Please enter your code</span>');
	} else {
		// AJAX code to submit form.
		$.ajax({
			type: "POST",
			url: "compile.php",
			data: {
				code:code, 
				filename:filename, 
				exer_id:exerid
			      },
			cache: false,
			success: function(html) {
				$("#result").html(html);
				$( "#output" ).empty();
				if(html.indexOf("Error")<0){	
					$("#execute").removeAttr("disabled");
					$("#execute").css("background-color", "#FF6600");
					
				}else{
					$("#execute").attr("disabled", "disabled");
					$("#execute").prop('disabled', true);
					$("#execute").css("background-color", "#cdcdcd");
				}

				
			}

		});
		
	}
	return false;
}

function executeFunct(filename, exerid) {
	if (filename == '') {
		$("#output").html('<span class=\'error\'>Please compile your code</span>');
	} else {
		var code = document.getElementById("code").value;
		var dataString = 'code=' + code;
		$.ajax({
			type: "POST",
			url: "run.php?filename=" + filename + "&exerid=" + exerid,
			data: dataString,
			cache: false,
			success: function(html) {
				$("#output").html(html);
				$("#execute").attr("disabled", "disabled");
				$("#execute").prop('disabled', true);
				$("#execute").css("background-color", "#cdcdcd");
				getExercises();	
				updateMarks();
			}
		});
		
		
		
	}

	return false;
}

function confirm(){
	$("#dialog-confirm").dialog({
	      resizable: false,
	      height:140,
	      modal: true,
	      buttons: {
		"Delete all items": function() {
		  $( this ).dialog( "close" );
		},
		Cancel: function() {
		  $( this ).dialog( "close" );
		}
	      }
	  });
}

function nextExercise(exerid) {
      location.href = '?id=' + exerid;
}
