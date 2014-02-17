</div>
<footer>
	<div class="bgc-limon-pastel" id="foot-first">
		<div  class="container">
			<fieldset>
					<legend>Redes Sociales</legend>
					<div class="g-ytsubscribe" data-channel="diarioesnoticiatv" data-layout="full" data-count="hidden"></div>
					<?php if(!is_home()) {?>
						<div class="fb-like-box" data-href="http://www.facebook.com/DiarioEsNoticia" data-colorscheme="light" data-show-faces="false" data-header="false" data-stream="false" data-show-border="false"></div>
					<?php }?>
			</fieldset>
		</div>
	</div>
	<div class="bgc-rojo-oscuro" id="foot-second" style="padding:30px 0px 5px">
		<div  class="container">
			<div class="col-lg-4 col-md-4 col-xs-12 col-sm-12 panel">  
        		<!--Newsletter-->
				<form role="newsletter" method="get" id="newsletterform" class="col-md-12 col-lg-12 panel-body" action="<?php echo get_option('home'); ?>" >
					<h4 class="text-info foot-font text-center"><span class="fa fa-pencil"></span> Suscribite</h4>
					<div class="input-group">
						<input type="text" value="" name="sn" id="sn" class="form-control" placeholder="tuemail@dominio.com">
						<span class="input-group-btn">
							<button class="btn btn-default" type="button" title="Confirmar Suscripcion" alt="OK" ><span class="glyphicon glyphicon-ok-sign"></span></button>
						</span>
					</div>
					<div class="hr"></div>
				</form>
				<!--/Newsletter-->
        	</div>
        </div>
	</div>
</footer>
<?php wp_footer(); ?>
<?php $_SESSION['exclude']=array();?>
<script type="text/javascript">
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-35013979-5']);
	_gaq.push(['_setDomainName', 'diarioesnoticia.com']);
	_gaq.push(['_trackPageview']);
	(function() {
	 var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	 ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	 var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
</script>
</body>
</html>