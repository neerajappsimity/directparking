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
                            <a href="<?php echo site_url(); ?>capitalQuery">
                                <?php echo $pageHeading;?>
                            </a>
                        </li>
                        
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
								<i class="fa fa-sitemap"></i>
								<?php echo $pageHeading;?>
							</div>
							<div class="actions">
								
							</div>
						</div>
						<div class="portlet-body">
						<div>
							<form name="searchFORMHEAD" action="javascript:search()" method="post" id="searchFORMHEAD" class="form-inline" role="form">
								<!--div class="input-group input-large">
									<input type="text" placeholder="Search" class="form-control" id="searchFORMHEAD_input" name="searchFORMHEAD_input">
									<span class="input-group-btn">
									<button type="submit" class="btn blue" type="button">Search
									<i class="m-icon-swapright m-icon-white"></i></button>
									</span>
								</div -->
								<div class="table-container">
								
								</div>
							</form>
						</div>


							<table class="table table-striped table-bordered table-hover" id="sample_2">
							<thead>
							
							<tr>				 				  
						  	<th>SNo.</th>
							<th>User Name</th>
							<th>User Type</th>
							<th>Company Name</th>
							<th>Mobile</th>
							<th>Queried On</th>
							<th width="30%">Actions</th>
				  			</tr>
							</thead>
							<tbody>
							<?php

							if(!empty($queries))
							{

									foreach($queries as $row)
									{

							?>
							<tr class="odd gradeX"  id="rowId_<?php echo $row['id']; ?>">
								<td><?php echo ++$startPage; ?></td>
								<td><?php echo $row['fname'].' '.$row['lname']; ?></td>
								<td><?php echo $row['user_type']; ?></td>
								<td><?php echo $row['company']; ?></td>
								<td><?php echo $row['mobile']; ?></td>
								<td><?php echo date('d M,Y',strtotime($row['created'])); ?></td>
								<td>
						<a href="javascript:void(0)" onclick="deleted(<?php echo $row['id']; ?>)" class="btn default red"><i class="fa fa-trash-o"></i> Delete</a>
								</td>
								
							</tr>
			<?php } }else{?>
			<tr>
				<td colspan="6">
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
function search() {

	var search_btn = $('#searchFORMHEAD_input').val();
	var category = $('#cat').val();
	var subcategory = $('#subcat').val();
	var product = $('#product').val();
	if(/^[a-zA-Z0-9- ]*$/.test(search_btn) == false) {
		alert('Your search string contains illegal characters.');
	}else{
		window.location.href = window.location.href='<?php echo base_url().'quote/index/'; ?>' + $('#searchFORMHEAD_input').val();
	}
}
function deleted(id)
	{
		var dataToSend = "id="+id;
		if (confirm("Are you sure, you want to delete?") == true) {
			
			$.ajax({
				url: URL +"capitalQuery/deleted", 
				type: "post", 
				data: dataToSend,     
				cache: false,
				success: function(data) {
				console.log(data);
				  if(data == 'true')
				  {
					  $('#rowId_'+id).hide();

					  $('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Query deleted.</div>');
				  }
				  else
				  { 
					  $('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Failed!</strong> Query not deleted.</div>');

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



</script>

