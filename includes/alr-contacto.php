<?php
if(isset($_POST['buttonSend'])){
	$Mail=get_option( 'admin_email' );;
	$Web="http://{$_SERVER['SERVER_NAME']}";
	$n=((isset($_POST['inputName']))&&(trim($_POST['inputName'])!=""))?htmlentities($_POST['inputName']):false;
	$e=((isset($_POST['inputEmail']))&&(trim($_POST['inputEmail'])!=""))?htmlentities($_POST['inputEmail']):false;
	$t=((isset($_POST['inputPhone']))&&(trim($_POST['inputPhone'])!=""))?htmlentities($_POST['inputPhone']):"-";
	$c=((isset($_POST['inputSubject']))&&(trim($_POST['inputSubject'])!=""))?htmlentities($_POST['inputSubject']):false;
	$m=((isset($_POST['inputMessage']))&&(trim($_POST['inputMessage'])!=""))?htmlentities($_POST['inputMessage']):false;
	if($n!=false && $e!=false && $c!=false && $m!=false){					
		$cuerpoMail="
	<html>
	  <head>
			<style type='text/css'>
			html{padding:0px; margin:0px;border:none; font-family: Trebuchet MS}
			body{padding:0px;margin:0px;background:none repeat scroll 0% 0% rgb(238, 238, 238);}
			section{text-align:justify; padding:50px 20px;color:#04a;}
			footer{min-height: 30px; padding:25px;background-color:rgba(0,80,160,0.6);text-align: center; }
			a, a:link, a:visited {color:rgb(0, 106, 187);} 
			p{font-size:14px;color: #444;}
			p.message{font-size:16px;}
			section h3{margin-bottom: 15px;font-size:16px;color:#444;}
			footer a, footer a:link, footer a:visited {text-decoration: none;color: #fff;}
			</style>
		  	<meta http-equiv='content-type' content='text/html; charset=UTF-8'>
	  </head>
	  <body>
	   <section>
	      <p class=\"message\"> Acabas de recibir una Consulta: {$c}</p>
	      <h3><strong>Datos de la consulta</strong></h3>
	      <p><strong>Nombre:</strong> {$n}</p>
	      <p><strong>Asunto:</strong> {$c}</p>
	      <p><strong>E-Mail:</strong> {$e}</p>
	      <p><strong>Telefono:</strong> {$t}</p>
	      <p><strong>Mensaje:</strong> {$m}</p>
	      <br>
	      <p>Este es un mensaje generado automaticamente por el sistema.</p> 
	 		</section>
	 	<footer>
	 		<p class=\"pfooter\">Copyright &reg; Aliweb, 2013. Todos los derechos reservados.</p>
	 	</footer>
	  </body>
	</html>";
	
		$encabezados = "From: no-reply -Diario EsNoticia<no-reply@diarioesnoticia.com>\nContent-Type: text/html; charset=utf-8";
		if($MailSend=mail($Mail, "Formulario Contacto Web", $cuerpoMail, $encabezados)){?>
<div class="alert alert-success alert-dismissable">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
Mensaje enviado con exito. En breve responderemos, desde ya muchas gracias.
</div>
		<?php }else{ ?>
<div class="alert alert-danger alert-dismissable">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
Mensaje no enviado. Lamentamos informar que durante el envio del mensaje se produjo un error, intentelo nuevamente.
</div>
		<?php	}
	}else {?>
<div class="alert alert-danger alert-dismissable">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
Mensaje no enviado. Uno o mas campos no fueron completados correctamente.
</div>
	<?php }
} ?>