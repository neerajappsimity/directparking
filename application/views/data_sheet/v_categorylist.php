<div class="page-content-wrapper">
        <div class="page-content">
            
            
            <div class="row">
                <div class="col-md-12">
                    <h3 class="page-title">
                    <?php echo $pageHeading;?>
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
                            
                            <a href="<?php echo site_url(); ?>dataSheet/">
                                Manage Data Sheets
                            </a>
                            <i class="fa fa-angle-right"></i>
                        </li>
                        
                        <?php if(isset($_GET['id'])){?>
                        <li>
                        	<a href="<?php echo site_url(); ?>dataSheet/category?bid=<?php echo $_GET['bid'];?>">
                                <?php echo $pageHeading1;?>
                            </a>
                            <?php if(isset($_GET['id'])){?>
                            <i class="fa fa-angle-right"></i>
                            <?php }?>
                        </li>

                        <li>
                            <a href="<?php echo site_url(); ?>dataSheet/category?bid=<?php echo $_GET['bid'];?>&id=<?php echo $_GET['id'];?>">
                                <?php echo $pageHeading;?>
                            </a>
                        </li>
                        <?php }else{?>
                        <li>
                        	<a href="<?php echo site_url(); ?>dataSheet/category?bid=<?php echo $_GET['bid'];?>">
                                <?php echo $pageHeading;?>
                            </a>
                            
                        </li>


                        <?php }?>
                        
                    </ul>
                    
                </div>
            </div>

		
	
		
		
		<div class="row">
		<div class="col-lg-12 margin-upper">
<div class="all_panels">
<div class="table_data" aria-labelledby="headingOne" role="tabpanel" id="chat">
	
	<div class="form-group" id="message" style="dispaly:none;"></div>

	<div class="portlet box grey">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-th"></i>
								<?php if(isset($_GET['id'])){?>
								Sub Categories
								<?php }else{ ?>
								Main Categories
								<?php } ?>
							</div>
							<div class="actions">
								
							</div>
						</div>
						<div class="portlet-body">

						<!--div class="col-md-4 pull-right">
							<form name="searchFORMHEAD" action="javascript:search()" method="post" id="searchFORMHEAD" class="form-inline" role="form">
							<input type="text" placeholder="Search" class="search_form_admin" id="searchFORMHEAD_input" name="searchFORMHEAD_input">
							<input type="submit" value="search" class="search_button_admin">
							</form>
						</div-->
						<div style="float:right; margin-bottom:2%;">
							<form name="searchFORMHEAD" action="javascript:search()" method="post" id="searchFORMHEAD" class="form-inline" role="form">
								<div class="input-group input-large">
									<input type="text" placeholder="Search" class="form-control" id="searchFORMHEAD_input" name="searchFORMHEAD_input">
									<span class="input-group-btn">
									<button type="submit" class="btn blue" type="button">Search
									<i class="m-icon-swapright m-icon-white"></i></button>
									</span>
								</div>
							</form>
						</div>


							<table class="table table-striped table-bordered table-hover" id="sample_2">
							<thead>
							
							<tr>				 				  
						  	<th>SNo.</th>
							<th>Name</th>
							
				  			</tr>
							</thead>
							<tbody>
							<?php

							if(!empty($categories))
							{

									foreach($categories as $row)
									{

							?>
							<tr class="odd gradeX"  id="rowId_<?php echo $row['id']; ?>">
								<td><?php echo ++$startPage; ?></td>
								<?php if(!isset($_GET['id'])){?>
								<td><a href="<?php echo site_url(); ?>dataSheet/category?id=<?php echo base64_encode($row['id']);?>&bid=<?php echo $_GET['bid'];?>"><?php echo $row['name']; ?></a></td>
								<?php }else{?>
								<td><a href="<?php echo site_url(); ?>dataSheet/add?id=<?php echo base64_encode($row['id']);?>&bid=<?php echo $_GET['bid'];?>"><?php echo $row['name']; ?></a></td>
								<?php }?>
							</tr>
			<?php } }else{?>
			<tr>
				<td colspan="4">
					No data found.
				</td>
			</tr>
			<?php }?>				
							</tbody>
							</table>
						</div>
					</div>



</div>
</div>
</div>

		<?php if(!empty($pagination)){
echo '<div class="col-md-12 col-sm-12 col-xs-12  blog_pagination">';
	echo '<nav><ul class="pagination"><li>';
		echo $pagination;
	echo '</li></ul></nav>';
echo '</div>';
}  ?>	
		</div>		
		
		
		
		
		
</div>
</div>




<script>
	function deleted(id)
	{
		var dataToSend = "id="+id;
		if (confirm("Are you sure, you want to delete?") == true) {
			
			$.ajax({
				url: URL +"category/deleted", 
				type: "post", 
				data: dataToSend,     
				cache: false,
				success: function(data) {
				console.log(data);
				  if(data == 'true')
				  {
					  $('#rowId_'+id).hide();

					  $('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Category deleted.</div>');
				  }
				  else
				  { 
					  $('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Failed!</strong> Category not deleted.</div>');

				  }
			  },
			  error: function(e) {
				//called when there is an error
				//console.log(e.message);
			  }
			});
		} else {
			return false;
		}
		
		
	}
	
	function changeStatus(id, enabled)
	{
		var dataToSend = "id="+id+"&enabled="+enabled;
		$.ajax({
			url: URL +"category/changeStatus", 
		  	type: "post", 
		  	data: dataToSend,     
		  	cache: false,
		    success: function(data) {
			console.log(data);
			  if(data == 'true')
			  {
				  if(enabled == 'Y')
				  { 
					  /*$('#rowId_'+gId +'td:nth-child(3) a:nth-child(3)').html('Disable');*/ 
					   $('#rowIdStatus_'+id).html('<button type="button" class="btn btn-warning">Disable</button>');
				  	   $('#rowIdStatus_'+id).attr("onclick", "changeStatus("+id+", 'N')");
				  }
				  else
				  {
					  /*$('#rowId_'+gId +'td:nth-child(3) a:nth-child(3)').html('Enable');*/
					  $('#rowIdStatus_'+id).html('<button type="button" class="btn btn-info">Enable</button>');
					  $('#rowIdStatus_'+id).attr("onclick", "changeStatus("+id+", 'Y')");
				  }
				  $('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> category status changed.</div>');
			  }
			  else
			  { 
				  $('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> category status not changed.</div>');
				  
			  }
		  },
		  error: function(e) {
			//called when there is an error
			//console.log(e.message);
		  }
		});
		
	}
	
</script>	
<script>
function search() {
	var search_btn = $('#searchFORMHEAD_input').val();
if(/^[a-zA-Z0-9- ]*$/.test(search_btn) == false) {
alert('Your search string contains illegal characters.');
}
else{
 window.location.href = window.location.href='<?php echo base_url().'dataSheet/category/'; ?>' + $('#searchFORMHEAD_input').val()+ '<?php echo '?'.$_SERVER['QUERY_STRING'];?>';

}
}
</script>

<script type="text/javascript">
	$(document).ready(function() {
    $('#example').DataTable( {
    	rowReorder: true,
        dom: 'Bfrtip',
        /*columnDefs: [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            }],*/

        buttons: [
            'pageLength',
        {
                extend: 'csv',
               header:false,
                text: 'Export to CSV',
                filename: 'Manage Root Categories',
                exportOptions: {
                    columns: [ 0, 1]
                }
        }

            
        ]
    } );
} );

</script>