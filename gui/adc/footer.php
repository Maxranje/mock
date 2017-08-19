</section></section></section>
<div class="modal fade" id="tip-msg">
	<div class="modal-dialog"><div class="modal-content">
	<div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	<h4 class="modal-title"> Message</h4></div>	
    <div class="modal-body">
		<p class="text-center wrapper-lg dialog-info m-t-n"></p>
	</div>
</div></div></div>
<script src="/res/js/jquery/jquery-1.11.2.min.js"></script>
<script src="/res/js/app.min.js"></script>
<!-- <script src="/res/js/fuelux/fuelux.js" cache="false"></script> -->
<script src="/res/js/script/common.js"></script>
<script type="text/javascript">
$(function (){
	$('.'+G.get('nav_name')).addClass('active');
	$('.refresh').on('click', function (){
		window.location.reload(true);
	});
});
</script>