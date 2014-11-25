<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Crime Visualization</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=visualization"></script>
	<script type="text/javascript" src="jquery-2.1.1.min.js"></script>
	<script>

	var crime_selected = "";
	var state_selected = "";

	/*                -----------------------              MAPS CODE ------------------------------            */
	var map, heatmap;

	/*
	var cityData = [
	  new google.maps.LatLng(28.6454415, 77.0907573),  //New Delhi - 11z
	  new google.maps.LatLng(22.6759958, 88.3682527),  //Calcutta
	  new google.maps.LatLng(12.9539974, 77.6309395),  //Bangalore
	  new google.maps.LatLng(19.0822507, 72.8812042),  //Mumbai
	  new google.maps.LatLng(23.1994097, 77.4058914)  //Bhopal
	];
	*/

	function initialize() {
		var mapOptions = {
			zoom: 5,
			center: new google.maps.LatLng(21.1289956, 82.7792201),
			mapTypeId: google.maps.MapTypeId.SATELLITE
		};

		geocoder = new google.maps.Geocoder();

		map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

		//alert(1);
		google.load("visualization", "1", {packages:["geochart"], callback: visuCall});
		//alert(2);

	}

	function visuCall(){
		//alert('Loaded!');
		
		//alert("visuCall");
	}

	function getLocations(){

		var mapOptions = {
			zoom: 5,
			center: new google.maps.LatLng(21.1289956, 82.7792201),
			mapTypeId: google.maps.MapTypeId.SATELLITE
		};

		map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

		var cityGeocode = [];
		$.get("RequestHandler.php", { param : 'Pop_Crim_Loc' }, function(data){

			var lat_lngs = jQuery.parseJSON(data);

			//cityGeocode.push(new google.maps.LatLng(lat_lngs[i].lat, lat_lngs[i].lng));
			for (var key in lat_lngs) {
				cityGeocode.push(new google.maps.LatLng(lat_lngs[key].lat, lat_lngs[key].lng));
			}

			var pointArray = new google.maps.MVCArray(cityGeocode);
			heatmap = new google.maps.visualization.HeatmapLayer({
				data: pointArray
			});
			heatmap.setMap(map);

		});
		
	}

	function getStates(){

		$.get("RequestHandler.php", { param : 'Pop_Crim_State' }, function(data){

			var state_object = jQuery.parseJSON(data);

			var states = new google.visualization.DataTable();
			states.addColumn('string', 'States');
			states.addColumn('number', 'Crimes');
			states.addColumn('number', 'Area');
			for (var key in state_object) {
				states.addRow(state_object[key]);
			}

			

			var options = {
				region : '034',
				displayMode: 'markers',
				colorAxis: {colors: ['green', 'blue']}
			};

			var chart = new google.visualization.GeoChart(document.getElementById('map-canvas'));

			chart.draw(states, options);
		});

	}

	function toggleHeatmap() {
		heatmap.setMap(heatmap.getMap() ? null : map);
	}

	function changeGradient() {
		var gradient = [
		'rgba(0, 255, 255, 0)',
		'rgba(0, 255, 255, 1)',
		'rgba(0, 191, 255, 1)',
		'rgba(0, 127, 255, 1)',
		'rgba(0, 63, 255, 1)',
		'rgba(0, 0, 255, 1)',
		'rgba(0, 0, 223, 1)',
		'rgba(0, 0, 191, 1)',
		'rgba(0, 0, 159, 1)',
		'rgba(0, 0, 127, 1)',
		'rgba(63, 0, 91, 1)',
		'rgba(127, 0, 63, 1)',
		'rgba(191, 0, 31, 1)',
		'rgba(255, 0, 0, 1)'
		]
		heatmap.set('gradient', heatmap.get('gradient') ? null : gradient);
	}

	function changeRadius() {
		heatmap.set('radius', heatmap.get('radius') ? null : 20);
	}

	function changeOpacity() {
		heatmap.set('opacity', heatmap.get('opacity') ? null : 0.2);
	}

	google.maps.event.addDomListener(window, 'load', initialize);

</script>

</head>

<body>

	<div id="panel1">
		<button class="btn" onclick="getLocations()">Popular Criminal Locations</button>
		<button class="btn" onclick="getStates()">Popular Criminal States</button>
		<select class="crimes btn">
			<option value="0">Select a Crime</option>
			<option value="911">911</option>
			<option value="Abuse">Abuse</option>
			<option value="Accused">Accused</option>
			<option value="Accuser">Accuser</option>
			<option value="Adversary">Adversary</option>
			<option value="Affect">Affect</option>
			<option value="AFIS">AFIS</option>
			<option value="Against">Against</option>
			<option value="Aggravated">Aggravated</option>
			<option value="Alcohol">Alcohol</option>
			<option value="Alert">Alert</option>
			<option value="Alibi">Alibi</option>
			<option value="Alienate">Alienate</option>
			<option value="Allegation">Allegation</option>
			<option value="Ammunition">Ammunition</option>
			<option value="APB">APB</option>
			<option value="Armed">Armed</option>
			<option value="Arraignment">Arraignment</option>
			<option value="Arrest">Arrest</option>
			<option value="Arson">Arson</option>
			<option value="Assailant">Assailant</option>
			<option value="Assault">Assault</option>
			<option value="assault">assault</option>
			<option value="Attack">Attack</option>
			<option value="Autopsy">Autopsy</option>
			<option value="Backup">Backup</option>
			<option value="Bail">Bail</option>
			<option value="Ballistics">Ballistics</option>
			<option value="Bars">Bars</option>
			<option value="Beat">Beat</option>
			<option value="Belligerence">Belligerence</option>
			<option value="Blackmail">Blackmail</option>
			<option value="Bloodstain">Bloodstain</option>
			<option value="Bombing">Bombing</option>
			<option value="Brawl">Brawl</option>
			<option value="Breach">Breach</option>
			<option value="Break">Break</option>
			<option value="ing">ing</option>
			<option value="Bribery">Bribery</option>
			<option value="Brutality">Brutality</option>
			<option value="Bullying">Bullying</option>
			<option value="Burglary">Burglary</option>
			<option value="Bystander">Bystander</option>
			<option value="Capture">Capture</option>
			<option value="Caution">Caution</option>
			<option value="Chase">Chase</option>
			<option value="Cheat">Cheat</option>
			<option value="Coercion">Coercion</option>
			<option value="Collusion">Collusion</option>
			<option value="Combat">Combat</option>
			<option value="Complaint">Complaint</option>
			<option value="Complication">Complication</option>
			<option value="Conduct">Conduct</option>
			<option value="Confession">Confession</option>
			<option value="Conspiracy">Conspiracy</option>
			<option value="Contempt">Contempt</option>
			<option value="Controversial">Controversial</option>
			<option value="Conviction">Conviction</option>
			<option value="Cops">Cops</option>
			<option value="Coroner">Coroner</option>
			<option value="Corruption">Corruption</option>
			<option value="Counsel">Counsel</option>
			<option value="Counterfeit">Counterfeit</option>
			<option value="Court">Court</option>
			<option value="Crime">Crime</option>
			<option value="Criminal">Criminal</option>
			<option value="Criminal">Criminal</option>
			<option value="Criminology">Criminology</option>
			<option value="Cuffs">Cuffs</option>
			<option value="Custody">Custody</option>
			<option value="Damage">Damage</option>
			<option value="Danger">Danger</option>
			<option value="Dangerous">Dangerous</option>
			<option value="Deadly">Deadly</option>
			<option value="Dealings">Dealings</option>
			<option value="Death">Death</option>
			<option value="Defence">Defence</option>
			<option value="Defendant">Defendant</option>
			<option value="Deliberate">Deliberate</option>
			<option value="Delinquency">Delinquency</option>
			<option value="Denial">Denial</option>
			<option value="Detain">Detain</option>
			<option value="Deter">Deter</option>
			<option value="Dismember">Dismember</option>
			<option value="Disobedience">Disobedience</option>
			<option value="Disorderly">Disorderly</option>
			<option value="Disregard">Disregard</option>
			<option value="Disruption">Disruption</option>
			<option value="Dossier">Dossier</option>
			<option value="Drill">Drill</option>
			<option value="Drugs">Drugs</option>
			<option value="Elusive">Elusive</option>
			<option value="Embezzle">Embezzle</option>
			<option value="Emergency">Emergency</option>
			<option value="Encumber">Encumber</option>
			<option value="endangerment">endangerment</option>
			<option value="Enforce">Enforce</option>
			<option value="Entail">Entail</option>
			<option value="Escape">Escape</option>
			<option value="Ethical">Ethical</option>
			<option value="Evasive">Evasive</option>
			<option value="Eviction">Eviction</option>
			<option value="Evidence">Evidence</option>
			<option value="Evil">Evil</option>
			<option value="Exonerate">Exonerate</option>
			<option value="Explosives">Explosives</option>
			<option value="Expunge">Expunge</option>
			<option value="Extort">Extort</option>
			<option value="Extradition">Extradition</option>
			<option value="Failure">Failure</option>
			<option value="Fatality">Fatality</option>
			<option value="Fault">Fault</option>
			<option value="FBI">FBI</option>
			<option value="Federal">Federal</option>
			<option value="Felony">Felony</option>
			<option value="Ferocity">Ferocity</option>
			<option value="Fight">Fight</option>
			<option value="Fighting">Fighting</option>
			<option value="Fingerprin">Fingerprin</option>
			<option value="Firebombing">Firebombing</option>
			<option value="Firstdegree">Firstdegree</option>
			<option value="Flee">Flee</option>
			<option value="Footprints">Footprints</option>
			<option value="Forbidden">Forbidden</option>
			<option value="Force">Force</option>
			<option value="Forensics">Forensics</option>
			<option value="Forgery">Forgery</option>
			<option value="forgery">forgery</option>
			<option value="Frantic">Frantic</option>
			<option value="Fraud">Fraud</option>
			<option value="Furtive">Furtive</option>
			<option value="Gory">Gory</option>
			<option value="Grief">Grief</option>
			<option value="Grievance">Grievance</option>
			<option value="Guilty">Guilty</option>
			<option value="Gun">Gun</option>
			<option value="Handcuffs">Handcuffs</option>
			<option value="Harassment">Harassment</option>
			<option value="Harm">Harm</option>
			<option value="Harmful">Harmful</option>
			<option value="Heinous">Heinous</option>
			<option value="Hijack">Hijack</option>
			<option value="Holster">Holster</option>
			<option value="Homicide">Homicide</option>
			<option value="Hostage">Hostage</option>
			<option value="Hot">Hot</option>
			<option value="line">line</option>
			<option value="Humanity">Humanity</option>
			<option value="Identification">Identification</option>
			<option value="Illegal">Illegal</option>
			<option value="Immoral">Immoral</option>
			<option value="Impeach">Impeach</option>
			<option value="Imprison">Imprison</option>
			<option value="Indictment">Indictment</option>
			<option value="Injured">Injured</option>
			<option value="Injury">Injury</option>
			<option value="Inquest">Inquest</option>
			<option value="Interference">Interference</option>
			<option value="Interrogate">Interrogate</option>
			<option value="Intervention">Intervention</option>
			<option value="Intrastate">Intrastate</option>
			<option value="Intruder">Intruder</option>
			<option value="Invasive">Invasive</option>
			<option value="Investigate">Investigate</option>
			<option value="Investigation">Investigation</option>
			<option value="Irresponsible">Irresponsible</option>
			<option value="Jail">Jail</option>
			<option value="Judge">Judge</option>
			<option value="Judgment">Judgment</option>
			<option value="Judicial">Judicial</option>
			<option value="Judiciary">Judiciary</option>
			<option value="Jurisdiction">Jurisdiction</option>
			<option value="Jury">Jury</option>
			<option value="Justice">Justice</option>
			<option value="Juvenile">Juvenile</option>
			<option value="Kidnapping">Kidnapping</option>
			<option value="Kill">Kill</option>
			<option value="Killer">Killer</option>
			<option value="Killer">Killer</option>
			<option value="Larceny">Larceny</option>
			<option value="Laundering">Laundering</option>
			<option value="law">law</option>
			<option value="Leaks">Leaks</option>
			<option value="Legal">Legal</option>
			<option value="Legislation">Legislation</option>
			<option value="Lethal">Lethal</option>
			<option value="Libel">Libel</option>
			<option value="Lowlife">Lowlife</option>
			<option value="Lynch">Lynch</option>
			<option value="Mace">Mace</option>
			<option value="Malice">Malice</option>
			<option value="Malpractice">Malpractice</option>
			<option value="Man">Man</option>
			<option value="slaughter">slaughter</option>
			<option value="Manacled">Manacled</option>
			<option value="Manslaughter">Manslaughter</option>
			<option value="Marshal">Marshal</option>
			<option value="Minor">Minor</option>
			<option value="Minority">Minority</option>
			<option value="Miscreant">Miscreant</option>
			<option value="Misdemeanor">Misdemeanor</option>
			<option value="Missing">Missing</option>
			<option value="Moratorium">Moratorium</option>
			<option value="Murder">Murder</option>
			<option value="Murderer">Murderer</option>
			<option value="Nineoneone">Nineoneone</option>
			<option value="Nuisance">Nuisance</option>
			<option value="Offender">Offender</option>
			<option value="Offense">Offense</option>
			<option value="Order">Order</option>
			<option value="Patrol">Patrol</option>
			<option value="Pedestrian">Pedestrian</option>
			<option value="Penalize">Penalize</option>
			<option value="Penalty">Penalty</option>
			<option value="Perjury">Perjury</option>
			<option value="Perpetrator">Perpetrator</option>
			<option value="Petition">Petition</option>
			<option value="Phony">Phony</option>
			<option value="Plea">Plea</option>
			<option value="Plead">Plead</option>
			<option value="Police">Police</option>
			<option value="Precedent">Precedent</option>
			<option value="Precinct">Precinct</option>
			<option value="Prison">Prison</option>
			<option value="Probation">Probation</option>
			<option value="Prohibit">Prohibit</option>
			<option value="Proof">Proof</option>
			<option value="Prosecute">Prosecute</option>
			<option value="Prosecutor">Prosecutor</option>
			<option value="Prostitution">Prostitution</option>
			<option value="Protection">Protection</option>
			<option value="Protocol">Protocol</option>
			<option value="Punishment">Punishment</option>
			<option value="Quake">Quake</option>
			<option value="Quarrel">Quarrel</option>
			<option value="Quell">Quell</option>
			<option value="Quirk">Quirk</option>
			<option value="Quiver">Quiver</option>
			<option value="Radar">Radar</option>
			<option value="Raid">Raid</option>
			<option value="Rape">Rape</option>
			<option value="Raped">Raped</option>
			<option value="Reckless">Reckless</option>
			<option value="Record">Record</option>
			<option value="Refute">Refute</option>
			<option value="Register">Register</option>
			<option value="Regulations">Regulations</option>
			<option value="Reinforcement">Reinforcement</option>
			<option value="Reject">Reject</option>
			<option value="Release">Release</option>
			<option value="Repeal">Repeal</option>
			<option value="Reported">Reported</option>
			<option value="Reports">Reports</option>
			<option value="Reprobate">Reprobate</option>
			<option value="rescue">rescue</option>
			<option value="Resist">Resist</option>
			<option value="Restitution">Restitution</option>
			<option value="Restraining">Restraining</option>
			<option value="Restriction">Restriction</option>
			<option value="Revenge">Revenge</option>
			<option value="rifle">rifle</option>
			<option value="Rights">Rights</option>
			<option value="Riot">Riot</option>
			<option value="Robbery">Robbery</option>
			<option value="Rogue">Rogue</option>
			<option value="Sabotage">Sabotage</option>
			<option value="Safeguard">Safeguard</option>
			<option value="Scene">Scene</option>
			<option value="Search">Search</option>
			<option value="Secret">Secret</option>
			<option value="Seize">Seize</option>
			<option value="Seizure">Seizure</option>
			<option value="Sentence">Sentence</option>
			<option value="Sergeant">Sergeant</option>
			<option value="Serialkiller">Serialkiller</option>
			<option value="Sex">Sex</option>
			<option value="Shackles">Shackles</option>
			<option value="Sheriff">Sheriff</option>
			<option value="Shyster">Shyster</option>
			<option value="Slander">Slander</option>
			<option value="Slashing">Slashing</option>
			<option value="slaughter">slaughter</option>
			<option value="Slaying">Slaying</option>
			<option value="Smuggling">Smuggling</option>
			<option value="Sorrow">Sorrow</option>
			<option value="Speculation">Speculation</option>
			<option value="Spying">Spying</option>
			<option value="Squad">Squad</option>
			<option value="Stabbing">Stabbing</option>
			<option value="Stalking">Stalking</option>
			<option value="Statute">Statute</option>
			<option value="Stipulation">Stipulation</option>
			<option value="Subdue">Subdue</option>
			<option value="Subpoena">Subpoena</option>
			<option value="Summons">Summons</option>
			<option value="Suppress">Suppress</option>
			<option value="Surveillance">Surveillance</option>
			<option value="Survivor">Survivor</option>
			<option value="Suspect">Suspect</option>
			<option value="Suspected">Suspected</option>
			<option value="Suspicion">Suspicion</option>
			<option value="Suspicious">Suspicious</option>
			<option value="Terrorism">Terrorism</option>
			<option value="Testify">Testify</option>
			<option value="Theft">Theft</option>
			<option value="Theft">Theft</option>
			<option value="theft">theft</option>
			<option value="Threatening">Threatening</option>
			<option value="Threestrikes">Threestrikes</option>
			<option value="Thwart">Thwart</option>
			<option value="Tireslashing">Tireslashing</option>
			<option value="Torture">Torture</option>
			<option value="Toxicology">Toxicology</option>
			<option value="Traffic">Traffic</option>
			<option value="Trafficking">Trafficking</option>
			<option value="Tragedy">Tragedy</option>
			<option value="Trauma">Trauma</option>
			<option value="Trespass">Trespass</option>
			<option value="Trial">Trial</option>
			<option value="Trooper">Trooper</option>
			<option value="Unacceptable">Unacceptable</option>
			<option value="Unauthorized">Unauthorized</option>
			<option value="Unclaimed">Unclaimed</option>
			<option value="Unconstitutional">Unconstitutional</option>
			<option value="Undercover">Undercover</option>
			<option value="Understaffed">Understaffed</option>
			<option value="Unharmed">Unharmed</option>
			<option value="Unjust">Unjust</option>
			<option value="Unlawful">Unlawful</option>
			<option value="Unsolved">Unsolved</option>
			<option value="Uphold">Uphold</option>
			<option value="Vagrancy">Vagrancy</option>
			<option value="Vandalism">Vandalism</option>
			<option value="Victim">Victim</option>
			<option value="Victimize">Victimize</option>
			<option value="Vigilance">Vigilance</option>
			<option value="Vigilante">Vigilante</option>
			<option value="Violate">Violate</option>
			<option value="Violation">Violation</option>
			<option value="Violence">Violence</option>
			<option value="Volunteer">Volunteer</option>
			<option value="Voyeurism">Voyeurism</option>
			<option value="Vulnerable">Vulnerable</option>
			<option value="Warning">Warning</option>
			<option value="Warped">Warped</option>
			<option value="Warrant">Warrant</option>
			<option value="Weapon">Weapon</option>
			<option value="Wiretap">Wiretap</option>
			<option value="Wisdom">Wisdom</option>
			<option value="Witness">Witness</option>
			<option value="Worse">Worse</option>
			<option value="Wrong">Wrong</option>
		</select>
		<select class="states btn">
			<option value="0">Select a State</option>
			<option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
			<option value="Andhra Pradesh">Andhra Pradesh</option>
			<option value="Arunachal Pradesh">Arunachal Pradesh</option>
			<option value="Assam">Assam</option>
			<option value="Bihar">Bihar</option>
			<option value="Chandigarh">Chandigarh</option>
			<option value="Chhattisgarh">Chhattisgarh</option>
			<option value="Dadra and Nagar Haveli">Dadra and Nagar Haveli</option>
			<option value="Daman and Diu">Daman and Diu</option>
			<option value="Goa">Goa</option>
			<option value="Gujarat">Gujarat</option>
			<option value="Haryana">Haryana</option>
			<option value="Himachal Pradesh">Himachal Pradesh</option>
			<option value="Jammu and Kashmir">Jammu and Kashmir</option>
			<option value="Jharkhand">Jharkhand</option>
			<option value="Karnataka">Karnataka</option>
			<option value="Kerala">Kerala</option>
			<option value="Lakshadweep">Lakshadweep</option>
			<option value="Madhya Pradesh">Madhya Pradesh</option>
			<option value="Maharashtra">Maharashtra</option>
			<option value="Manipur">Manipur</option>
			<option value="Meghalaya">Meghalaya</option>
			<option value="Mizoram">Mizoram</option>
			<option value="Nagaland">Nagaland</option>
			<option value="Delhi">Delhi</option>
			<option value="Odisha">Odisha</option>
			<option value="Puducherry">Puducherry</option>
			<option value="Punjab">Punjab</option>
			<option value="Rajasthan">Rajasthan</option>
			<option value="Sikkim">Sikkim</option>
			<option value="Tamil Nadu">Tamil Nadu</option>
			<option value="Telangana">Telangana</option>
			<option value="Tripura">Tripura</option>
			<option value="Uttar Pradesh">Uttar Pradesh</option>
			<option value="Uttarakhand">Uttarakhand</option>
			<option value="West Bengal">West Bengal</option>
		</select>
	</div>

	<div id="panel2">
		<button class="btn" onclick="toggleHeatmap()">Toggle Heatmap</button>
		<button class="btn" onclick="changeGradient()">Change gradient</button>
		<button class="btn" onclick="changeRadius()">Change radius</button>
		<button class="btn" onclick="changeOpacity()">Change opacity</button>
	</div>

	<div id="map-canvas"></div>

	<script type="text/javascript">

	$('.states').on('change', function(){
		if($(this).val() != 0){

			state_selected = $(this).val();

			var parameter = { param : 'Crime_State_Specific' };
			if(state_selected.length > 0){
				parameter['state'] = state_selected;
			}
			if(crime_selected.length > 0 ){
				parameter['crime'] = crime_selected;
			}
				//console.log(parameter);
				
				var mapOptions = {
					zoom: 5,
					center: new google.maps.LatLng(21.1289956, 82.7792201),
					mapTypeId: google.maps.MapTypeId.SATELLITE
				};

				map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

				var cityGeocode = [];

				$.get("RequestHandler.php", parameter , function(data){

					console.log(data);
					var lat_lngs = jQuery.parseJSON(data);

					//cityGeocode.push(new google.maps.LatLng(lat_lngs[i].lat, lat_lngs[i].lng));
					for (var key in lat_lngs) {
						cityGeocode.push(new google.maps.LatLng(lat_lngs[key].lat, lat_lngs[key].lng));
					}

					var pointArray = new google.maps.MVCArray(cityGeocode);
					heatmap = new google.maps.visualization.HeatmapLayer({
						data: pointArray
					});
					heatmap.setMap(map);

				});
			} else {
				state_selected = "";
			}
		});

	$('.crimes').on('change', function(){
		if($(this).val() != 0){

			crime_selected = $(this).val();
			
			var parameter = { param : 'Crime_State_Specific' };
			if(state_selected.length > 0){
				parameter['state'] = state_selected;
			}
			if(crime_selected.length > 0 ){
				parameter['crime'] = crime_selected;
			}

			var mapOptions = {
				zoom: 5,
				center: new google.maps.LatLng(21.1289956, 82.7792201),
				mapTypeId: google.maps.MapTypeId.SATELLITE
			};

			map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

			var cityGeocode = [];

			$.get("RequestHandler.php", parameter, function(data){

				var lat_lngs = jQuery.parseJSON(data);

						//cityGeocode.push(new google.maps.LatLng(lat_lngs[i].lat, lat_lngs[i].lng));
						for (var key in lat_lngs) {
							cityGeocode.push(new google.maps.LatLng(lat_lngs[key].lat, lat_lngs[key].lng));
						}

						var pointArray = new google.maps.MVCArray(cityGeocode);
						heatmap = new google.maps.visualization.HeatmapLayer({
							data: pointArray
						});
						heatmap.setMap(map);

					});
		} else {
			crime_selected = "";
		}
	});

</script>
</body>
</html>