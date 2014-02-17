<?php
$Mail="prensa@diarioesnoticia.com";
$Web="http://{$_SERVER['SERVER_NAME']}";
if(isset($_POST['SendMail'])) 
{
	if(isset($_POST['Cont_name'])&&(trim($_POST['Cont_name'])!=""))
	{
		if(isset($_POST['Cont_apellido'])&&(trim($_POST['Cont_apellido'])!=""))
		{
			if(isset($_POST['Cont_email'])&&(trim($_POST['Cont_email'])!=""))
			{
				if(isset($_POST['Cont_msj'])&&(trim($_POST['Cont_msj'])!=""))
				{
					$n=(isset($_POST['Cont_name']))?htmlentities($_POST['Cont_name']):"-";
					$e=(isset($_POST['Cont_email']))?htmlentities($_POST['Cont_email']):"-";
					$t=(isset($_POST['Cont_tel']))?htmlentities($_POST['Cont_tel']):"-";
					$c=(isset($_POST['Cont_apellido']))?htmlentities($_POST['Cont_apellido']):"-";
					$m=(isset($_POST['Cont_msj']))?htmlentities($_POST['Cont_msj']):"-";
						
					$MailSistema="
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
					      <p><strong>Apellido:</strong> {$c}</p>
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
					if($MailSend=mail($Mail, "Formulario Contacto Web", $MailSistema, $encabezados))
					{
						?>
	<div id="ContactoMsjConf">
		<h3 id="title-msj">SU MENSAJE FUE ENVIADO CON EXITO</h3>
		<p>En breve responderemos, desde ya muchas gracias.</p>
	</div>
						<?php			
					}else 
					{
						?>
	<div id="ContactoMsjConf">
		<h3 id="title-msj">SU MENSAJE NO FUE ENVIADO</h3>
		<p>Lamentamos informar que durante el envio del mensaje se produjo un error, intentelo nuevamente.</p>
	</div>
						<?php
					}
				}else
				{
					?>
	<div id="ContactoMsjConf">
		<h3 id="title-msj">SU MENSAJE NO FUE ENVIADO</h3>
		<p>Lamentamos informar que durante el envio del mensaje se produjo un error, intentelo nuevamente.</p>
		<p>Campo Mensaje - Ingreso Invalido</p>
	</div>
					<?php
				}
			}else
			{
				?>
	<div id="ContactoMsjConf">
		<h3 id="title-msj">SU MENSAJE NO FUE ENVIADO</h3>
		<p>Lamentamos informar que durante el envio del mensaje se produjo un error, intentelo nuevamente.</p>
		<p>Campo E-Mail - Ingreso Invalido</p>
	</div>
				<?php
			}
		}else
		{
			?>
	<div id="ContactoMsjConf">
		<h3 id="title-msj">SU MENSAJE NO FUE ENVIADO</h3>
		<p>Lamentamos informar que durante el envio del mensaje se produjo un error, intentelo nuevamente.</p>
		<p>Campo Apellido - Ingreso Invalido</p>
	</div>
			<?php
		}
	}else
	{
		?>
	<div id="ContactoMsjConf">
		<h3 id="title-msj">SU MENSAJE NO FUE ENVIADO</h3>
		<p>Lamentamos informar que durante el envio del mensaje se produjo un error, intentelo nuevamente.</p>
		<p>Campo Nombre - Ingreso Invalido</p>
	</div>
		<?php
	}	
}
?>