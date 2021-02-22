<?php  

	require "./bibliotecas/PHPMailer/Exception.php";
	require "./bibliotecas/PHPMailer/OAuth.php";
	require "./bibliotecas/PHPMailer/PHPMailer.php";
	require "./bibliotecas/PHPMailer/POP3.php";
	require "./bibliotecas/PHPMailer/SMTP.php";

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	class Mensagem {
		private $name = null;
		private $email = null;
		private $site = null;
		private $message = null; 
		public $status = array('codigo_status' => null, 'descricao_status' => '');

		public function __get($attr) {
			return $this->$attr;
		}

		public function __set($attr, $valor) {
			$this->$attr = $valor;
		}

		public function mensagemValida() {
			if(empty($this->name) || empty($this->email) || empty($this->message)){
				return false;
			}

			return true;
		}
	}

	$mensagem = new Mensagem();

	$mensagem->__set('name', $_POST['name']);
	$mensagem->__set('email', $_POST['email']);
	$mensagem->__set('site', $_POST['site']);
	$mensagem->__set('message', $_POST['message']);

	if(!$mensagem->mensagemValida()){
		echo 'Mensagem não é valida ';
		header('location: ./index.php');
	} 

	$mail = new PHPMailer(true);

	try {
	    //Server settings
	    $mail->SMTPDebug = false;//SMTP::DEBUG_SERVER;                       // Enable verbose debug output
	    $mail->isSMTP();                                            // Send using SMTP
	    $mail->Host       = 'smtp.gmail.com';                     // Set the SMTP server to send through
	    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
	    $mail->Username   = '?';           // SMTP username
	    $mail->Password   = '?';                        // SMTP password
	    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;		// Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
	    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

	    $mail->SMTPOptions = array(
		    'ssl' => array(
		        'verify_peer' => false,
		        'verify_peer_name' => false,
		        'allow_self_signed' => true
		    )
		);

	    //Recipients
	    $mail->setFrom($mensagem->__get('email'), $mensagem->__get('email'));
	    $mail->addAddress('bruno.cheffer.cv@gmail.com', 'Bruno Cheffer Belinassi');     // Add a recipient
	    $mail->addReplyTo($mensagem->__get('email'), $mensagem->__get('name'));
	    //$mail->addCC('cc@example.com');
	    //$mail->addBCC('bcc@example.com');

	    // Attachments
	    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
	    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

	    // Content
	    $mail->isHTML(true);                                  // Set email format to HTML
	    $mail->Subject = 'Site blog de portfolio';
	    $msg = 'Nome: ' . $mensagem->__get('name') . '<br />E-mail: ' . $mensagem->__get('email') . '<br />Site: ' . $mensagem->__get('site') . '<br /> <br />Assunto: <br />' . $mensagem->__get('message');
	    $mail->Body    = $msg;
	    $mail->AltBody = $mensagem->__get('message');

	    $mail->send();

	    $mensagem->status['codigo_status'] = 1;
	    $mensagem->status['descricao_status'] = 'E-mail enviado com sucesso!';
	    
	} catch (Exception $e) {
		$mensagem->status['codigo_status'] = 2;
	    $mensagem->status['descricao_status'] = 'Não foi possível enviar este e-mail. <hr />Mailer Error: ' . $mail->ErrorInfo;
	}
	

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<!-- Author -->
	<link rel="Bruno Cheffer Belinassi" href="https://www.linkedin.com/in/bruno-cheffer-belinassi-2a228165/"/>


	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

     <!-- FontAwseen CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"> <!--load all styles -->

    <!-- HTML5Shiv -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <![endif]-->

    <!-- Customized Style -->
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <!-- script -->
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<script src="js/script.js"></script>

	<title>Bruno Cheffer Belinassi</title>

</head>
<body>
	<header> <!-- start header -->

		<nav class="navbar navbar-expand-lg navbar-light fixed-top navbar-transparente"> <!-- start nav -->
			<div class="container d-flex"> <!-- start container -->
				<a href="index.php" class="navbar-brand">
	    		Home
	  		</a>  
	  		<span class="navbar-brand d-none d-md-block">|</span>
	  		<a href="#" id="idPagJogos" class="navbar-brand">
	    		Jogos
	  		</a> 
	  		<span class="navbar-brand d-none d-md-block">|</span>
	  		<a href="#" id="idPagProjetos" class="navbar-brand">
	    		Projetos
	  		</a>  

	  		<button class="navbar-toggler" data-toggle="collapse" data-target="#nav-main">
	  			<i class="fas fa-bars text-white"></i>          			
	  		</button>

	  		<div class="collapse navbar-collapse" id="nav-main">
	  			<ul class="nav navbar-nav ml-auto">
	  				<li class="nav-item">
	  					<a href="https://pt-br.facebook.com/bcheffer" target="_blank" class="nav-link">
	  						<i class="fab fa-facebook text-primary"></i>
	  					</a>
	  				</li>      			
	  			
	  				<li class="nav-item">
	  					<a href="https://br.linkedin.com/in/bruno-cheffer-belinassi-2a228165" target="_blank" class="nav-link">
	  						<i class="fab fa-linkedin text-primary"></i>
	  					</a>
	  				</li>      			
	  			
	  				<li class="nav-item">
	  					<a href="https://github.com/cheffer" target="_blank" class="nav-link">
	  						<i class="fab fa-github"></i>
	  					</a>
	  				</li>
	  			</ul>
	  		</div>
			</div>	 <!-- end container -->		
		</nav> <!-- end nav -->		
	</header> <!-- end header -->

	<div class="menu_top">
	  <div class="container"> <!-- start container top -->   
	      <div>
	        <img src="img/avatar.jpg" class="rounded-circle shadow p-1" width="120">              
	      </div>
	      <div>
	        <h2>Bruno Cheffer Belinassi</h2>
	        <p>Site com trabalhos em que participei no desenvolvimento</p>
	      </div>              
	    </div> <!-- end container top --> 
	</div> <!-- end div menu-top -->  

	<section id="home"> <!-- start section home -->	
		<div class="container section-container">
			<div class="row">
				<div class="col-sm-11 col-md-8">
					
					<? if($mensagem->status['codigo_status'] == 1) { ?>

						<div class="container">
							<div class="row">
								<div class="col-md-11 col-xl-11 pl-4 ">
									<h1 class="display-4 text-success">Sucesso!</h1>
									<p><?= $mensagem->status['descricao_status'] ?></p>								
								</div>
								
								<div class="marker col-md-11 col-xl-11 text-white">
									<?php $msg = 'Nome: ' . $mensagem->__get('name') . '<br />E-mail: ' . $mensagem->__get('email') . '<br />Site: ' . $mensagem->__get('site') . '<br /> <br />Assunto: <br />' . $mensagem->__get('message');
									 echo $msg
									 ?>
								</div>
								
							</div>
							
						</div>

					<? } ?>

					<? if($mensagem->status['codigo_status'] == 2) { ?>

						<div class="container">
							<h1 class="display-4 text-danger">Ops!</h1>
							<p><?= $mensagem->status['descricao_status'] ?></p>							
						</div>

					<? } ?>	


				</div>
			</div>			
		</div>	
	</section> <!-- end section home -->	

</body>
</html>




