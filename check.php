<?php
ini_set('max_execution_time', 86400);
ini_set('memory_limit', '2048M');


include 'connect.inc.php';
include 'locations.php';
include 'crimes.php';

//Benchmarking
echo 'Start - 0.00s<br/>';
$time = microtime(true);

// Finding cities of crimes

$total_rows = 0;
$query = "SELECT COUNT(`Id`) AS `C` FROM `Headline`";
if($query_run = mysqli_query($con, $query)){
	if(mysqli_num_rows($query_run)>0){
		$total_rows = mysqli_fetch_assoc($query_run)['C'];
	}
}


$locations_of_crimes = array();
$states_of_crimes = array();
$lat_locations = array();
$long_locations = array();
$crimes_found = array();

for($i=0; $i<$total_rows/1000; $i++){
	$query = "SELECT `Id`,`Title` FROM `Headline` LIMIT ".($i*1000).", 1000";
	if($query_run = mysqli_query($con, $query)){
		if(mysqli_num_rows($query_run)>0){
			while ($row = mysqli_fetch_assoc($query_run)){
				//echo "Healine ".$row["Id"].": ".$row["Title"]."<br/>";
				$headline = strtolower($row["Title"]);
				$crime_id = 0;
				$loc_id = 0;
				$state_id = 0;
				$lat = 0;
				$long = 0;
				$state = "";
				$state_id = 0;
				for($j=0; $j< sizeof($crimes); $j++){
					if(strpos($headline, strtolower($crimes[$j]))){
						array_push($crimes_found, $crimes[$j]);
						$query2 = "SELECT `Id` FROM `Crime` WHERE `Type`='".$crimes[$j]."'";
						if($query_run2 = mysqli_query($con, $query2)){
							if(mysqli_num_rows($query_run2)>0){
								$crime_id = mysqli_fetch_assoc($query_run2)['Id'];
							}
						}
						for($k=0; $k<sizeof($locations); $k++){
							if(strpos($headline, strtolower($locations[$k]))){
								array_push($locations_of_crimes, $locations[$k]);
								$query3 = "SELECT `Id`,`Lat`,`Lng`,`State` FROM `Location` WHERE `Name`='".$locations[$k]."'";
								if($query_run3 = mysqli_query($con, $query3)){
									if(mysqli_num_rows($query_run3)>0){
										$row3 = mysqli_fetch_assoc($query_run3);
										$loc_id = $row3['Id'];
										$lat = $row3['Lat'];
										array_push($lat_locations, $lat);
										$long = $row3['Lng'];
										array_push($long_locations, $long);
										$state = $row3['State'];
										array_push($states_of_crimes, $state);
										$query4 = "SELECT `Id` FROM `State_Union_Territory` WHERE `Title`='".$state."'";
										if($query_run4 = mysqli_query($con, $query4)){
											if(mysqli_num_rows($query_run4)>0){
												$state_id = mysqli_fetch_assoc($query_run4)['Id'];
											}
										}
										
										// Crime_Location Counter Update -------------
										/*
										$query5 = "UPDATE `Crime_Location` SET `Counter` = `Counter` + 1 WHERE `Loc_Id`=".$loc_id." AND `Crime_Id`=".$crime_id."";
										if($query_run5 = mysqli_query($con, $query5)){
											echo "Updated Counter </br>";
										}
										*/
										// Update check - SELECT * FROM `Crime_Location` WHERE `Counter` > 0
										// Reset - UPDATE `Crime_Location` SET `Counter` = 0

										// Crime_State Counter Update -----------------
										/*
										if($state_id > 0){
											$query6 = "UPDATE `Crime_State` SET `Counter` = `Counter` + 1 WHERE `State_Id`=".$state_id." AND `Crime_Id`=".$crime_id."";
											if($query_run6 = mysqli_query($con, $query6)){
												echo "Updated Counter </br>";
											}
										}
										*/
										// Update check - SELECT * FROM `Crime_State` WHERE `Counter` > 0
										// Reset - UPDATE `Crime_State` SET `Counter` = 0
									}
								}
								break;
							}
						}
						break;
					}
				}
				
			}
		} else {
			echo "$i - No rows returned</br>";
		}
	} else {
		echo "$i - Query Issues</br>";
	}
	echo "</br>".($i+1)."000 records done.</br></br>";
}

echo " crime -----  location ---- lat ----- long ----- =".sizeof($crimes_found)."</br>";
//for($i=0; $i<sizeof($crimes_found); $i++){
	//echo "$crimes_found[$i]    ----    $locations_of_crimes[$i]    ------    $lat_locations[$i]  ------   $long_locations[$i] </br>";
//}




/*
echo "<pre>";
print_r($location);
echo "</pre>";
*/







echo "<br/>Time Elapsed: ".(microtime(true) - $time)."s";