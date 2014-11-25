<?php
ini_set('max_execution_time', 86400);
ini_set('memory_limit', '2048M');


include 'connect.inc.php';
include 'locations.php';
include 'crimes.php'; 

$total_rows = 0;
$query = "SELECT COUNT(`Id`) AS `C` FROM `Crime_Location` WHERE `Counter` > 0";
if($query_run = mysqli_query($con, $query)){
	if(mysqli_num_rows($query_run)>0){
		$total_rows = mysqli_fetch_assoc($query_run)['C'];
	}
}

for($i=0; $i<$total_rows/1000; $i++){
	$query = "SELECT `Loc_Id`,SUM(`Counter`) AS `Quantity` FROM `Crime_Location` GROUP BY `Loc_Id` HAVING `Quantity` > 0 LIMIT ".($i*1000).", 1000";
	if($query_run = mysqli_query($con, $query)){
		if(mysqli_num_rows($query_run)>0){
			while ($row = mysqli_fetch_assoc($query_run)){
				$loc_id = $row['Loc_Id'];
				$counter = $row['Quantity'];


				$query2 = "SELECT `Name`, `Lat`, `Lng` FROM `Location` WHERE `Id`='".$loc_id."' AND `Id` > 36";
				if($query_run2 = mysqli_query($con, $query2)){
					if(mysqli_num_rows($query_run2)>0){
						while ($row2 = mysqli_fetch_assoc($query_run2)){
							$location = $row2['Name'];
							$lat = $row2['Lat'];
							$long = $row2['Lng'];
							echo $location." - ".$lat." - ".$long."</br>";
						}
					}
				}

				
				$query3 = "SELECT `Name`, `Lat`, `Lng` FROM `Location` WHERE `Id`='".$loc_id."' AND `Id` <= 36";
				if($query_run3 = mysqli_query($con, $query3)){
					if(mysqli_num_rows($query_run3)>0){
						while ($row3 = mysqli_fetch_assoc($query_run3)){
							$location = $row3['Name'];
							$lat = $row3['Lat'];
							$long = $row3['Lng'];
							echo $location." - ".$lat." - ".$long."</br>";
						}
					}
				}
			}
		}
	}
}


