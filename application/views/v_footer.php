<div class="footer">
	<div class="footer-inner">
		 2018 &copy; Direct Parking Admin Panel.
	</div>
	<div class="footer-tools">
		<span class="go-top">
			<i class="fa fa-angle-up"></i>
		</span>
	</div>
</div>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="assets/plugins/respond.min.js"></script>
<script src="assets/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="<?php echo site_url(); ?>assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?php echo site_url(); ?>assets/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>assets/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>assets/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>

<link href="<?php echo site_url(); ?>assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css"/>

<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<!--script src="<?php echo site_url(); ?>assets/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>assets/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>assets/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>assets/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>assets/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script-->
<script src="<?php echo site_url(); ?>assets/plugins/jquery.pulsate.min.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo site_url(); ?>assets/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>assets/plugins/gritter/js/jquery.gritter.js" type="text/javascript"></script>
<!-- IMPORTANT! fullcalendar depends on jquery-ui-1.10.3.custom.min.js for drag & drop support -->
<script src="<?php echo site_url(); ?>assets/plugins/fullcalendar/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>assets/plugins/jquery-easy-pie-chart/jquery.easy-pie-chart.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>assets/plugins/jquery.sparkline.min.js" type="text/javascript"></script>

<script type="text/javascript" src="<?php echo site_url(); ?>assets/plugins/fancybox/source/jquery.fancybox.pack.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo site_url(); ?>assets/scripts/core/app.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>assets/scripts/custom/index.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>assets/scripts/custom/tasks.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->


<script src="<?php echo site_url(); ?>assets/plugins/bootstrap-markdown/js/bootstrap-markdown.js" type="text/javascript"></script>

<!-- END PAGE LEVEL PLUGINS -->
<script>
jQuery(document).ready(function() { 
   
   getNotifications();
      
   App.init(); // initlayout and core plugins
   Index.init();
   //Index.initJQVMAP(); // init index page's custom scripts
   Index.initCalendar(); // init index page's custom scripts
   Index.initCharts(); // init index page's custom scripts
   Index.initChat();
   Index.initMiniCharts();
   //Index.initDashboardDaterange();
  // Index.initIntro();
   Tasks.initDashboardWidget();
   //TableEditable.init();
});

setInterval(function(){ 
      getNotifications();
}, 5000);

function getNotifications(){

      var dataToSend = '';
      $.ajax({
         url: URL +"welcome/getNotifications", 
         type: "post", 
         data: dataToSend,     
         dataType: 'json',
         success: function(results) {
            console.log(results);
            if(results == false)
            {
               var htmlStr = '';
               htmlStr = '<li><div class="alert alert-success fade in"><a href="#"> No notification</a></div></li>';
               $('#notificationListId').html(htmlStr);
               $('#notificationListId').show();
            }
            else
            {
            var htmlStr = '';
            var notiCount = results.length;
            if(notiCount > 0){
               $('#notiBell').show();
               //$('#notiRow').show();
               $('.notiCount').html(notiCount);
            }else{
               $('#notiBell').hide();
               //$('#notiRow').hide();
               $('.notiCount').html();
            }
      $.each(results, function(k, v){
         
                     if(v.noti_type == 1){
               htmlStr += '<li><a href="'+URL+'order/view?oid='+v.related_base64+'"><span class="label label-sm label-icon label-success"><i class="fa fa-plus"></i></span>New order request. Order #: PMK'+v.order_id + '</a></li>';
                  }else if(v.noti_type == 2){
                htmlStr += '<li><a href="'+URL+'user/view?id='+v.related_base64+'"><span class="label label-sm label-icon label-primary"><i class="fa fa-user-plus"></i></span>New User <b>'+v.data.fname+' '+v.data.lname+'</b> has been registered.</a></li>';
                  }else if(v.noti_type == 3){
                htmlStr += '<li><a href="'+URL+'user/view?id='+v.user_base64+'"><span class="label label-sm label-icon label-danger"><i class="fa fa-question-circle "></i></span>New Ride request of <b>'+v.data.fname+' '+v.data.lname+'</b>  .</a></li>';
                  }else if(v.noti_type == 4){
                htmlStr += '<li><a href="'+URL+'bid?id='+v.related_base64+'"><span class="label label-sm label-icon label-danger"><i class="fa fa-gavel"></i></span><b>'+v.data.fname+' '+v.data.lname+'</b> bided for product.</a></li>';
                  }else if(v.noti_type == 5){
                htmlStr += '<li><a href="'+URL+'quote"><span class="label label-sm label-icon label-danger"><i class="fa fa-list"></i></span><b>'+v.data.fname+' '+v.data.lname+'</b> asked for quote.</a></li>';
                  }
           
      });
               console.log(htmlStr);
               
            $('#notificationListId').html(htmlStr);
            $('#notificationListId').show();
            }
        },
        error: function(e) {
        }
      });

}
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>