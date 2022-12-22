<?php
include ('condb.php');
include('database_connection.php');
session_start();
error_reporting(E_ERROR | E_PARSE);
$artid = $_POST['artid'];
$fetchart = $_SESSION['fetchartid'];
$artistid= $_SESSION["artistid"];

$user_id = $_SESSION['user_id'];
include 'similarity.php';
	$host = "localhost";
	$user = "root";
	$pass = "";
	$dbname = "jcra-sining";

    $select_products = mysqli_query($conn, "SELECT * FROM sining_artists INNER JOIN sining_artworks 
    ON sining_artists.artistId = sining_artworks.artistId");  

    if(mysqli_num_rows($select_products) > 0){
       while($fetch_product = mysqli_fetch_assoc($select_products)){
    if(isset($_POST["action"]))
    {

        $fetch=$fetch_product['artistId'];

	$query = "
	SELECT * FROM sining_artists INNER JOIN sining_artworks 
    ON sining_artists.artistId = sining_artworks.artistid WHERE sining_artworks.artistid ='$artistid' 
    AND sining_artworks.artId <> '$fetchart'";

	
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$total_row = $statement->rowCount();
	$output = '';
	if($total_row > 0)
	{
		foreach($result as $row ){
				
		$output .= '
		<div class="cat">
			<form action="view_art.php" method=post>
				<div class=image-box>
					<button type="submit" name="artid" value="'.$row['artId'].'"><img src="artworks/'. $row['artImage'] .'" alt="" class="img-responsive"><br><br>
					<strong>
						'. $row['artTitle'] .'</button>
                    </strong>
               <h5>'. $row['artistName'] .'</h5>
			<form>
					
			<h4>'.'₱'. $row['artPrice'] .'</h4>
			<h6>'. $row['artCategory'] .' </h6>
            </div>
		</div>';
		
	}
	$i++;
}
else
	{
		$output = '<h3>No Data Found</h3>';
	}}}
	echo $output;
	}
?>