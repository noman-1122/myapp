<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" ></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" ></script>


</head>
<body>
<?php

$con=mysqli_connect("localhost","root","","primedb");

if(isset($_POST["submit"]))
{
	$Name=$_POST["Name"];
	$Phone=$_POST["Phone"];
	$Email=$_POST["Email"];
	$Password=$_POST["Password"];
	$Gender=$_POST["Gender"];
	$subjects=@$_POST["ch_html"].' '.@$_POST["ch_java"].' '.@$_POST["ch_android"];

	$imgPath="uploads/StudentImages/".uniqid().".png";
	if(move_uploaded_file($_FILES["imgFile"]["tmp_name"], $imgPath))
	{
		echo "image uploaded";
	}
	else
	{
		echo "Image not uploaded.....";
	}
	$pdfPath="uploads/PDF/".uniqid().".pdf";
	if(move_uploaded_file($_FILES["pdfFile"]["tmp_name"], $pdfPath))
	{
		echo "pdf uploaded";
	}
	else
	{
		echo "pdf not uploaded.....";
	}

	$IsInsert=mysqli_query($con,"
		insert into student (Name,Phone,Email,Password,Gender,imgPath,Subjects,pdfFile) 
		values ('$Name','$Phone','$Email','$Password','$Gender','$imgPath','$subjects','$pdfPath')") or die(mysqli_error($con));
	if($IsInsert)
	{

		?>
		<div class="alert alert-success" id="alert" role="alert">
		  Insert Successfully <a href="#" class="alert-link">an example link</a>. Give it a click if you like.
		</div>
		<?php
	}else
	{
		echo "error";
	}
}
//-------------------- Delete Record
if(isset($_GET["DeleteId"]))
{
	$id=$_GET["DeleteId"];

	$IsDelete=mysqli_query($con,"delete from student where Id ='$id'");
	if($IsDelete)
	{
		?>
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
		  <strong>Delete Successfuly!</strong> delete record successfully........
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<?php
		//echo "<script>alert('Deleted Successfully')</script>";
	}else
	{
		echo "error";
	}
}
//-------------------- Edit Record
if(isset($_GET["EditId"]))
{
	$id=$_GET['EditId'];
	$res=mysqli_query($con,"select * from student where Id=$id");
	$row=mysqli_fetch_array($res);

}
//-------------------- Update Record--------------
if(isset($_POST["update"]))
{
	$Id=$_POST["Id"];
	$Name=$_POST["Name"];
	$Phone=$_POST["Phone"];
	$Email=$_POST["Email"];
	$Password=$_POST["Password"];
	$Gender=$_POST["Gender"];
	$subjects=@$_POST["ch_html"].' '.@$_POST["ch_java"].' '.@$_POST["ch_android"];
	$imgPath="uploads/StudentImages/".uniqid().".png";
	if(move_uploaded_file($_FILES["imgFile"]["tmp_name"], $imgPath))
	{
		$IsUpdate=mysqli_query($con,
	"update student set Name='$Name',Phone='$Phone',Email='$Email',Password='$Password',Gender='$Gender' , imgPath='$imgPath',Subjects='$subjects' where Id='$Id'");
	}
	else
	{
		$IsUpdate=mysqli_query($con,
	"update student set Name='$Name',Phone='$Phone',Email='$Email',Password='$Password',Gender='$Gender' ,Subjects='$subjects' where Id='$Id'");
	}



	if($IsUpdate)
	{
		?>
		<div class="alert alert-warning alert-dismissible fade show" role="alert">
		  <strong>Update Successfuly!</strong> Update record successfully........
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<?php
	}
	else
	{
		echo "Error";
	}



}

?>

<form  action="index.php" method="post" enctype="multipart/form-data">	
	<input type="hidden" name="Id" value="<?php echo @$row['Id']?>">
	Name <input type="text" name="Name" value="<?php echo @$row['Name']?>"><br>
	Phone <input type="text" name="Phone" value="<?php echo @$row['Phone']?>"><br>
	Email <input type="text" name="Email" value="<?php echo @$row['Email']?>"><br>
	Passsword <input type="text" name="Password" value="<?php echo @$row['Password']?>"><br>
	Gender 
	<input type="radio" name="Gender" value="Male" <?php if(@$row["Gender"]=="Male") echo "checked" ?>> Male
	<input type="radio" name="Gender" value="Female" <?php if(@$row["Gender"]=="Female") echo "checked" ?>> Female
	<br>
	subjects 
	<input type="checkbox" name="ch_html" value="HTML" 
	<?php if(strpos(' '.@$row["Subjects"],"HTML")) echo "checked"?>> HTML

	<input  type="checkbox" name="ch_java" value="Java"
	<?php if(strpos(' '.@$row["Subjects"],"Java")) echo "checked"?>
	> Java
	<input type="checkbox" name="ch_android" value="Android"
	<?php if(strpos(' '.@$row["Subjects"],"Android")) echo "checked"?>
	> Android<br>
		<img src="" id="imgId" width="100">
	<input type="file" name="imgFile" id="imgFile" ><br>
	<input type="file" name="pdfFile"  ><br>


<?php
if(isset($_GET['EditId']))
{
	?>
	<input type="submit" name="update" value="Update">
	<?php
}
else
{
	?>
	<input type="submit" name="submit" value="Submit">
	<?php
	
}
?>
	
	


</form>

<table border="1">
	<tr>
		<th>Id</th>
		<th>Name</th>
		<th>Phone</th>
		<th>Email</th>
		<th>Password</th>
		<th>Gender</th>
		<th>Subjects</th>
		<th>PDF</th>
		<th>Image</th>
		<th>Delete</th>
		<th>Edit</th>
		


	</tr>

<?php

$query=mysqli_query($con,"select * from student");
while ($row=mysqli_fetch_array($query)) 
{
	?>
		<tr>
			<td><?php echo $row["Id"]?></td>
			<td><?php echo $row["Name"]?></td>
			<td><?php echo $row["Phone"]?></td>
			<td><?php echo $row["Email"]?></td>
			<td><?php echo $row["Password"]?></td>
			<td><?php echo $row["Gender"]?></td>
			<td><?php echo $row["Subjects"]?></td>
			<td>
				<a href="<?php echo $row['pdfFile']?>" download='<?php echo $row['Name']?>.pdf'>download</a>
			</td>


			<td>
				<img class="stdImg" src="<?php echo $row['imgPath']?>" height="60" width="60" style="border-radius: 40px">
			</td>
			<td>
				<a href="index.php?DeleteId=<?php echo $row['Id']?>">
					<img src="Images/delete.png" width="30">
				</a>
				
			</td>
			<td>
				<a href="index.php?EditId=<?php echo $row['Id']?>">
					<img src="Images/edit.png" width="30">
				</a>
				
			</td>
		</tr>
	<?php
}

?>
</table>
</body>
</html>


<script type="text/javascript">
document.getElementById('imgFile').onchange = function (evt) {
    var tgt = evt.target || window.event.srcElement,
        files = tgt.files;

    // FileReader support
    if (FileReader && files && files.length) {
        var fr = new FileReader();
        fr.onload = function () {
            document.getElementById('imgId').src = fr.result;
        }
        fr.readAsDataURL(files[0]);
    }

    // Not supported
    else {
        // fallback -- perhaps submit the input to an iframe and temporarily store
        // them on the server until the user's session ends.
    }
}

</script>