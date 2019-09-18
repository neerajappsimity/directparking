<!DOCTYPE html>
<html>
<head>
    <script src="http://profile.appsimity.com/directParking/assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {font-family: Arial, Helvetica, sans-serif;}
form {border: 3px solid #f1f1f1; width: 50%; margin-left: 24%;}

input[type=text], input[type=password] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

button {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
}

button:hover {
    opacity: 0.8;
}

.cancelbtn {
    width: auto;
    padding: 10px 18px;
    background-color: #f44336;
}

.imgcontainer {
    text-align: center;
    margin: 24px 0 12px 0;
}

img.avatar {
    width: 40%;
    border-radius: 50%;
}

.container {
    padding: 16px;
}

span.psw {
    float: right;
    padding-top: 16px;
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
    span.psw {
       display: block;
       float: none;
    }
    .cancelbtn {
       width: 100%;
    }
}
</style>
</head>
<body>

<h2 style="margin-left: 40%;";>Forgot Password</h2>

<form class="form-horizontal form-row-seperated" id="addUserForm" method='post' enctype="multipart/form-data" action="javascript:changePassword();">
  <div class="imgcontainer">
    <img src="logo.png" alt="Logo" class="avatar">
  </div>

  <div class="container">
    
    <?php 
    $id= base64_decode($_REQUEST['token']);?>
    <input type="text" placeholder="Enter Username" id="id" name="id" value="<?php echo $id;?>" >
    <label for="uname"><b>New Password...</b></label>
    <input type="text" placeholder="Enter Password" id="password" name="password" required>

    <!-- <label for="psw"><b>Confirm Password</b></label>
    <input type="password" placeholder="Re-Enter Password" name="password" required> -->
        
    <button type="submit">Save </button>
    
  </div>

  
</form>

</body>
</html>

<script>
    
function changePassword()
{
    //alert('hello');
    //var id = $('#id').val();
        var id = jQuery("#id").val(); 
        var password = jQuery("#password").val();
        var form_data = 'id='+id+'&password='+password;
        //var form_data = new FormData($("#addUserForm"));
        alert(form_data);
        $.ajax({
        url: URL +"welcome/changePassword", 
        type: "post", 
        data: form_data,     
        cache: false,
        contentType: false,
        processData: false,
        success: function (htmlStr)
        {
            $('#message').html('');
            if(htmlStr == 'false')
            {
                $('#message').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> user could not be added.</div>');
            }
            else
            {
                $('#message').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> user added successfully.</div>');
                //window.setTimeout(function(){window.history.back();}, 1500);

            }
                //$('#addCategoryForm').trigger('reset');
                return false;
        }
        return false;
        });

        $('#addUserForm').trigger('reset');
           
}
</script>