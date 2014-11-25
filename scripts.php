<?php

/* API Geocode */
/*
$ip = "";
$api_key = "";


for($j=0; $j<sizeof($locations)-499; $j++){
	$address = $locations[$j+499];
	//$address = "Roorkee";

	$location = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($address)."&key=$api_key&userIp=$ip");
	$location = json_decode($location, true);

	//print_r($location);

	if($location['status'] == 'OK'){
		$lat = $location['results'][0]['geometry']['location']['lat'];
		$lng = $location['results'][0]['geometry']['location']['lng'];
		$hierarchy_arr = $location['results'][0]['address_components'];
		$hierarchy = "";
		$state = "";
		for($i=0; $i<sizeof($hierarchy_arr); $i++){
			$hierarchy .= (trim($hierarchy_arr[$i]['long_name']).',');
			if($hierarchy_arr[$i]['long_name'] == "India"){
				$state = $hierarchy_arr[$i-1]['long_name'];
			}
		}
		$hierarchy = substr($hierarchy, 0, strlen($hierarchy)-1);

		$query = "INSERT INTO `Locations` VALUES (NULL, '$address', '$lat', '$lng', '$hierarchy', '$state')";
	} else {
		if($location['status'] == "ZERO_RESULTS"){
			$query = "INSERT INTO `Locations` VALUES (NULL, '$address', 0, 0, '', '')";
		} else {
			$query = "INSERT INTO `Locations` VALUES (NULL, '$address', 'Issue', 'Issue', 'Issue', 'Issue')";
		}

	}

	echo " -- ".$location['status']."</br>";

	if($query_run = mysqli_query($con, $query)){
		echo "$j - Inserted Successfully.</br>";
	} else {
		echo "$j - Query didn't run.</br>";
	}
	usleep(400000);
}

// SQL Check - SELECT * FROM `Locations` WHERE `Lat` = 'Issue'
*/

 // -------------------------------------------------------------------------------------------------------------------  //

/* Headline Iteration */
/*
for($i=0; $i<$total_rows/1000; $i++){
	$query = "SELECT `Id`,`Title` FROM `Headline` LIMIT ".($i*1000).", 1000";
	if($query_run = mysqli_query($con, $query)){
		if(mysqli_num_rows($query_run)>0){
			while ($row = mysqli_fetch_assoc($query_run)){
				echo "Healine ".$row["Id"].": ".$row["Title"]."<br/>";
			}
		} else {
			echo "$i - No rows returned</br>";
		}
	} else {
		echo "$i - Query Issues</br>";
	}
	echo "</br>".($i+1)."000 records done.</br></br>";
} 
*/

// ------------------------------------------------------------------------------------------------------------------------ //

/* Inserting Database */

/*
if(isset($_GET['op']) && !empty($_GET['op'])){

	$operation = $_GET['op'];
	if($operation == 'insert'){

		//Benchmarking
		echo 'Start - 0.00s<br/>';
		$time = microtime(true);
		

		$file = fopen('Input.csv', 'r') or die("Unable to open file!");
		$headlinectr = 1;
		$postctr = 1;
		while(!feof($file)){
			$values = explode(',', fgets($file));

			// Check for blank first / last line
			if(sizeof($values) == 6){

				// 1 - Headline Insert
				$query = "INSERT INTO `Headline` VALUES (NULL, '$values[1]', '$values[5]') ON DUPLICATE KEY UPDATE Id=LAST_INSERT_ID(Id)";
				//echo $query.'<br/>';
				if($query_run = mysqli_query($con, $query)){
					
					echo $headlinectr++;
					echo ' Row inserted successfully in Headline Table<br/>';
					
					$query = "INSERT INTO `Post` VALUES ($values[0], LAST_INSERT_ID(), STR_TO_DATE($values[2],'%Y-%m-%d %H:%i:%s'), STR_TO_DATE($values[3],'%Y-%m-%d %H:%i:%s'), $values[4])";
					//echo $query.'<br/>';
					if($query_run = mysqli_query($con, $query)){
						ob_end_flush();
						echo $postctr++;
						echo ' Row inserted successfully in Post Table<br/>';
						ob_start();
					} else {
						echo 'Error - '.mysqli_error($con).'<br/>';
						echo 'Couldn\'t insert row in Post Table after id = '.mysql_insert_id().'<br/>';
						echo 'The contents were - <br/>';
						echo '<pre>';
						print_r($values);
						echo '</pre>';
					}
				} else {
					echo 'Error - '.mysqli_error($con).'<br/>';
					echo 'Couldn\'t insert row in Headline Table after id = '.mysql_insert_id().'<br/>';
					echo 'The contents were - <br/>';
					echo '<pre>';
					print_r($values);
					echo '</pre>';
				}
				

			}
		}
		fclose($file);
		echo "<br/>Time Elapsed: ".(microtime(true) - $time)."s";

		// Time Elapsed: 22535.621706963s for 364820 records
		
	}

}
*/

// ------------------------------------------------------------------------------------------------------------------------ //

/* Updating Crime_Location Counter */

/*
$query5 = "UPDATE `Crime_Location` SET `Counter` = `Counter` + 1 WHERE `Loc_Id`=".$loc_id." AND `Crime_Id`=".$crime_id."";
if($query_run5 = mysqli_query($con, $query5)){
	echo "Updated Counter </br>";
}
*/

// ------------------------------------------------------------------------------------------------------------------------ //

/* Updating Crime_Location Counter */

/*
$query5 = "UPDATE `Crime_Location` SET `Counter` = `Counter` + 1 WHERE `Loc_Id`=".$loc_id." AND `Crime_Id`=".$crime_id."";
if($query_run5 = mysqli_query($con, $query5)){
	echo "Updated Counter </br>";
}
*/
// Update check - SELECT * FROM `Crime_Location` WHERE `Counter` > 0
// Reset - UPDATE `Crime_Location` SET `Counter` = 0

// ------------------------------------------------------------------------------------------------------------------------ //

/* Updating Crime_State Counter */

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

?>