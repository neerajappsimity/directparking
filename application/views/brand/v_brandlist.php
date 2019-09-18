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
                            <a href="<?php echo site_url(); ?>brand">
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
								<i class="fa fa-bold"></i>
								<?php echo $pageHeading;?>
							</div>
							<div class="actions">
								<a href="<?php echo site_url(); ?>brand/add" class="btn green">
									+ Add Brand
								</a>
								
							</div>
						</div>
						<div class="portlet-body">
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
							<th>Image</th>
							<th>Order</th>
							<th>Actions</th>
				  			</tr>
							</thead>
							<tbody>
							<?php

							if(!empty($brands))
							{

									foreach($brands as $row)
									{

							?>
							<tr class="odd gradeX"  id="rowId_<?php echo $row['id']; ?>">
								<td><?php echo ++$startPage; ?></td>
								<td><?php echo $row['name']; ?></td>
								<td><?php if(!empty($row['image'])){?>
								<img width="150px" src="<?php echo site_url().'assets/image/brand/'.$row['image']; ?>">
								<?php }else{?>
								<img width="150px" src="<?php echo site_url().'assets/image/brand/noimage.jpg'; ?>">
								<?php }?>
								</td>
								<td><select class="form-control" name="sequence" id="sequence" onchange="setPriority(<?php echo $row['id']; ?>,this.value)">
								<option value="0">Select Order</option>
								<?php for($j=1;$j<=count($allBrands);$j++){?>
									<option value="<?php echo $j; ?>" <?php if($j==$row['sequence']){echo "selected='selected'";} ?>><?php echo $j; ?></option>
								<?php } ?>
								</select>
								</td>

								<td>
						
						<a href="<?php echo site_url(); ?>brand/edit?cid=<?php echo base64_encode($row['id']); ?>" class="btn default purple"><i class="fa fa-edit"></i> Edit</a>&nbsp;
					
					<?php if($row['enabled'] == 'Y'){?>
						<a id="rowIdStatus_<?php echo $row['id']; ?>" href="javascript:void(0)" onclick="changeStatus(<?php echo $row['id']; ?>, 'N')"><button type="button" class="btn btn-warning">Disable</button></a>
					<?php }else{?>
						<a id="rowIdStatus_<?php echo $row['id']; ?>" href="javascript:void(0)" onclick="changeStatus(<?php echo $row['id']; ?>, 'Y')"><button type="button" class="btn btn-primary">Enable</button></a>
					<?php }?>	
						

						<a href="javascript:void(0)" onclick="deleted(<?php echo $row['id']; ?>)" class="btn default red"><i class="fa fa-trash-o"></i> Delete</a>
				
								
								</td>
								
							</tr>
			<?php } }else{?>
			<tr>
				<td colspan="2">
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
				url: URL +"brand/deleted", 
				type: "post", 
				data: dataToSend,     
				cache: false,
				success: function(data) {
				console.log(data);
				  if(data == 'true')
				  {
					  $('#rowId_'+id).hide();

					  $('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Brand deleted.</div>');
				  }
				  else
				  { 
					  $('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Failed!</strong> Brand not deleted.</div>');

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
			url: URL +"brand/changeStatus", 
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
				  $('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> brand status changed.</div>');
			  }
			  else
			  { 
				  $('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> brand status not changed.</div>');
				  
			  }
		  },
		  error: function(e) {
			//called when there is an error
			//console.log(e.message);
		  }
		});
		
	}

	

	function setPriority(id, val)
	{
		var dataToSend = "id="+id+"&sequence="+val;
		$.ajax({
			url: URL +"brand/changeOrder", 
		  	type: "post", 
		  	data: dataToSend,     
		  	cache: false,
		    success: function(data) {
			console.log(data);
			  if(data == 'true')
			  {
				  
				  $('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> brand order changed.</div>');
			  }
			  else
			  { 
				  $('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> brand order not changed.</div>');
				  
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
 window.location.href = window.location.href='<?php echo base_url().'brand/index/'; ?>' + $('#searchFORMHEAD_input').val()+ '<?php echo '?'.$_SERVER['QUERY_STRING'];?>';

}
}
</script>

