<?php 
/*
	This code is inspired by codeflix12 from GitHub and CodeFlix from Youtube.
*/
	$dataFile = 'json.data';//json.data is retrieve information from new york times api

	//if else statement to test either the data.json file is success  to get response or not from new york times api
	if(file_exists($dataFile)){
  	$data = json_decode(file_get_contents($dataFile));
	}else{
  		$api_url = 'https://content.api.nytimes.com/svc/weather/v2/current-and-seven-day-forecast.json?';
  		$data = file_get_contents($api_url);
  		file_put_contents($dataFile, $data);
  		$data = json_decode($data);
	}

	$current = $data->results->current[0];
	$forecast = $data->results->seven_day_forecast;

?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style>

	body{
	background: linear-gradient(to right, #000000,  #3361FF,  #3361FF);
    font-family: arial;
    text-align: center;
	}
	* {
	box-sizing: border-box;
	}
	.main {
	padding: 13px;
	}
	h1
	{
	color:white ;
	text-align: center;
	}
	h2
	{
	color:white ;
	text-align: center;
	}
	.rows::after {
	content: "";
	clear: both;
	display: table;
	}
	p
	{
	font-size: 20px;
	color:whitesmoke;
	}
	
	[class*="column-"] {
	float: left;
	padding: 13px;
	}
	.column-1 {width: 50%;}
	.column-2 {width: 50%;}
	}
  .weather-icon{
  	width:40%;
  	font-weight: bold;
  	background-color: #673f3f;
  	padding:10px;
  	border: 1px solid #fff;
  }
	</style>
</head>
	<body>
	<div class="main">
	<h1>Latest Weather Report for <?php echo $current->city ?> , <?php echo $current->country ?></h1>
	<p class="weather-icon">
              <img style="text-align: center;" src="<?php echo $current->image;?>">
              <?php echo $current->description;?>
     </p>
	</div>

	<div class="rows">

	<div class="column-1">
		<h2>Temperature</h2>
		<p><strong><?php echo $current->temp;?> in <?php echo $current->temp_unit;?></strong></p>
		<?php
 			 function convert2cen($value,$unit){
    			if($unit=='C'){
     				 	return $value;
   				 	}else if($unit=='F'){
     					$cen = ($value - 32) / 1.8;
      					return round($cen,2);
      				}
  				}
  		?>
		<p><strong><?php echo convert2cen($current->temp,$current->temp_unit);?> in C</strong></p>
	</div>

	<div class="column-2">
	<h2>Information details</h2>
	<p><strong>Wind Speed : </strong><?php echo $current->windspeed;?> <?php echo $current->windspeed_unit;?></p>
    <p><strong>Pressue : </strong><?php echo $current->pressure;?> <?php echo $current->pressure_unit;?></p>
    <p><strong>Visibility : </strong><?php echo $current->visibility;?> <?php echo $current->visibility_unit;?></p>
	</div>


	<form action="" method="get">
        <input type="text" name="search" value="<?php if(isset($_GET['search'])){echo $_GET['search'];} ?>" placeholder="Search..."/>

        <button type="submit" style="background-color: white; color:black;" class="btn btn-primary">Search</button>
    </form>

     <p><?php
     	$loop=0; foreach($forecast as $forecast){ 
     		$day = $forecast->day;
     		if($_GET['search'] == $day) {

     			echo $day ."<br>  ";
     			echo "<br>  ";
     	  		echo convert2cen($forecast->low,$forecast->low_unit);echo " °C - ";echo convert2cen($forecast->high,$forecast->high_unit);echo " °C";
     	  		echo "<br>  ";
     	  		echo $forecast->phrase ."<br>  ";
     	  		$loop++;
     		}
     	}
     ?></p>

   
	
</html>