<!DOCTYPE HTML>
<?php
	// Turn off all error reporting
	error_reporting(0);

	putenv("NLS_LANG=AMERICAN_AMERICA.TH8TISASCII");
   	$ppm = mysqli_connect('localhost','root','','ppm');
   	$ppm->query("SET NAMES UTF8");
 
   	if(!$ppm){
	  	echo "Cannot connect to ppm ";
  	}
   else {
	  	//echo "Connect succeed"; 
  	}
   	$tariffs_group_list = ['บ้านอยู่อาศัย','กิจการขนาดเล็ก','กิจการขนาดกลาง','กิจการขนาดใหญ่','กิจการเฉพาะอย่าง','ส่วนราชการและองค์กรฯ',
						   'สูบน้ำเพื่อการ เกษตร','ไฟชั่วคราว','หน่วยขายไม่รวมไฟสาธารณะ','ไฟสาธารณะ','หน่วยขายรวมไฟสาธารณะ'];
   	$month_list = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

   	$sqlyear = "SELECT `Year` FROM energy_sales GROUP BY `Year`;";
   	$resyear = $ppm->query($sqlyear);
   	$drop_year = array();
   	while($row = $resyear->fetch_array()){
	  	array_push($drop_year,$row[0]);
   	}

   	if(!$_GET['YEAR']){
	  	$GetYear = $drop_year[0];
   	}else{
		$GetYear = $_GET['YEAR'];
   	}

   	$sqlmonth = "SELECT `Year`,`Month`,Month_Name FROM energy_sales WHERE `Year` = '$GetYear' GROUP BY `Year`,`Month`,Month_Name;";
   	$resmonth = $ppm->query($sqlmonth);
   	$drop_month = array();
   	while($row = $resmonth->fetch_array()){
	  	array_push($drop_month,$row[2]);
   	}

   	if(!$_GET['MONTH']){
	  	$GetMonth = 'all';
   	}else{
	  	$GetMonth = $_GET['MONTH'];
   	}

   	if($GetMonth == 'all'){
	  	$sqlmain ="SELECT `Year`,'ALL' AS `Month`,'ALL' AS Month_Name,SUM(Residential),SUM(Small_General_Service),SUM(Medium_General_Service),SUM(Large_General_Service),SUM(`Specific_Busines_ Service`),SUM(`Government_Institutions_and_Non_Profit_Organizations`),SUM(Water_Pumping_for_Agricultural_Purposes),SUM(Temporary_Tariff),SUM(`Public_Lightings`) FROM energy_sales WHERE `Year` = '$GetYear' GROUP BY `Year`;";
   	}else{
	  	$sqlmain ="SELECT `Year`,`Month`,Month_Name,Residential,Small_General_Service,Medium_General_Service,Large_General_Service,`Specific_Busines_ Service`,`Government_Institutions_and_Non_Profit_Organizations`,Water_Pumping_for_Agricultural_Purposes,Temporary_Tariff,`Public_Lightings` FROM energy_sales WHERE `Year` = '$GetYear' AND `Month_Name` = '$GetMonth';";
   	}

   	$resdata = $ppm->query($sqlmain);
   
   	$vyear = array();
   	$vmonth = array();
   	$vmonth_name = array();
   	$vresident = array();
   	$vsmall_serv = array();
   	$vmed_serv = array();
   	$vlarg_serv = array();
   	$vspec_serv = array();
   	$vgov = array();
   	$vagic = array();
   	$vtemp_tariff = array();
   	$vpublic = array();
   	while($row = $resdata->fetch_array()){
	  	array_push($vyear,$row[0]);
	  	array_push($vmonth,$row[1]);
	  	array_push($vmonth_name,$row[2]);
	  	array_push($vresident,$row[3]);
	  	array_push($vsmall_serv,$row[4]);
	  	array_push($vmed_serv,$row[5]);
	  	array_push($vlarg_serv,$row[6]);
	  	array_push($vspec_serv,$row[7]);
	  	array_push($vgov,$row[8]);
	  	array_push($vagic,$row[9]);
	  	array_push($vtemp_tariff,$row[10]);
	  	array_push($vpublic,$row[11]);
   	}

   	$sqlmain_pergroup ="SELECT `Year`,`Month`,Month_Name,Residential,Small_General_Service,Medium_General_Service,Large_General_Service,`Specific_Busines_ Service`,`Government_Institutions_and_Non_Profit_Organizations`,Water_Pumping_for_Agricultural_Purposes,Temporary_Tariff,`Public_Lightings` FROM energy_sales WHERE `Year` = '$GetYear'";
   	$resdata_pergroup = $ppm->query($sqlmain_pergroup);

   	$vyear_pergroup = array();
   	$vmonth_pergroup = array();
   	$vmonth_name_pergroup = array();
   	$vresident_pergroup = array();
   	$vsmall_serv_pergroup = array();
   	$vmed_serv_pergroup = array();
   	$vlarg_serv_pergroup = array();
   	$vspec_serv_pergroup = array();
   	$vgov_pergroup = array();
   	$vagic_pergroup = array();
   	$vtemp_tariff_pergroup = array();
   	$vpublic_pergroup = array();
   	while($row = $resdata_pergroup->fetch_array()){
	  	array_push($vyear_pergroup,$row[0]);
	  	array_push($vmonth_pergroup,$row[1]);
	  	array_push($vmonth_name_pergroup,$row[2]);
	  	array_push($vresident_pergroup,$row[3]);
	  	array_push($vsmall_serv_pergroup,$row[4]);
	 	array_push($vmed_serv_pergroup,$row[5]);
	  	array_push($vlarg_serv_pergroup,$row[6]);
	  	array_push($vspec_serv_pergroup,$row[7]);
	  	array_push($vgov_pergroup,$row[8]);
	  	array_push($vagic_pergroup,$row[9]);
	  	array_push($vtemp_tariff_pergroup,$row[10]);
	  	array_push($vpublic_pergroup,$row[11]);
   	}

   	$vyear_data = array();
   	$vmonth_data = array();
   	$vmonth_name_data = array();
   	$vresident_data = array();
   	$vsmall_serv_data = array();
   	$vmed_serv_data = array();
   	$vlarg_serv_data = array();
   	$vspec_serv_data = array();
   	$vgov_data = array();
   	$vagic_data = array();
   	$vtemp_tariff_data = array();
   	$vpublic_data = array();

   	$vdata_pergroup = array();
   	for($i=0;$i<count($vmonth_name_pergroup);$i++){
	  	for($j=0;$j<count($month_list);$j++){
		 	if($vmonth_name_pergroup[$i] == $month_list[$j]){
			   	if(!$_GET['GROUP']){
				  	$GetGroup = $tariffs_group_list[0];
			   	}else{
				  	$GetGroup = $_GET['GROUP'];
			   	}
			   	$vmonth_data[$j] = $vmonth_pergroup[$i];
			   	if($GetGroup == $tariffs_group_list[0]){
				  	$vdata_pergroup[$j] = $vresident_pergroup[$i];
			   	}if($GetGroup == $tariffs_group_list[1]){
				  	$vdata_pergroup[$j] = $vsmall_serv_pergroup[$i];
			   	}if($GetGroup == $tariffs_group_list[2]){
				  	$vdata_pergroup[$j] = $vmed_serv_pergroup[$i];
			   	}if($GetGroup == $tariffs_group_list[3]){
				  	$vdata_pergroup[$j] = $vlarg_serv_pergroup[$i];
			   	}if($GetGroup == $tariffs_group_list[4]){
				  	$vdata_pergroup[$j] = $vspec_serv_pergroup[$i];
			   	}if($GetGroup == $tariffs_group_list[5]){
				  	$vdata_pergroup[$j] = $vgov_pergroup[$i];
			   	}if($GetGroup == $tariffs_group_list[6]){
				  	$vdata_pergroup[$j] = $vagic_pergroup[$i];
			   	}if($GetGroup == $tariffs_group_list[7]){
				  	$vdata_pergroup[$j] = $vtemp_tariff_pergroup[$i];
			   	}if($GetGroup == $tariffs_group_list[8]){
				  	$vdata_pergroup[$j] = $vresident_pergroup[$i]+$vsmall_serv_pergroup[$i]+$vmed_serv_pergroup[$i]+$vlarg_serv_pergroup[$i]+$vspec_serv_pergroup[$i]+$vgov_pergroup[$i]+$vagic_pergroup[$i]+$vtemp_tariff_pergroup[$i];
			   	}if($GetGroup == $tariffs_group_list[9]){
				  	$vdata_pergroup[$j] = $vpublic_pergroup[$i];
			   	}if($GetGroup == $tariffs_group_list[10]){
				  	$vdata_pergroup[$j] = $vresident_pergroup[$i]+$vsmall_serv_pergroup[$i]+$vmed_serv_pergroup[$i]+$vlarg_serv_pergroup[$i]+$vspec_serv_pergroup[$i]+$vgov_pergroup[$i]+$vagic_pergroup[$i]+$vtemp_tariff_pergroup[$i]+$vpublic_pergroup[$i];
			   	}
			   	/*
			   	$vyear_data[$j] = $vyear_pergroup[$i];
			   	$vmonth_data[$j] = $vmonth_pergroup[$i];
			   	$vmonth_name_data[$j] = $vmonth_name_pergroup[$i];
			   	$vresident_data[$j] = $vresident_pergroup[$i];
			   	$vsmall_serv_data[$j] = $vsmall_serv_pergroup[$i];
			   	$vmed_serv_data[$j] = $vmed_serv_pergroup[$i];
			   	$vlarg_serv_data[$j] = $vlarg_serv_pergroup[$i];
			   	$vspec_serv_data[$j] = $vspec_serv_pergroup[$i];
			  	$vgov_data[$j] = $vgov_pergroup[$i];
			   	$vagic_data[$j] = $vagic_pergroup[$i];
			   	$vtemp_tariff_data[$j] = $vtemp_tariff_pergroup[$i];
			   	$vpublic_data[$j] = $vpublic_pergroup[$i];
			   	*/
		 	}
	  	}
   	}
   	//print_r($vresident_data);
   	//print_r($vresident);
   	//print_r($vdata_pergroup);
?>

<html>
    
   	<head>
	  	<meta name="viewport" content="width=device-width, initial-scale=1">
	  	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	  	<meta http-equiv="Content-Language" content="th"> 
	  	<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
	  	<meta http-equiv="Content-Type" content="text/html; charset=tis-620"> 
	  	<title>MEA's Energy Sales</title>
	  	<script src="amcharts/amcharts.js" type="text/javascript"></script>
	  	<script src="amcharts/serial.js" type="text/javascript"></script>
	  	<script src="amcharts/pie.js" type="text/javascript"></script>
	  	<script src="amcharts/themes/light.js" type="text/javascript"></script>
	  	<script src="amcharts/plugins/export/export.js" type="text/javascript"></script>
	  	<link href="amcharts/plugins/export/export.css" rel="stylesheet" type="text/css">
	  	<script src="js/jquery.min.js"></script>
	  	<link href="css/bootstrap.min.css" rel="stylesheet">
	  	<link rel="stylesheet" href="css/animate.css">

      	<style type="text/css">
		 	body {
				background-image: url("amcharts/patterns/yellow_pastel_pattern.jpg");
		 	}
		 	#chartdiv,#chartdiv2 {
				width		: 100%;
				height		: 500px;
				font-size	: 11px;  
		 	}
		 	#chartdiv3 {
				width		: 100%;
				height		: 435px;
				font-size	: 11px;
		 	}									
		 	.amcharts-export-menu-top-right {
				top: 10px;
		   	right: 0;
		 	}
									
	  	</style>

   	</head>

   	<body>
	   	<div class="container">
		  	<div name= 'dropdown' style='padding:20px;'>
			 	ปี : 
			 	<select id= "YEAR" name="YEAR" onchange="calculate()">
					<?PHP for($i = 0 ; $i < count($drop_year);$i++){ ?>
					  	<option value="<?PHP  echo $drop_year[$i]; ?>" <?php if($_GET['YEAR']==$drop_year[$i]){ echo "selected='selected'";} ?>><?PHP  echo $drop_year[$i]; ?></option>
					<?PHP } ?>
			 	</select>
			 	เดือน :
			 	<select id= "MONTH" name="MONTH" onchange="calculate()">
					<option value="all" <?php if($_GET['MONTH']=='all'){ echo "selected='selected'";} ?>>All</option>
					<?PHP for($i = 0 ; $i < count($drop_month);$i++){ ?>
					  	<option value="<?PHP  echo $drop_month[$i]; ?>" <?php if($_GET['MONTH']==$drop_month[$i]){ echo "selected='selected'";} ?>><?PHP  echo $drop_month[$i]; ?></option>
					<?PHP } ?>
				</select>	
			</div>

	   		<script type="text/javascript">
		  		function calculate(){
			 		var YEAR = document.getElementById('YEAR').value;
			 		var MONTH = document.getElementById('MONTH').value;
			 		var GROUP = document.getElementById('GROUP').value;
			 		window.location.href = "graph.php?YEAR=" + YEAR + "&MONTH=" + MONTH + "&GROUP=" + GROUP;
		  			}
	   		</script>

	   		<div class="wow fadeIn" id="chartdiv"></div>

	   		<div class="wow bounceInDown" id="chartdiv3"></div>
	   		<div class="container-fluid">
		  		<div class="row text-center" style="overflow:hidden;">
						<div class="col-sm-3" style="float: none !important;display: inline-block;">
				   		<label class="text-left">Angle:</label>
				   		<input class="chart-input" data-property="angle" type="range" min="0" max="60" value="30" step="1"/>	
						</div>

						<div class="col-sm-3" style="float: none !important;display: inline-block;">
				   		<label class="text-left">Depth:</label>
				   		<input class="chart-input" data-property="depth3D" type="range" min="1" max="25" value="10" step="1"/>
						</div>
						<div class="col-sm-3" style="float: none !important;display: inline-block;">
				   		<label class="text-left">Inner-Radius:</label>
				   		<input class="chart-input" data-property="innerRadius" type="range" min="0" max="80" value="0" step="1"/>
						</div>
		  		</div>
	   		</div>

	   		<div name= 'dropdown' style='padding:20px;'>
		  		ประเภทผู้ใช้ไฟฟ้า : 
		  		<select id= "GROUP" name="GROUP" onchange="calculate()">
			 		<?PHP for($i = 0 ; $i < count($tariffs_group_list);$i++){ ?>
				   		<option value="<?PHP  echo $tariffs_group_list[$i]; ?>" <?php if($_GET['GROUP']==$tariffs_group_list[$i]){ echo "selected='selected'";} ?>><?PHP  echo $tariffs_group_list[$i]; ?></option>
			 		<?PHP } ?>
		  		</select>
	   		</div>
	   		<div class="wow zoomIn data-wow-delay='5s'" id="chartdiv2"></div>

	   		<script type="text/javascript">
		  		var chart = AmCharts.makeChart("chartdiv", {
		  		"type": "serial",
		  		"theme": "light",
		  		"titles": [{
			  		"text": "ประเภทผู้ใช้ไฟฟ้าแยกตามเดือน",
			  		"size": 18
		  		}],
		  		"marginRight": 70,
		  		"dataProvider": [{
		  		"tariffs_group": "<?php echo $tariffs_group_list[0] ?>",
		  		"sales": '<?php echo $vresident[0]; ?>',
		  		"color": "#FF0F00"
		  		}, {
		  		"tariffs_group": "<?php echo $tariffs_group_list[1] ?>",
		  		"sales": '<?php echo $vsmall_serv[0]; ?>',
		  		"color": "#FF6600"
		  		}, {
		  		"tariffs_group": "<?php echo $tariffs_group_list[2] ?>",
		  		"sales": '<?php echo $vmed_serv[0]; ?>',
		  		"color": "#FF9E01"
		  		}, {
		  		"tariffs_group": "<?php echo $tariffs_group_list[3] ?>",
		  		"sales": '<?php echo $vlarg_serv[0]; ?>',
		  		"color": "#FCD202"
		  		}, {
		  		"tariffs_group": "<?php echo $tariffs_group_list[4] ?>",
		  		"sales": '<?php echo $vspec_serv[0]; ?>',
		  		"color": "#F8FF01"
		  		}, {
		  		"tariffs_group": "<?php echo $tariffs_group_list[5] ?>",
		  		"sales": '<?php echo $vgov[0]; ?>',
		  		"color": "#B0DE09"
		  		}, {
		  		"tariffs_group": "<?php echo $tariffs_group_list[6] ?>",
		  		"sales": '<?php echo $vagic[0]; ?>',
		  		"color": "#04D215"
		  		}, {
		  		"tariffs_group": "<?php echo $tariffs_group_list[7] ?>",
		  		"sales": '<?php echo $vtemp_tariff[0]; ?>',
		  		"color": "#0D8ECF"
		  		}, {
		  		"tariffs_group": "<?php echo $tariffs_group_list[8] ?>",
		  		"sales": '<?php echo $vresident[0]+$vsmall_serv[0]+$vmed_serv[0]+$vlarg_serv[0]+$vspec_serv[0]+$vgov[0]+$vagic[0]+$vtemp_tariff[0]; ?>',
		  		"color": "#0D52D1"
		  		}, {
		  		"tariffs_group": "<?php echo $tariffs_group_list[9] ?>",
		  		"sales": '<?php echo $vpublic[0]; ?>',
		  		"color": "#2A0CD0"
		  		}, {
		  		"tariffs_group": "<?php echo $tariffs_group_list[10] ?>",
		  		"sales": '<?php echo $vresident[0]+$vsmall_serv[0]+$vmed_serv[0]+$vlarg_serv[0]+$vspec_serv[0]+$vgov[0]+$vagic[0]+$vtemp_tariff[0]+$vpublic[0]; ?>',
		  		"color": "#8A0CCF"
		  		}],
		  		"valueAxes": [{
		  		"axisAlpha": 0,
		  		"position": "left",
		  		"title": "สถิติจำนวนหน่วยจำหน่าย (ล้านหน่วย)"
		  		}],
		  		"startDuration": 1,
		  		"graphs": [{
		  		"balloonText": "<b>[[category]]: [[value]]</b>",
		  		"labelText":"[[value]]",
		  		"fillColorsField": "color",
		  		"fillAlphas": 0.9,
		  		"lineAlpha": 0.2,
		  		"type": "column",
		  		"valueField": "sales"
		  		}],
		  		"chartCursor": {
		  		"categoryBalloonEnabled": false,
		  		"cursorAlpha": 0,
		  		"zoomable": false
		  		},
		  		"categoryField": "tariffs_group",
		  		"categoryAxis": {
		  		"gridPosition": "start",
		  		"labelRotation": 45
		  		},
		  		"export": {
		  		"enabled": true
		  		}

		  		});

		  		var graphData1 =  generateGraphData1();
		  		var chart = AmCharts.makeChart("chartdiv2", {
		  		"type": "serial",
		  		"theme": "light",
		  		"titles": [{
			  		"text": "แยกตามประเภทผู้ใช้ไฟฟ้า",
			  		"size": 18
		  		}],
		  		"legend": {
			  		"equalWidths": true,
			  		"useGraphSettings": true,
			  		"valueAlign": "left",
			  		"valueWidth": 80 ,
			  		//"valueHeight": 10
		  		},
		   
		  		"dataProvider": [{
		  		"tariffs_group": "<?PHP echo $GetGroup; ?>", 
		  		"Jan": "<?php echo $vdata_pergroup[0] ?>", "Feb": "<?php echo $vdata_pergroup[1] ?>", "Mar": "<?php echo $vdata_pergroup[2] ?>", "Apr": "<?php echo $vdata_pergroup[3] ?>","May": "<?php echo $vdata_pergroup[4] ?>","Jun": "<?php echo $vdata_pergroup[5] ?>",
		  		"Jul": "<?php echo $vdata_pergroup[6] ?>",  "Aug": "<?php echo $vdata_pergroup[7] ?>", "Sep": "<?php echo $vdata_pergroup[8] ?>", "Oct": "<?php echo $vdata_pergroup[9] ?>","Nov": "<?php echo $vdata_pergroup[10] ?>","Dec": "<?php echo $vdata_pergroup[11] ?>"
	  		}],
		  		"valueAxes": [{
		  		"axisAlpha": 0,
		  		"position": "left",
		  		"title": "สถิติจำนวนหน่วยจำหน่าย (ล้านหน่วย)"
		  		}],
		  		"startDuration": 1,
		  		"graphs":graphData1,
		  		"chartCursor": {
			  		"cursorAlpha": 0.1,
			  		"cursorColor":"#000000",
			   		"fullWidth":true,
			  		"valueBalloonsEnabled": false,
			  		"zoomable": true
		  		},
		  		"categoryField": "tariffs_group",
		  		"creditsPosition" : "top-right",
		  		"categoryAxis": {
			  		"gridPosition": "start",
			  		"labelRotation" : 0
		  		},
		  		"export": {
		  		"enabled": true
		  		}    
		  		});
	  
		  		function generateGraphData1() {
		  	
			 		var graphData1 = [];
			 		var Currentmonth = <?php echo count($vmonth_data) ?>;
			 		var month = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
			 		var colorpick = ['#FF0F00','#FF6600','#FF9E01','#FCD202','#B0DE09','#04D215','#0D8ECF','#0D52D1','#2A0CD0','#8A0CCF','#CD0D74','#FF6699']
			 		for(i = 0 ; i < Currentmonth ; i++){
						graphData1.push({
						 		"balloonText": "<b>[[category]] ([[title]]) : [[value]]</b>",
						 		"legendValueText": "[[value]] ",
						 		"labelText":"[[value]]",
						 		"fillColors": colorpick[i],
						 		"fillAlphas": 0.9,
						 		"lineAlpha": 0.2,
						 		"type": "column",
						  		"title": month[i],
						 		"valueField": month[i]
				 		});
			 		}	
						return graphData1 ;
		  		}

		  		var chart = AmCharts.makeChart( "chartdiv3", {
					"type": "pie",
					"theme": "light",
					"dataProvider": [ {
			  		"country": "<?php echo $tariffs_group_list[0] ?>",
			  		"value": '<?php echo $vresident[0]; ?>'
					}, {
			  		"country": "<?php echo $tariffs_group_list[1] ?>",
			  		"value": '<?php echo $vsmall_serv[0]; ?>'
					}, {
			  		"country": "<?php echo $tariffs_group_list[2] ?>",
			  		"value": '<?php echo $vmed_serv[0]; ?>'
					}, {
			  		"country": "<?php echo $tariffs_group_list[3] ?>",
			  		"value": '<?php echo $vlarg_serv[0]; ?>'
					}, {
			  		"country": "<?php echo $tariffs_group_list[4] ?>",
			  		"value": '<?php echo $vspec_serv[0]; ?>'
					}, {
			  		"country": "<?php echo $tariffs_group_list[5] ?>",
			  		"value": '<?php echo $vgov[0]; ?>'
					}, {
			  		"country": "<?php echo $tariffs_group_list[6] ?>",
			  		"value": '<?php echo $vagic[0]; ?>'
					}, {
			  		"country": "<?php echo $tariffs_group_list[7] ?>",
			  		"value": '<?php echo $vtemp_tariff[0]; ?>'
					}, {
			  		"country": "<?php echo $tariffs_group_list[9] ?>",
			  		"value": '<?php echo $vpublic[0]; ?>'
					}],
					"valueField": "value",
					"titleField": "country",
					"outlineAlpha": 0.4,
					"depth3D": 15,
					"balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
					"angle": 30,
					"creditsPosition" : "bottom-right",
					"export": {
			  		"enabled": true
					}
		  		} );
		  		jQuery( '.chart-input' ).off().on( 'input change', function() {
					var property = jQuery( this ).data( 'property' );
					var target = chart;
					var value = Number( this.value );
					chart.startDuration = 0;

					if ( property == 'innerRadius' ) {
			  		value += "%";
					}

					target[ property ] = value;
					chart.validateNow();
		  		} );

	   		</script>
	   		<script src="js/bootstrap.min.js"></script>
	   		<script src="js/wow.min.js"></script>
	  		<script> new WOW().init(); </script>
	   	</div>
   	</body>
</html>

