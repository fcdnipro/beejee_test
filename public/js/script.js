$(document).ready(function(){
	$('#previewTask').on('click', function(){
		var formData = new FormData(document.getElementById('createForm'));
		$.ajax({
			url: '/requests/request_create.php',
			type: "POST",
			contentType: false, 
			processData: false, 
			data: formData,
			success: function(json){
				$('#previewForm').html(json);
				data = JSON.parse(json);
				$('#username').html(data['username']);
				$('#email').html(data['email']);
				$('#text').html(data['text']);
				$('#img').attr('src', data['img']);
				$('#previewBlock').attr('style', '');
			}
		});
	});
});