<?php
/*------------------------------------------------------------------------
# Aliweb Responsive V1.0 Febrero 2014
# ------------------------------------------------------------------------
# Template Name: Contacto
# Copyright (C) 2013 Aliweb Desarrollo. All Rights Reserved.
# @licencia - Aliweb Responsive Theme esta protegida bajo los terminos de las licencias GNU General Public License.
# Autor: http://www.aliweb.com.ar - Juan Manuel Piñeiro
-------------------------------------------------------------------------*/
if(is_page()) 
{
get_header();
?>
<div id="Cnt-Page" class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
	<div class="panel-section bgc-rojo-pastel"><h3 class="panel-title">FORMULARIO DE CONTACTO</h3></div>
	<div class="panel-body">
		<?php	include_once "includes/alr-contacto.php";	?>
		<form name="contactform" method="post" class="form-horizontal" role="form">
			<div class="form-group">
				<label for="inputName" class="col-lg-2 control-label">Nombre</label>
				<div class="col-lg-10">
					<input type="text" class="form-control" id="inputName" name="inputName" placeholder="Ingrese su nombre" required>
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail1" class="col-lg-2 control-label">E-mail</label>
				<div class="col-lg-10">
					<input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="Ingrese su e-mail" required>
				</div>
			</div>
			<div class="form-group">
				<label for="inputSubject" class="col-lg-2 control-label">Telefono</label>
				<div class="col-lg-10">
					<input type="tel" class="form-control" id="inputPhone" name="inputPhone" placeholder="Ingrese su telefono">
				</div>
			</div>
			<div class="form-group">
				<label for="inputSubject" class="col-lg-2 control-label">Asunto</label>
				<div class="col-lg-10">
					<input type="text" class="form-control" id="inputSubject" name="inputSubject" placeholder="Ingrese el asunto" required>
				</div>
			</div>
			<div class="form-group">
				<label for="inputPassword1" class="col-lg-2 control-label">Mensaje</label>
				<div class="col-lg-10">
					<textarea class="form-control" rows="4" id="inputMessage" name="inputMessage" placeholder="Ingrese su mensaje..." required></textarea>
				</div>
			</div>
			<div class="form-group text-right">
				<div class="col-lg-offset-2 col-lg-10">
					<button type="submit" class="btn btn-primary" id="buttonSend" name="buttonSend">Enviar</button>
					<button type="reset" class="btn btn-danger">Limpiar</button>
				</div>
			</div>
		</form>
	</div>
</div>
<?php
	get_template_part( 'sidebar',"page" );

	get_footer();
}else 
{
	header("LOCATION:".home_url());
}	 

?>