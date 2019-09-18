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
                            <a href="<?php echo site_url(); ?>product">
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
								<table class="table table-striped table-bordered table-hover" id="datatable_orders">
								<thead>
								<tr role="row" class="heading">
									
									<th width="5%">
										 Keyword
									</th>
									
									<th width="15%">
										 Category
									</th>

									<th width="15%">
										 Sub Category
									</th>

									<th width="35%">
										 Product
									</th>
									<th width="10%">
										 Actions
									</th>
								</tr>
								<tr role="row" class="filter">
									
									<td>
										<input type="text" class="form-control form-filter input-sm" name="searchFORMHEAD_input" id="searchFORMHEAD_input">
									</td>
									
									<td>
										<select name="category" id="cat" class="form-control" onchange="getSubcat(this.value);">
										<option value="">Select...</option>
									<?php	
									if(!empty($mainCategories)){
									foreach($mainCategories as $mcVal)
									{ ?>
											<option value="<?php echo $mcVal['id'];?>"><?php echo $mcVal['name'];?></option>
									<?php }}?>
										</select>
									</td>
									
									<td>
										<select id="subcat" name="subcategory" class="form-control" onchange="getProducts(this.value);">
											<option value="">Select Category First</option>
										</select>
									</td>

									<td>
										<select  style="width:200px;" id="product" name="product" class="form-control">
											<option  style="width:180px; overflow:hidden;" value="">Select Sub-Category First</option>
										</select>
									</td>
									<td>
										<div class="margin-bottom-5">
											<button class="btn blue filter-submit margin-bottom"><i class="fa fa-search"></i> Search</button>
											<!--button class="btn red filter-cancel"><i class="fa fa-times"></i> Reset</button-->
											<a href="<?php echo site_url(); ?>product/" class="btn red"><i class="fa fa-times"></i> Reset</a>
										</div>
										
									</td>
								</tr>
								</thead>
								<tbody>
								</tbody>
								</table>
							</div>
							</form>
						</div>


							<table class="table table-striped table-bordered table-hover" id="sample_2">
							<thead>
							
							<tr>				 				  
						  	<th>SNo.</th>
							<th>User Name</th>
							<th>Company Name</th>
							<th>Product Name</th>
							<th>Quoted On</th>
							<!--th width="30%">Actions</th-->
				  			</tr>
							</thead>
							<tbody>
							<?php

							if(!empty($quotes))
							{

									foreach($quotes as $row)
									{

							?>
							<tr class="odd gradeX"  id="rowId_<?php echo $row['id']; ?>">
								<td><?php echo ++$startPage; ?></td>
								<td><?php echo $row['fname'].' '.$row['lname']; ?></td>
								<td><?php echo $row['company']; ?></td>
								<td><?php echo $row['product_name']; ?></td>
								<td><?php echo date('d M,Y',strtotime($row['created'])); ?></td>
								
								<!--td>
						<a href="javascript:void(0)" onclick="deleted(<?php echo $row['id']; ?>)" class="btn default red"><i class="fa fa-trash-o"></i> Delete</a>
								</td-->
								
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
		window.location.href = window.location.href='<?php echo base_url().'quote/index/'; ?>' + $('#searchFORMHEAD_input').val()+'?category='+category+'&subcategory='+subcategory+'&product='+product;
	}
}

function deleted(id)
	{
		var dataToSend = "id="+id;
		if (confirm("Are you sure, you want to delete?") == true) {
			
			$.ajax({
				url: URL +"quote/deleted", 
				type: "post", 
				data: dataToSend,     
				cache: false,
				success: function(data) {
				console.log(data);
				  if(data == 'true')
				  {
					  $('#rowId_'+id).hide();

					  $('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Quote deleted.</div>');
				  }
				  else
				  { 
					  $('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Failed!</strong> Quote not deleted.</div>');

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

