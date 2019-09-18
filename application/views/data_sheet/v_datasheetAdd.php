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
                        <li>
                        	<a href="<?php echo site_url(); ?>dataSheet/category?bid=<?php echo $_GET['bid'];?>">
                                <?php echo $pageHeading1;?>
                            </a>
                            <?php if(isset($_GET['id'])){?>
                            <i class="fa fa-angle-right"></i>
                            <?php }?>
                        </li>

                        <li>
                            <a href="<?php echo site_url(); ?>dataSheet/add?bid=<?php echo $_GET['bid'];?>&id=<?php echo $_GET['id'];?>">
                                <?php echo $pageHeading;?>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

		<div class="form-group" id="message" style="dispaly:none;"></div>

		<div class="row">
				<div class="col-md-12">
					<form class="form-horizontal form-row-seperated" id="editProductForm" enctype="multipart/form-data" action="javascript:addProduct();">
						<div class="portlet">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-sitemap"></i> <?php echo $pageHeading;?>
								</div>
								<div class="actions btn-set">
									
								</div>
							</div>
							<div class="portlet-body">
								
										
										<div class="tab-pane" id="tab_images">
										<input type="hidden" value="<?php echo $_GET['id']; ?>" name="id" placeholder="">
										<input type="hidden" value="<?php echo $_GET['bid']; ?>" name="bid" placeholder="">
											
											<div id="tab_images_uploader_container" class="text-align-reverse margin-bottom-10">
											<input type="file" name="image[]" style="display:inline !important;" class="btn yellow" multiple>												
												<a href="javascript:uploadImage();" class="btn green">
													<i class="fa fa-share"></i> Upload Files
												</a>
											</div>
											<div class="row">
												<div id="tab_images_uploader_filelist" class="col-md-6 col-sm-12">
												</div>
											</div>
											<table class="table table-bordered table-hover">
											<thead>
											<tr role="row" class="heading">
												<th>
													 Image
												</th>
												
												
												
												<th width="10%">
												</th>
											</tr>
											</thead>
											<tbody id="tblImageBody">

											<?php 
											if(!empty($dataSheetImages)){
											foreach($dataSheetImages as $images){?>
											<tr id="rowImage_<?php echo $images['id'];?>">
												<td>
													<a href="<?php echo site_url().'assets/image/data_sheet/'.$images['image']; ?>" class="fancybox-button" data-rel="fancybox-button">
														<img width="150" src="<?php echo site_url().'assets/image/data_sheet/'.$images['image']; ?>" alt="">
													</a>
												</td>
												
												<td>
													<a href="javascript:;" onclick="removeImage(<?php echo $images['id'];?>)" class="btn default btn-sm">
														<i class="fa fa-times"></i> Remove
													</a>
												</td>
											</tr>
											<?php } }?>
											
											</tbody>
											</table>
										</div>
										
									
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>


		
	</div><!--wrapper_inner close -->
</div>

<script src="<?php echo site_url(); ?>assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>assets/plugins/plupload/js/plupload.full.min.js" type="text/javascript"></script>
<script>
        var uploader = new plupload.Uploader({
            runtimes : 'html5,flash,silverlight,html4',
             
            browse_button : document.getElementById('tab_images_uploader_pickfiles'), // you can pass in id...
            container: document.getElementById('tab_images_uploader_container'), // ... or DOM Element itself
             
            url : "assets/plugins/plupload/examples/upload.php",
             
            filters : {
                max_file_size : '10mb',
                mime_types: [
                    {title : "Image files", extensions : "jpg,gif,png"},
                    {title : "Zip files", extensions : "zip"}
                ]
            },
         
            // Flash settings
            flash_swf_url : 'assets/plugins/plupload/js/Moxie.swf',
     
            // Silverlight settings
            silverlight_xap_url : 'assets/plugins/plupload/js/Moxie.xap',             
         
            init: {
                PostInit: function() {
                    $('#tab_images_uploader_filelist').html("");
         
                    $('#tab_images_uploader_uploadfiles').click(function() {
                        uploader.start();
                        return false;
                    });

                    $('#tab_images_uploader_filelist').on('click', '.added-files .remove', function(){
                        uploader.removeFile($(this).parent('.added-files').attr("id"));    
                        $(this).parent('.added-files').remove();                     
                    });
                },
         
                FilesAdded: function(up, files) {
                    plupload.each(files, function(file) {
                        $('#tab_images_uploader_filelist').append('<div class="alert alert-warning added-files" id="uploaded_file_' + file.id + '">' + file.name + '(' + plupload.formatSize(file.size) + ') <span class="status label label-info"></span>&nbsp;<a href="javascript:;" style="margin-top:-5px" class="remove pull-right btn btn-sm red"><i class="fa fa-times"></i> remove</a></div>');
                    });
                },
         
                UploadProgress: function(up, file) {
                    $('#uploaded_file_' + file.id + ' > .status').html(file.percent + '%');
                },

                FileUploaded: function(up, file, response) {
                    var response = $.parseJSON(response.response);

                    if (response.result && response.result == 'OK') {
                        var id = response.id; // uploaded file's unique name. Here you can collect uploaded file names and submit an jax request to your server side script to process the uploaded files and update the images tabke

                        $('#uploaded_file_' + file.id + ' > .status').removeClass("label-info").addClass("label-success").html('<i class="fa fa-check"></i> Done'); // set successfull upload
                    } else {
                        $('#uploaded_file_' + file.id + ' > .status').removeClass("label-info").addClass("label-danger").html('<i class="fa fa-warning"></i> Failed'); // set failed upload
                        App.alert({type: 'danger', message: 'One of uploads failed. Please retry.', closeInSeconds: 10, icon: 'warning'});
                    }
                },
         
                Error: function(up, err) {
                    App.alert({type: 'danger', message: err.message, closeInSeconds: 10, icon: 'warning'});
                }
            }
        });

        uploader.init();
</script>

<script type="text/javascript">
	function removeImage(id)
	{
		var dataToSend = "id="+id;
		if (confirm("Are you sure, you want to delete?") == true) {
			
			$.ajax({
				url: URL +"dataSheet/removeImage", 
				type: "post", 
				data: dataToSend,     
				cache: false,
				success: function(data) {
				console.log(data);
				  if(data == 'true')
				  {
					  /*$('#rowId_'+id).hide();*/

					  $('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Image deleted.</div>');
					   $('#rowImage_'+id).remove();
				  }
				  else
				  { 
					  $('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Failed!</strong> image not deleted.</div>');

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


	function uploadImage()
{
	var form_data = new FormData($("#editProductForm")[0]);
	console.log(form_data);
	$.ajax({
		url: URL +"dataSheet/addImages", 
		type: "post", 
		data: form_data,     
		cache: false,
		contentType: false,
		processData: false,
		dataType: 'json',
		success: function (results)
		{
			$('#message').html('');
			if(results == 'false')
			{
				$('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> images not uploaded.</div>');
			}
			else
			{
				/*$('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> images uploaded.</div>');*/
				//window.setTimeout(function(){window.history.back();}, 1500);
				var htmlStr='';
				
				$.each(results, function(k, v){
					var checked = '';
					if(v.is_featured == 'Y'){
						checked = 'checked';
					}
        			htmlStr += '<tr><td><a href="<?php echo site_url()?>assets/image/data_sheet/'+v.image+'" class="fancybox-button" data-rel="fancybox-button"><img width="150" src="<?php echo site_url()?>assets/image/data_sheet/'+v.image+'" alt=""></td><td><a href="javascript:;" onclick="removeImage('+v.id+')" class="btn default btn-sm"><i class="fa fa-times"></i> Remove</a></td></tr>';
   				});
   				$('#tblImageBody').html(htmlStr);

			}

		
		}
	});		
}
</script>