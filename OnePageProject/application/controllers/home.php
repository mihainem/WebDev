<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	
	function __construct(){
		parent::__construct();
		
		$this->load->model('faqs_model');
		$this->load->model('users_model');
	}
	
	public function index()
	{			
		//get questions and answers lists for the view
		$x['answers_list'] = $this->faqs_model->get($while=false, $answers=true);				
		$x['questions_list'] = $this->faqs_model->get("type=0"); 				
		
		
		$this->load->view('front/index.php', $x);	
	}	
	
	/*
	*	AJAX - PHP FUNCTIONS
	*	this functions are called only with AJAX
	*/	
	public function process_signup_form(){
		//establish rules for every user signup form coming input
		$config=array(
				array(
					 'field'   => 'user_name',
					 'label'   => "Username",
					 'rules'   => 'trim|required|strip_tags'
					),
				array(
					 'field'   => 'user_email',
					 'label'   => "Email",
					 'rules'   => 'trim|required|strip_tags|valid_email'
					),
				array(
					 'field'   => 'user_password',
					 'label'   => "Password",
					 'rules'   => 'trim|required|strip_tags'
					)				
				);
		//apply rules for every user signup form coming input
		$this->form_validation->set_rules($config);	
		
		$username = false;
		
		$data['error'] = '';		
		//if FAQ form submit button is pressed
		//if(isset($_POST['signup_user'])){	
		
		//if input validation passes
		if( $this->form_validation->run() !== FALSE ){		
			
			//process raw input
			$username = trim(strip_tags($_POST['user_name']));
			$email = trim(strip_tags($_POST['user_email']));
			$password = trim(strip_tags($_POST['user_password']));			
			
			//check if mail already exists
			$sql = "SELECT user_email
					FROM ".$this->config->item('table_users')."
					WHERE user_email = '".$email."'
					";
			$query = $this->db->query($sql);
			$result = $query->row_array();
			if( !empty($result) ){
				echo  'This email already exists';
				return;
			}		
			$query->free_result();
			
			//check if user_name already exists
			$sql = "SELECT user_name
					FROM ".$this->config->item('table_users')."
					WHERE user_name = '".$username."'
					";
			$query = $this->db->query($sql);
			$result = $query->row_array();
			if( !empty($result) ){
				echo  'This username already exists';
				return;
			}
			$query->free_result();
			
			//make array with darabase columns
			$temp = array(
				//'faq_id' => $id,
				'user_name' => $username,
				'user_email' => $email,
				'user_password' => sha1($password)					
			);				
			
			//insert temp array in database
			$this->db->insert($this->config->item('table_users'), $temp);
			echo 'Thank you for registering';
		}else{
			echo 'Could not process registration. Please make sure fields are valid';
		}
	}
	
	public function process_login_form(){	
	
		//establish rules for every user signup form coming input
		$config=array(
				array(
					 'field'   => 'user_name',
					 'label'   => "Username",
					 'rules'   => 'trim|required|strip_tags'
					),			
				array(
					 'field'   => 'user_password',
					 'label'   => "Password",
					 'rules'   => 'trim|required|strip_tags'
					)				
				);
		//apply rules for every user signup form coming input
		$this->form_validation->set_rules($config);		
		
		$data['error'] = '';	
		
		//if input validation passes
		if( $this->form_validation->run() !== FALSE ){		
			
			//process raw input
			$username = strtolower(trim(strip_tags($_POST['user_name'])));				
			$password = trim(strip_tags($_POST['user_password']));			
			
			//check if user exists in our db
			$where = "user_password = '".mysql_real_escape_string(sha1($password))."' AND
						user_name = '".$username."'  LIMIT 0,1";
			
			$result = $this->users_model->get($where);
			
			if( count($result[0]) ){				
				$_SESSION['user_name'] = ucfirst($username);
				echo "You logged in successfully";
				return;
			}			
		}		
		echo 'Invalid combination';
	}
	
	public function process_faq_form(){
		//establish rules for every FAQ form coming input
		$config=array(
				array(
					 'field'   => 'username',
					 'label'   => "Username",
					 'rules'   => 'trim|required|strip_tags'
					),
				array(
					 'field'   => 'email',
					 'label'   => "Email",
					 'rules'   => 'trim|required|strip_tags|valid_email'
					),
				array(
					 'field'   => 'message',
					 'label'   => "Message",
					 'rules'   => 'trim|required|strip_tags'
					),
				array(
					 'field'   => 'question_id',
					 'label'   => "Question id",
					 'rules'   => 'trim|strip_tags'
					)					
				);
		//apply rules for every FAQ form coming input
		$this->form_validation->set_rules($config);				
		
		$message = false;
		$username = false;
		
		//if input validation passes
		if( $this->form_validation->run() !== FALSE ){
			$message = 'form_validation';
			//process raw input
			$username = trim(strip_tags($_POST['username']));
			$email = trim(strip_tags($_POST['email']));
			$message = trim(strip_tags($_POST['message']));
			$question_id = (int)trim(strip_tags($_POST['question_id']));
			
			//make array with darabase columns
			$temp = array(
				//'faq_id' => $id,
				'username' => $username,
				'email' => $email,
				'message' => $message,
				'type' => (isset($question_id) && $question_id != -1)? '1': '0'
			);				
			
			//insert temp array in database
			$this->db->insert($this->config->item('table_faqs_details'), $temp);
			//get the modified id from database
			$id = $this->db->insert_id($this->config->item('table_faqs_details'));
			
			//if input is from a reply form or if its an answer input
			if( $question_id != -1 ){
				unset($temp);
				
				//make array with darabase columns
				$temp = array(
					'question_id' => $question_id,
					'answer_id' => $id					
				);		
				
				//insert temp array in database
				$this->db->insert($this->config->item('table_faqs'), $temp);
			}
			//refresh page / clear POST		
			$_SESSION['CurrentPage'] = 'faqs';			
		}else{
			echo 'Username, Email and Message are required';	
		}	
	
		if( $message !== false && $username !== false ){
			if( $question_id != -1 ){
				echo '<li class="answer">	
						<strong>'.htmlentities($username).'</strong> <br >
						'.htmlentities($message).'				
					</li>';
			}else{
				echo '<li>	
						<div class="question">
							<strong>'.htmlentities($username).'</strong> <br >
							'.htmlentities($message).'
						</div>
						<label for="reply'.$id.'">
							<div class="reply">Reply</div>
							<form method="POST" class="reply-form faq-form" >
								<input type="text" class="username" name="username" placeholder="Username">
								<input type="email" class="email" name="email" placeholder="Email">	<div class="exit pull-right">X</div> <br >								
								Message: <br >
								<textarea class="message" name="message" cols="50" rows="3"> </textarea> <br >
								<input type="hidden" class="question_id" name="question_id" value="'.$id.'">								
								<input type="submit" id="submit_answer" name="submit" value="Answer">
							</form>	
						</label>	
						<ul id="answers'.$id.'">	</ul>
					</li>';
			}
		}
	
	}
	
	function process_news(){
		$news_type='';
		if( !isset($_REQUEST['news_type']) ):
			header('Location: ' .$this->config->item('root_url'));			
			die();
		endif;
		
		
		$news_type = $_REQUEST['news_type'];

			
		$news_url = array(
			'applications' => 'http://www.infoworld.com/category/applications/index.rss',
			'security' => 'http://www.infoworld.com/category/security/index.rss',
			'networking' => 'http://www.infoworld.com/category/networking/index.rss',
		);	
		
		if( empty($news_url[$news_type]) ) {
			echo "Cant't find this type of news";
			return;
		}
		
		$xml = $news_url[$news_type];
		
		$xmlDoc = new DOMDocument();
		$xmlDoc->load($xml);
		
		$x = $xmlDoc->getElementsByTagName('item');
		
		echo '<ul>';
		for($i=0; $i<=3; $i++){
			$item_title=$x->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
			$item_link=$x->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;
			$item_desc=$x->item($i)->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue;			
			
			echo "<li>
					<a href='".$item_link."'>". $item_title. "</a> 
					<br>"
					.substr($item_desc, 0, 400).'...'.
				"</li>";		
		}
		echo '</ul>';
		}
}

/* End of file home.php */
/* Location: ./applicatio*/