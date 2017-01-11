<?php

	require("../functions.php");
	
	require("../class/Car.Class.php");
	$Car = new Car($mysqli);
	
	require("../class/Portfoolio.class.php");
	$Portfoolio = new Portfoolio($mysqli);
	
	require("../class/Helper.Class.php");
	$Helper = new Helper($mysqli);
	
	require("../class/Order.Class.php");
	$Order = new Order($mysqli);
	
	$PictureError = "";
	
	//Kas on sisse loginud, kui ei ole siis
	//suunata login lehele
	//kommentaar
	if (!isset($_SESSION["userId"])) {
		
		//header("Location: login.php");
		//exit();
	}

	//kas ?logout on aadressireal
	if (isset($_GET["logout"])){
		
		session_destroy();
		header("Location: login.php");
		exit();
	}
	
	$msg = "";
	if(isset($_SESSION["message"])){
		$msg = $_SESSION["message"];
		
		//kui ühe näitame siis kustuta ära, et pärast refreshi ei näitaks
		unset($_SESSION["message"]);
	}
	
/*	
	if(isset($_POST["insert"]))  {
		if ( empty ( $_POST["insert"] ) ) {
			

			$PictureError = "<i>Pilti ei sisestatud!</i>";
			
		} else {
		
			$connect = $_POST["insert"];
			
		}
	}
	
	
		
 
    $query = "SELECT * FROM images ORDER BY id DESC";  
    $result = mysqli_query($query, $connect);  
    while($row = mysqli_fetch_array($result))  
    {  
		echo '  
			<tr>  
				<td>  
					<img src="data:image/jpeg;base64,'.base64_encode($row['name'] ).'" height="200" width="200" class="img-thumnail" />  
				</td>  
			</tr>  
		';  
	}    
	
	


*/
?>
<?php require("../partials/header.php");?>

<p>

	Loo portfoolio! <a href="user.php"><?=$_SESSION["userEmail"];?> -</a>
	<a href="?logout=1">Logi välja</a>

</p>

<div class="container">
		<div class="row">
			<div class="col-sm-4 col-md-3 col-sm-offset-4 col-md-offset-3">
			<form method="POST">
			<br><br>
			<div class="form-group">
				<input class="form-control" type="text" name="Fbaddress" placeholder="Facebooki leht">
			</div>
			<div class="form-group">
				<input class="form-control" type="text" name="Blogaddress" placeholder="Blogi">
			</div>
			<div class="form-group">
				<input class="form-control" type="text" name="Portfoolioaddress" placeholder="Portfoolio link">
			
			<br>
			<form action="demo_form.asp" id="usrform">
			<textarea name="comment" form="usrform" rows="5" cols="35" placeholder="BIO - Fotograafi kirjeldus"></textarea>
			</div>
			
		</div>
	</div>
	</div>
</body>
</html>
</form>
</form>
 <!DOCTYPE html>  
 <html>  
      <body>  
           <br /><br />  
           <div class="container" style="width:500px;">   
                <form method="post" enctype="multipart/form-data">  
                     <input type="file" name="image" id="image" />  
                     <br />  
                     <input type="submit" name="insert" id="insert" value="Insert" class="btn btn-info" />  
                </form>  
                <br />  
                <br />  
                <table class="table table-bordered">  
                     <tr>  
                          <th>Image</th>  
                     </tr>  
                </table>  
           </div>  
      </body>  
 </html>  
 <script>  
 $(document).ready(function(){  
      $('#insert').click(function(){  
           var image_name = $('#image').val();  
           if(image_name == '')  
           {  
                alert("Please Select Image");  
                return false;  
           }  
           else  
           {  
                var extension = $('#image').val().split('.').pop().toLowerCase();  
                if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)  
                {  
                     alert('Invalid Image File');  
                     $('#image').val('');  
                     return false;  
                }  
           }  
      });  
 });  
 </script> 

<h2>Profiil</h2>

<?php 

	


?>
<?php require("../partials/footer.php");?>
