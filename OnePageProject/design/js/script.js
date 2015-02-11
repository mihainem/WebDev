$(document).ready(function(){
	//On clicking the image show the front and back frame
    $('img').click(function(){
        var this_src = $(this).attr('src');
        $('#front-frame img').attr('src', this_src);
       $('#front-frame').show(); 
       $('#back-frame').show(); 
    });

	//On clicking the gray contuur of the image close de front and back frame
    $('#back-frame').click(function(){
       $('#front-frame').hide(); 
       $('#back-frame').hide(); 
    });     
    
	//switch menu pages
	$('.menu ul li').click(function(){	
		//set the CurrentPage session to selected id
		var this_id = $(this).attr('id');
		sessionStorage.setItem("CurrentPage", this_id);
		
		// highlight selected buttons
		$('.header ul li').removeClass('selected');
		$(this).addClass('selected');
		
		//make this page active by button click
		$('.main div').removeClass('active');
		var thisClass = '.' + $(this).attr('id');
		$(thisClass).addClass('active');		
	});	

	//set event of the upload button to the proper hidden input file
	 $('#button_add_file').click(function(){
        $('#file').click();
    });
	
	//treat the reply button to toggle the form
	$('.reply').click(function(){
		$('label > form').hide();
		$(this).next().show();	
	});
	
	//close faq form when X is pressed
	$('form .exit').click(function(){
		$('label > form').hide();
	});
		
	//handle submit FAQ by AJAX
	$('form.faq-form').submit(function(){		
		var form_data ={
			username: $(this).children('.username').val(),
			email: $(this).children('.email').val(),
			message: $(this).children('.message').val(),
			question_id: $(this).children('.question_id').val()
		};		
		
		path = window.location.href;
		path = path.replace("#","");
		
		$.ajax({
			url: path + 'home/process_faq_form',
			type: 'POST',
			data: form_data,	
			error: function(msg){
				alert('message adding returned an error');
			},
			complete:   function(msg) {
				if ( msg.responseText !== ''){					
					if( form_data.question_id == '-1' ){					
						$('ul#questions').append(msg.responseText);
						$('form').trigger('reset');
					}else{
						$('ul#answers' + form_data.question_id).append(msg.responseText);
						$('form').trigger('reset');
					}
				}
				else{
					alert('Fields are invalid');
				}		 
			}
		});
		return false;
	});
	
	$('form.signup-form').submit(function(){
		var form_data ={
			user_name: $(this).children('.user_name').val(),
			user_email: $(this).children('.user_email').val(),
			user_password: $(this).children('.user_password').val(),			
		};		
		
		path = window.location.href;
		path = path.replace("#","");
		
		$.ajax({
			url: path + 'home/process_signup_form',
			type: 'POST',
			data: form_data,			
			succes: function(msg){
				alert('SignUp succes');
			},
			error: function(msg){
				alert('There is an error on SignUp');			
			},
			complete:   function(msg) {
				alert(msg.responseText);			 
			}
		});
		return false;
	});
	
	//process_login_form
	$('form.login-form').submit(function(){
		var form_data ={
			user_name: $(this).children('.user_name').val(),			
			user_password: $(this).children('.user_password').val(),			
		};		
		
		path = window.location.href;
		path = path.replace("#","");
		
		$.ajax({
			url: path + 'home/process_login_form',
			type: 'POST',
			data: form_data,			
			succes: function(msg){
				alert('Login Succes');			
			},
			error: function(msg){
				alert('There is an error on Login');			
			},
			complete:   function(msg) {
				alert(msg.responseText);
			 // alert('ajax request completed' + msg);
			}
		});
		return false;
	});
	
	//handle image upload to automatically show the selected image
	/* $('#file').change(function(){
		document.getElementById("user_image").src = $('#file').val();
		//process_image();
	});*/	
	$('.wallpapers').removeClass('active');
	$('.' + sessionStorage.getItem('CurrentPage')).addClass('active');
	$('#' + sessionStorage.getItem('CurrentPage')).addClass('selected');
});

function process_image(){
	xhr = createRequest();
	if( xhr == null ){
		alert('Unable to create request');
		return;
	}
	
	xhr.onreadystatechange = function(){
		if( xhr.readyState==4 && xhr.status==200 ){
			document.getElementById("user_image").src = xhr.responseText;
		}
	}
	
	xhr.open("POST", "AjaxPHP/process_image.php", true );
	xhr.send()
	
}

function showNews(str){
	if(str == '') return '';
	
	xhr = createRequest();
	if(xhr == null){
		alert('Unable to create request');
		return;
	}
	
	xhr.onreadystatechange = function(){
		if(xhr.readyState==4 && xhr.status==200) {
			document.getElementById('show_news').innerHTML = xhr.responseText;
		}
	}
	//xhr.open("POST", "design/PHPAjax/process_news.php?news_type=" + str, true);
	var path = window.location.href;
	path = path.replace('#','');
	//alert(path);
	xhr.open("POST", path + "home/process_news?news_type=" + str, true);
	xhr.send();
	
	
}

function process_ajax(send, url, onreadystateHandler){
	xhr = createRequest();
	if( xhr == null ){
		alert('Unable to create request');
		return;
	}
	
	xhr.onreadystatechange = function(){
		if( xhr.readyState==4 && xhr.status==200 ){
			onreadystateHandler();
		}
	}
	
	xhr.open("POST", url, true );
	xhr.send(send);
}
