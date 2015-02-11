<?php
	
 if( !isset($_SESSION['CurrentPage']) || empty($_SESSION['CurrentPage'])):  
	$_SESSION['CurrentPage'] = 'wallpapers'; 
endif;
?>
<!DOCTYPE html>
<html>
<head>
		<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="<?php echo $this->config->item('base_url')?>design/css/bootstrap.min.css">
	<link type="text/css" rel="stylesheet" href="<?php echo $this->config->item('base_url')?>design/css/style.css"/>
	
</head>
<body>
     <!--Add your own HTML!--> 
        <div class="header">
        <canvas id="canvas" class="logo pull-left" width="50" height="50"></canvas>			
            <div  class="menu pull-right">
                <ul>
                    <li id="wallpapers"><a href="#">Wallpapers</a></li>
                    <li id="news" ><a href="#">News</a></li>
                    <li id="faqs" ><a href="#">FAQs</a></li>            
                    <li id="sign-up" ><a href="#">Sign Up</a></li>            
                </ul>
            </div>
        </div>
        
        <div class="main">			
            <div class="wallpapers <?php echo (isset($_SESSION) && $_SESSION['CurrentPage']==='wallpapers')?'active':''?>">			
                <h1>Wallpapers</h1>
                <ul>
                    <li><img id="1" src="http://www.joomlaworks.net/images/demos/galleries/abstract/7.jpg"></li>
                    <li><img id="2" src="http://assets3.parliament.uk/iv/main-large//ImageVault/Images/id_7382/scope_0/ImageVaultHandler.aspx.jpg"></li>
                    <li><img id="3" src="http://farm9.staticflickr.com/8378/8559402848_9fcd90d20b_b.jpg"></li>                                   
                    <li><img id="4" src="http://www.wonderplugin.com/wp-content/plugins/wonderplugin-lightbox/images/demo-image2.jpg"></li>
                    <li><img id="5" src="http://blogs.biomedcentral.com/bmcblog/files/2014/02/Benjamin-Blonder.png"></li>
                    <li><img id="6" src="http://rack.2.mshcdn.com/media/ZgkyMDEzLzA3LzIyL2JjL2ltYWdlX2VkaXRvLjdkMjFmLmpwZwpwCXRodW1iCTk1MHg1MzQjCmUJanBn/ddd7d15b/14a/image_editor.jpg"></li>
                    <li><img id="7" src="http://www.joomlaworks.net/images/demos/galleries/abstract/7.jpg"></li>
                    <li><img id="8" src="http://assets3.parliament.uk/iv/main-large//ImageVault/Images/id_7382/scope_0/ImageVaultHandler.aspx.jpg"></li>
                    <li><img id="9" src="http://farm9.staticflickr.com/8378/8559402848_9fcd90d20b_b.jpg"></li>                                   
                    <li><img id="10" src="http://www.wonderplugin.com/wp-content/plugins/wonderplugin-lightbox/images/demo-image2.jpg"></li>
                    <li><img id="11" src="http://blogs.biomedcentral.com/bmcblog/files/2014/02/Benjamin-Blonder.png"></li>
                    <li><img id="12" src="http://rack.2.mshcdn.com/media/ZgkyMDEzLzA3LzIyL2JjL2ltYWdlX2VkaXRvLjdkMjFmLmpwZwpwCXRodW1iCTk1MHg1MzQjCmUJanBn/ddd7d15b/14a/image_editor.jpg"></li>                    
                </ul>
                <div id="front-frame">
                    <img src="">
                </div>
                <div id="back-frame"></div>
			
			<?php /*	<div>
					<form action="" method="POST" enctype="multipart/form-data" >
					<p>
						<input type="file" style="visibility:hidden;" id="file" name="file" />
						<input type="button" id="button_add_file" value="Upload an Image!"  class="col-sm-12" />								
					</p>
					</form>
				</div>
				*/ ?>
            </div>
            <div class="news" <?php echo (isset($_SESSION) && $_SESSION['CurrentPage']=='news')?'active':''?>>
                <h2>News</h2>
				<select name="news_type" onchange="showNews(this.value)">
					<option value=""> Select Type of News </option>
					<option value="applications">Applications</option>
					<option value="security">Security</option>
					<option value="networking">Networking</option>
				</select>
				
				<div id="show_news"></div>
				
            </div>
            <div class="faqs" <?php echo (isset($_SESSION) && $_SESSION['CurrentPage']=='faqs')?'active':''?>>
                <h2>FAQ's</h2>
				<?php  if ( !empty($questions_list)) :?>
				<ul id="questions">
					<?php foreach ($questions_list as $key=>$value ):?>
					<li>
						<div class="question">
							<strong><?php echo htmlentities($value['username'], ENT_NOQUOTES, 'UTF-8'); ?></strong>
							<?php // echo htmlentities($value['email'], ENT_NOQUOTES, 'UTF-8'); ?> <br>
							<?php echo htmlentities($value['message'], ENT_NOQUOTES, 'UTF-8'); ?>						
						</div>					
						
						<label for="reply<?php echo $value['faq_id']; ?>">
							<div class="reply">Reply</div>
							<form method="POST" class="reply-form faq-form" >
								<input type="text" class="username" name="username" placeholder="Username">
								<input type="email" class="email" name="email" placeholder="Email">	<div class="exit pull-right">X</div> <br >								
								Message: <br >
								<textarea class="message" name="message" cols="50" rows="3"> </textarea> <br >
								<input type="hidden" class="question_id" name="question_id" value="<?php echo $value['faq_id']; ?>">								
								<input type="submit" id="submit_answer" name="submit" value="Answer">
							</form>	
						</label>					
						
						<ul id="answers<?php echo $value['faq_id']?>">
							<?php if( isset($answers_list[$value['faq_id']]) && !empty($answers_list[$value['faq_id']]) ):?>
							<?php foreach($answers_list[$value['faq_id']] as $index=>$item): ?>
								<li class="answer">									
									<strong><?php echo htmlentities($item['username'], ENT_NOQUOTES, 'UTF-8'); ?></strong>
									<?php // echo htmlentities($item['email'], ENT_NOQUOTES, 'UTF-8'); ?> <br>
									<?php echo htmlentities($item['message'], ENT_NOQUOTES, 'UTF-8'); ?>
								</li>
							<?php endforeach;?>												
						<?php endif;?>					
						</ul><br >
					</li>
					<?php endforeach; ?>
				</ul> 
				<?php  endif; ?>
				<div id="add_question">
					<p>Add a new question: </p>
					<form method="POST" id="add_question" class="faq-form" class="form-inline">
						<input type="text" class="username" name="username" placeholder="Username"> <br >
						<input type="email" class="email" name="email" placeholder="Email">	<br >
						Message: <br >
						<textarea class="message" name="message" cols="25" rows="3"> </textarea> <br>
						<input type="hidden" class="question_id" name="question_id" value="-1">						
						<input type="submit" id="submit_question" name="submit" value="Submit Question">
					</form>
				</div>
            </div>
            <div class="sign-up" <?php echo (isset($_SESSION) && $_SESSION['CurrentPage']=='sign-up')?'active':''?>>                
				<?php if ( isset($_SESSION['user_name']) ): ?>
					<div class="col-xs-12 big-text">
						<?php echo 'Hello '.$_SESSION['user_name'];?> <br >
						<?php echo 'Have fun on this site'; ?>
					</div>
				<?php else: ?>
					<div class="col-sm-6">
						<h2>Sign Up</h2>
						<form method="POST" class="signup-form">
							<input type="text" class="user_name" placeholder="Username"><br>
							<input type="text" class="user_email" placeholder="Email"><br>
							<input type="password" class="user_password" placeholder="Password">
							<input type="submit" name="signup_user" value="SignUp">
						</form>
					</div>
					<div class="col-sm-6">
						<h2>Login</h2>
						<form method="POST" class="login-form">
							<input type="text" class="user_name" placeholder="Username"><br>
							<input type="password" class="user_password" placeholder="Password"><br>		
							<input type="submit" name="login_user" value="Login">
						</form>
					</div>
				<?php endif; ?>
            </div>
        </div>
		
		
        <div class="footer menu">            
		<marquee style="background: yellow; color: black" scrollamount="3px" direction="left"><a href="#" style="color: black">Click Me!</a>	I'm not a link</marquee>
                <ul>
                    <li id="codecademy"><a href="#">CodeCademy</a></li>
                    <li id="coderbyte"><a href="#">Coderbyte</a></li>
                    <li id="khanacademy"><a href="#">KhanAcademy</a></li>            
                    <li id="microsoft-virtual-academy"><a href="#">Microsoft Virtual Academy</a></li>
                </ul>                        
        </div>       

	<script src="<?php echo $this->config->item('base_url')?>design/js/jquery.min.js"></script>
	<script src='<?php echo $this->config->item('base_url')?>design/js/script.js'></script>
	<script src='<?php echo $this->config->item('base_url')?>design/js/requester.js'></script>
</body>
</html>