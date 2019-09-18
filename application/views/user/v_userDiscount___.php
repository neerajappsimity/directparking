<style type="text/css">
	.btn-full{
		width: 100% !important;
	}
	.searchHide{
		display: none;
	}
</style>
							<div id="addPro" class="modal fade" tabindex="-1"  aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Add User Listing Product</h4>
										</div>
										<div class="modal-body">
										<form id="addDiscount">
											<div class="row">
													<div class="col-md-12">
															<label>Search Product</label>
															<input type="text" class="col-md-12 form-control txt-auto" id="productSearch" name="productSearch">
															<input type="hidden" id="searchProductId" name="searchProductId">
															<input type="hidden" id="userId" name="productUserId" value="<?php echo base64_decode($_GET['uid']);?>">
													</div>
											</div>
											<div class="row searchHide">
													<div class="col-md-12">
															<label>MOQ</label>
															<input type="text" class="col-md-12 form-control txt-auto" id="productMoq" name="productMoq">
													</div>
											</div>
											<div class="row searchHide">
													<div class="col-md-12">
															<label>Price</label>
															<input type="text" class="col-md-12 form-control txt-auto" id="productPrice" name="productPrice">
													</div>
											</div>
											
										</form>
										</div>
										<div class="modal-footer">
											<button type="button" data-dismiss="modal" class="btn default">Close</button>
											<button type="button" onclick="addDiscount();" class="btn green">Add Discount</button>
										</div>
									</div>
								</div>
							</div>

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
                            <a href="<?php echo site_url(); ?>user">
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
								<i class="fa fa-user"></i>
								Discounted Products
							</div>

							<div class="actions">
								<a  href="#addPro" onclick="hideSearchInput();" data-toggle="modal" class="btn green">
									+ Add Discount Product
								</a>
								
							</div>
							
						</div>
						<div class="portlet-body">
						<div style="float:right; margin-bottom:2%;">
							<!--form name="searchFORMHEAD" action="javascript:search()" method="post" id="searchFORMHEAD" class="form-inline" role="form">
								<div class="input-group input-large">
									<input type="text" placeholder="Search" class="form-control" id="searchFORMHEAD_input" name="searchFORMHEAD_input">
									<span class="input-group-btn">
									<button type="submit" class="btn blue" type="button">Search
									<i class="m-icon-swapright m-icon-white"></i></button>
									</span>
								</div>
							</form-->
						</div>


							<table class="table table-striped table-bordered table-hover" id="sample_2">
							<thead>
							
							<tr>				 				  
							<th>Product Name</th>
							<th>Sku</th>
							<th>Price</th>
							<th>MOQ</th>
							<th width="10%">Actions</th>
				  			</tr>
							</thead>
							<tbody id="addDisBox">
							<?php

							if(!empty($discountProducts))
							{
									foreach($discountProducts as $rowDis)
									{

							?>
							<tr class="odd gradeX"  id="rowDisId_<?php echo $rowDis['id']; ?>">
								<td><?php echo $rowDis['name']; ?></td>
								<td><?php echo $rowDis['sku']; ?></td>
								
								<td><?php echo $rowDis['price']; ?></td>
								<td><?php echo $rowDis['moq']; ?></td>
								<td><button type="button" class="btn btn-danger" onclick="deleteUserDiscount(<?php echo $rowDis['id']; ?>)">Remove</button></td>
								
							</tr>
			<?php } }else{?>
			<tr id="noDisProduct">
				<td colspan="7">
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



<!--script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script-->
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/jquery-ui.min.js"></script>  
<script>
	function deleted(id)
	{
		var dataToSend = "id="+id;
		if (confirm("Are you sure, you want to delete?") == true) {
			
			$.ajax({
				url: URL +"user/deleted", 
				type: "post", 
				data: dataToSend,     
				cache: false,
				success: function(data) {
				console.log(data);
				  if(data == 'true')
				  {
					  $('#rowId_'+id).hide();

					  $('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> User deleted.</div>');
				  }
				  else
				  { 
					  $('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Failed!</strong> User not deleted.</div>');

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
			url: URL +"user/changeStatus", 
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
				  $('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> user status changed.</div>');
			  }
			  else
			  { 
				  $('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> user status not changed.</div>');
				  
			  }
		  },
		  error: function(e) {
			//called when there is an error
			//console.log(e.message);
		  }
		});
		
	}


	function changeVerified(id, enabled)
	{

		var dataToSend = "id="+id+"&is_verified="+enabled;
		$.ajax({
			url: URL +"user/changeVerified", 
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
				  $('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> user status changed.</div>');
			  }
			  else
			  { 
				  $('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> user status not changed.</div>');
				  
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
 window.location.href = window.location.href='<?php echo base_url().'user/'.$pageFunction.'/'; ?>' + $('#searchFORMHEAD_input').val()+ '<?php echo '?'.$_SERVER['QUERY_STRING'];?>';

}
}



$('#productSearch').autocomplete({
		      	source: function( request, response ) {
		      		var dataToSend = 'searchText='+$('#productSearch').val();
		      		$.ajax({
		      			url : URL +"user/autoSuggestionList",
		      			dataType: "json",
						data: 
							dataToSend
						  // name_startsWith: request.term,
						   //type: 'country'
						,
						 success: function( data ) {
							 response( $.map( data, function( item ) {
							 	//console.log(item.name);
								return {
									label: item.name,
									data: item
								}
							}));
						}
		      		});
		      	},
		      	select: function (event, ui) {
		      		$('#searchProductId').val(ui.item.data.id);
		      		$('.searchHide').show();
            	},
		      	autoFocus: true,
		      	minLength: 3      	
		      });



function addDiscount()
{
		var val = $('#nameBath').val();

		var form_data = new FormData($("#addDiscount")[0]);
		$.ajax({
		url: URL +"user/addUserDiscount", 
		type: "post", 
		data: form_data,     
		cache: false,
		contentType: false,
		processData: false,
		dataType: 'json',
		success: function (htmlStr)
			{
				console.log(htmlStr.insert_id);
				$('#noDisProduct').hide();
				$('#addDiscount').trigger('reset');
				$('#addPro').modal('toggle');

				var str = '<tr id="rowDisId_'+htmlStr.insert_id+'"><td>'+htmlStr.name+'</td><td>'+htmlStr.sku+'</td><td>'+htmlStr.price+'</td><td>'+htmlStr.moq+'</td><td><button type="button" class="btn btn-danger" onclick="deleteUserDiscount('+htmlStr.insert_id+')">Remove</button></td></tr>';
				$('#addDisBox').append(str);
			}
		});
}

function hideSearchInput(){
		
		$('#addDiscount').trigger('reset');
		$('.searchHide').hide();
}

function deleteUserDiscount(id){

		var dataToSend = "id="+id;
		if (confirm("Are you sure, you want to delete?") == true) {
			
			$.ajax({
				url: URL +"user/deleteUserDiscount", 
				type: "post", 
				data: dataToSend,     
				cache: false,
				async:false,
				dataType: 'json',
				success: function(data) {
				
				  if(data.status == 'true')
				  {
				  	
					  $('#rowDisId_'+data.id).hide();

					  /*$('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> User deleted.</div>');*/
				  }
				  else
				  { 
					  /*$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Failed!</strong> User not deleted.</div>');*/

				  }
			  },
			  error: function(e) {
				
			  }
			});
		} else {
			return false;
		}
		
}
</script>

