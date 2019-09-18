<style type="text/css">
    .tasks-widget .task-list li > .task-checkbox2 {
    float: left;
    width: 120px;
}
</style>
<div class="page-content-wrapper">
        <div class="page-content">
            
            
            <div class="row">
                <div class="col-md-12">
                    <h3 class="page-title">
                    Dashboard 
                    </h3>
                    <ul class="page-breadcrumb breadcrumb">
                        <li>
                            <i class="fa fa-home"></i>
                            <a href="<?php echo site_url(); ?>">
                                Home
                            </a>
                            <i class="fa fa-angle-right"></i>
                        </li>
                        <li>
                            <a href="#">
                                Dashboard
                            </a>
                        </li>
                        <!-- <li class="pull-right">
                            <div id="dashboard-report-range" class="dashboard-date-range tooltips" data-placement="top" data-original-title="Change dashboard date range">
                                <i class="fa fa-calendar"></i>
                                <span>
                                </span>
                                <i class="fa fa-angle-down"></i>
                            </div>
                        </li> -->
                    </ul>
                    
                </div>
            </div>


            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat blue">
                        <div class="visual">
                            <i class="fa fa-users"></i>
                        </div>
                        <div class="details">
                            <div class="number" id="newUsers">
                                 <?php echo $totalUniversities; ?>
                            </div>
                            <div class="desc">
                                 Total Universities
                            </div>
                        </div>
                        <a class="more" href="<?php echo site_url(); ?>user">
                             View more <i class="m-icon-swapright m-icon-white"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat green">
                        <div class="visual">
                            <i class="fa fa-shopping-cart"></i>
                        </div>
                        <div class="details">
                            <div class="number" id="orders">
                                 <?php echo $students; ?>
                            </div>
                            <div class="desc">
                                 Total Students
                            </div>
                        </div>
                        <!--a class="more" href="<?php echo site_url(); ?>order/?order_status=1"-->
                        <a class="more" href="#">
                             View more <i class="m-icon-swapright m-icon-white"></i>
                        </a>
                    </div>
                </div>

            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="dashboard-stat yellow">
                        <div class="visual">
                            <i class="fa fa-bar-chart-o"></i>
                        </div>
                        <div class="details">
                            <div class="number" id="totalProfit"> 0
                            <?php //echo  round($totalProfit['net_amount'],2); ?>
                            </div>
                            <div class="desc">
                                 Total Completed Rides
                            </div>
                        </div>
                        <a class="more" href="#">
                             View more <i class="m-icon-swapright m-icon-white"></i>
                        </a>
                    </div>
            </div>


            
        </div>

        <div class="row">

        <div class="col-md-12 col-sm-12">
                    <div class="portlet box green tasks-widget">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-check"></i>Active Universities Detail
                            </div>
                            <!--div class="tools">
                                <a href="#portlet-config" data-toggle="modal" class="config">
                                </a>
                                <a href="" class="reload">
                                </a>
                            </div-->
                           
                        </div>
                        <div class="portlet-body">
                            <div class="task-content">
                                <div class="scroller" style="height: 305px;" data-always-visible="1" data-rail-visible1="1">

                                    <table class="table table-striped table-bordered table-hover" id="datatable_orders">
                                        <thead>
                                            <!--th>Image</th-->
                                            <th width="50%">Name</th>
                                            <th width="15%">Website</th>
                                            <!-- <th width="15%">Contact Person</th>
                                            <th width="15%">Address</th> -->
                                        </thead>
                                        <tbody>
                                         <?php if(!empty($bestUniversities)){
                                            foreach($bestUniversities as $k=>$v){
                                        ?>
                                            <tr>
                                            <!--td><img src="<?php echo $v['image'];?>" width="100px"></td-->
                                            <td><?php echo $v['name']; ?></td>
                                            <td><?php echo $v['domain']; ?></td>
                                            <!-- <td><?php echo $v['contact_person']; ?></td>
                                            <td><?php echo $v['address_line_1']; ?></td> -->
                                            </tr>
                                        <?php }}else{
                                        ?>
                                            <tr colspan="4">
                                                No products found.
                                            </tr>
                                            <?php }?>
                                        </tbody>

                                    </table>


                                    <!-- END START TASK LIST -->
                                </div>
                            </div>
                            <div class="task-footer">
                                <!--span class="pull-right">
                                    <a href="#">
                                         See All Tasks <i class="m-icon-swapright m-icon-gray"></i>
                                    </a>
                                     &nbsp;
                                </span-->
                            </div>
                        </div>
                    </div>
                </div>
            

        </div>

    </div>

<script src="<?php echo site_url(); ?>assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>assets/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>
<script type="text/javascript">

    $('#dashboard-report-range').daterangepicker({
                opens: ( 'left'),
                startDate: moment().subtract('days', 29),
                endDate: moment(),
                //minDate: '01/01/2012',
                //maxDate: '12/31/2014',
                /*dateLimit: {
                    days: 60
                },*/
                showDropdowns: false,
                showWeekNumbers: true,
                timePicker: false,
                timePickerIncrement: 1,
                timePicker12Hour: true,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                    'Last 7 Days': [moment().subtract('days', 6), moment()],
                    'Last 30 Days': [moment().subtract('days', 29), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                },
                buttonClasses: ['btn'],
                applyClass: 'blue',
                cancelClass: 'default',
                format: 'MM/DD/YYYY',
                separator: ' to ',
                locale: {
                    applyLabel: 'Apply',
                    fromLabel: 'From',
                    toLabel: 'To',
                    customRangeLabel: 'Custom Range',
                    daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                    monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    firstDay: 1
                }
            },
            function (start, end) {
                console.log("Callback has been called!");
                $('#dashboard-report-range span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }
            );


            $('#dashboard-report-range span').html(moment().subtract('days', 29).format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
            $('#dashboard-report-range').show();


$("button.applyBtn").click(function(){
    
    var startVal = $('input[name=daterangepicker_start]').val();
    var endVal = $('input[name=daterangepicker_end]').val();
    //alert('yes you are rigth.'+startVal);

    var form_data = "startDate="+startVal+"&endDate="+endVal;
    
    $.ajax({
        url: URL +"welcome/filterDashboard", 
        type: "post", 
        data: form_data,
        dataType: 'json',
        success: function (results)
        {
            if(results == false)
            {

            }else{

            /*var htmlStr = '';
            htmlStr ='<option value="">Choose Subcategories</option>';
            $.each(results, function(k, v){
                htmlStr += '<option value='+v.id + '> ' + v.name + '</option>';
            });*/

            $('#newUsers').html( results.newUsers);
            $('#orders').html( results.orders);
            $('#totalProfit').html('Rs. '+results.totalProfit.net_amount);


            var bestProduct ='';
            $.each(results.bestProducts, function(k, v){
                if(v.name != null){
                bestProduct += '<li class="last-line"><!--div class="task-checkbox"><img src="'+v.image +'" width="100px"></div--><div class="task-title"><span class="task-title-sp">'+ v.name+'</span></div></li>';
                }else{
                bestProduct += '<li class="last-line">No product Found.</li>';
                }
            });
            $('#bestProduct').html(bestProduct);
            }
            
        }
    });

});

$(".ranges ul li").click(function(){

   var startVal = $('input[name=daterangepicker_start]').val();
    var endVal = $('input[name=daterangepicker_end]').val();
    //alert('yes you are rigth.'+startVal);

    var form_data = "startDate="+startVal+"&endDate="+endVal;
    
    $.ajax({
        url: URL +"welcome/filterDashboard", 
        type: "post", 
        data: form_data,
        dataType: 'json',
        success: function (results)
        {
            if(results == false)
            {

            }else{

            /*var htmlStr = '';
            htmlStr ='<option value="">Choose Subcategories</option>';
            $.each(results, function(k, v){
                htmlStr += '<option value='+v.id + '> ' + v.name + '</option>';
            });*/

            $('#newUsers').html( results.newUsers);
            $('#orders').html( results.orders);
            $('#totalProfit').html('Rs. '+results.totalProfit.net_amount);

            var bestProduct ='';
            $.each(results.bestProducts, function(k, v){
                if(v.name != null){
                bestProduct += '<li class="last-line"><!--div class="task-checkbox"><img src="'+v.image +'" width="100px"></div--><div class="task-title"><span class="task-title-sp">'+ v.name+'</span></div></li>';
                }else{
                bestProduct += '<li class="last-line">No product Found.</li>';
                }
            });

            $('#bestProduct').html(bestProduct);
            }
            
        }
    });

});

</script>