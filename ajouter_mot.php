<?php
	define("SITE_ADDR", "http://localhost/search");
	include("./include.php");
	$site_title = 'Un moteur de recherche';
?>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width">
		
		<title><?php echo $site_title; ?></title>
		
		<!-- link to the stylesheets -->
		<link rel="stylesheet" type="text/css" href="./main.css"></link>
	</head>
	
	<body>
		
		<div id="wrapper">
			
				
			<div id="top_header">
				<div id="nav">
					<a href="<?php echo SITE_ADDR;?>/index.php">Chercher</a>
				</div>

				<div id="logo">
					<h1><a href="<?php echo SITE_ADDR;?>">Moteur de recherche</a></h1>
				</div>
			</div>


			<div id="main" class="shadow-box"><div id="content">
				
				<?php
//$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
$mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);


  




					// check to see if the form was submitted
					if (isset($_POST['ModifierBtn'])){
						// get all the form data
						$doc1 = isset($_POST['doc1']) ? htmlspecialchars($_POST['doc1']) : "";
						$doc2 = isset($_POST['doc2']) ? htmlspecialchars($_POST['doc2']) : "";
						$doc3 = isset($_POST['doc3']) ? htmlspecialchars($_POST['doc3']) : "";
						$doc4 = isset($_POST['doc4']) ? htmlspecialchars($_POST['doc4']) : "";
					
						$sql1 = "update search set keywords='$doc1' where id=1";	
						$sql2 = "update search set keywords='$doc2' where id=2";	
						$sql3 = "update search set keywords='$doc3' where id=3";	
						$sql4 = "update search set keywords='$doc4' where id=4";	
						
						$mysqli -> query($sql1);
						$mysqli -> query($sql2);
						$mysqli -> query($sql3);
						$mysqli -> query($sql4);
						

						session_start();
						$_SESSION['msg']="Les documents sont bien mis à jours !";

						header("location:index.php");


					}

					$sql = "select * from search";
					$result = $mysqli -> query($sql);
					
					$content=[];
					if (mysqli_num_rows($result) > 0) {
						// output data of each row
						$i=0;
						while($row = mysqli_fetch_assoc($result)) {
						  //echo $row["keywords"]. "<br>";
						  $content[$i]=$row["keywords"];
						  $i++;
						}
					  } else {
						echo "0 results";
					  }	
				?>

				<form action="" method="POST" name="">
					<table>
						<tr>
							<td>Document 1: </td>
							<td>
                          
                            <textarea id="doc1" name="doc1" rows="6" cols="50">
<?php echo $content[0]; ?>
						</textarea>
                            </td>
						</tr>
						
						<tr>
							<td>Document 2: </td>
							<td>
                          
                            <textarea id="doc2" name="doc2" rows="6" cols="50">
<?php echo $content[1]; ?>
						</textarea>
                            </td>
						</tr>

						<tr>
							<td>Document 3: </td>
							<td>
                          
                            <textarea id="doc3" name="doc3" rows="6" cols="50">
<?php echo $content[2]; ?>
						</textarea>
                            </td>
						</tr>

						<tr>
							<td>Document 4: </td>
							<td>
                          
                            <textarea id="doc4" name="doc4" rows="6" cols="50">
<?php echo $content[3]; ?>
						</textarea>
                            </td>
						</tr>
						
						
						<tr>
							<td></td>
							<td><input type="submit" name="ModifierBtn" value="Modifier" /></td>
						</tr>
					</table>
				</form>

			</div></div>

			<div id="footer">
				<div class="left">
					<a href="https://github.com/Adrabalde" target="_blank">Abdourahmane Balde</a>
				</div>
				<div class="right">
				<span>Années 2021/2022</span>
				<span>Introduction à l'hypermédia</span>	
			     </div>
				<div class="clear"></div>
			</div>

		</div>

	</body>
</html>