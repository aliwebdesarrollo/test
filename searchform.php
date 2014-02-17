<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
<!--Buscador de noticias-->
<div class="panel-section bgc-celeste-pastel"><h3 class="panel-title">BUSCADOR DE NOTICIAS</h3></div>
	<div class="panel-body">
	<?php if(isset($_GET['s'])){?>
		<div class="alert alert-danger alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			No se encontraron resultados para la busqueda de <strong><?php echo $_GET['s']; ?></strong>
			</div>
	<?php } ?>
	<form method="get" id="SearchForm" action="<?php echo get_option('home'); ?>" class="form-horizontal" role="search">
		<div class="form-group">
			<label for="inputName" class="col-lg-1 control-label">Buscar</label>
			<div class="col-lg-11">
				<input type="text" class="form-control" name="s" id="s" value='<?php echo $_GET["s"]?>' placeholder="Ingrese palabras a buscar" required>
			</div>
		</div>
		<div class="form-group text-right">
			<div class="col-lg-offset-2 col-lg-10">
				<button type="submit" class="btn btn-primary">Buscar</button>
				<button type="reset" class="btn btn-danger">Limpiar</button>
			</div>
		</div>
</form>
<!--/Buscador de noticias-->
	</div>
</div>