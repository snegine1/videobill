<?php

# check parameters
if ( !isset($_GET['l']) && !isset($_GET['n']) && !isset($_GET['i']) ) {
	echo 'Error: Invalid request';
	exit;
}

require_once('inc/init.php');

# bill_plans
$result_bill_plans = mysqli_query($db_conn, 'SELECT * FROM bill_plans');

if (mysqli_num_rows($result_bill_plans) <= 0) {
	echo 'Error:  No bill plans found in the database.';
	exit;
} else {
	while ($rec_table_datas = mysqli_fetch_row($result_bill_plans)) {
		// array_push($rec_bill_plans, $rec_table_datas[0], $rec_table_datas);
		$rec_bill_plans[$rec_table_datas[0]] = $rec_table_datas;
	}
}

# usage definitions
$result_usages_def = mysqli_query($db_conn, 'SELECT * FROM usages');

if (mysqli_num_rows($result_usages_def) <= 0) {
	echo 'Error:  No usages definition found in the database.';
	exit;
} else {
	while ($rec_table_datas = mysqli_fetch_row($result_usages_def)) {
		// array_push($rec_usages, $rec_table_datas[0], $rec_table_datas);
		$rec_usages[$rec_table_datas[0]] = $rec_table_datas;
	}
}

# discounts
$result_discounts = mysqli_query($db_conn, 'SELECT * FROM discounts');

if (mysqli_num_rows($result_discounts) <= 0) {
	echo 'Error:  No discounts found in the database.';
	exit;
}else {
	while ($rec_table_datas = mysqli_fetch_row($result_discounts)) {
		// array_push($rec_discounts, $rec_table_datas[0], $rec_table_datas);
		$rec_discounts[$rec_table_datas[0]] = $rec_table_datas;
	}
}

function display_result($avg_usages, $rec_usages, $analysis_result) {
	echo '<table><tr><td><table cellpadding=0 cellspacing=0 border=1>';
	echo <<<EOD
<tr><td colspan=20>
<table border=1>
<tr style="font-weight:bold"><td>&nbsp;</td><td>Average usages in mins.</td><td>Charge per min.</td></tr>
<tr><td>{$rec_usages[400][1]}</td><td align=center>{$avg_usages[0]}</td><td align=center>{$rec_usages[400][2]} &euro;</td></tr>
<tr><td>{$rec_usages[401][1]}</td><td align=center>{$avg_usages[1]}</td><td align=center>{$rec_usages[401][2]} &euro;</td></tr>
<tr><td>{$rec_usages[402][1]}</td><td align=center>{$avg_usages[2]}</td><td align=center>{$rec_usages[402][2]} &euro;</td></tr>
</table>
</td></tr>
EOD;
	
	echo '<tr style="font-weight:bold"><td colspan=9>Bill Plan</td><td colspan=3>Total discount based on avg. usage (mins.)</td><td colspan=3>Usages without discount (mins.)</td><td colspan=4>Usages total amount with discount applied (in &euro;)</td><TD>Total including Plan charge<br>(in &euro;)</td></tr>';
	echo '<tr style="font-weight:bold"><td>Plan ID</td><td>Code</td><td>Rate</td><td>Description</td><td>Local</td><td>Nat.</td><td>Int.</td><td>Disc.ID</td><td>Discount</td><td>Local</td><td>Nat.</td><td>Int.</td><td>Local</td><td>Nat.</td><td>Int.</td><td>Local</td><td>Nat.</td><td>Int.</td><td>Total</td></tr>';
	foreach ($analysis_result as $plan_id => $plan) {
		$style = ($plan_id == $analysis_result['recommendation']) ? 'style="color:blue"' : "";
		if (is_array($plan)) print '<tr '.$style.'><td>'.implode('</td><td>', $plan).'</td></tr>';
	}
	echo '</table></td></tr></table><br>';
}

// $avg_usages = array(354.8333, 209.8333, 86);
// bill_plan_analyse($rec_bill_plans, $rec_discounts, $rec_usages, $avg_usages, $analysis_result  );
// display_result($avg_usages, $rec_usages, $analysis_result);

// $avg_usages = array(265.1666, 0, 0);
// bill_plan_analyse($rec_bill_plans, $rec_discounts, $rec_usages, $avg_usages, $analysis_result  );
// display_result($avg_usages, $rec_usages, $analysis_result);

$avg_usages = array(
	isset($_GET['l']) ? intval($_GET['l']) : 0,
	isset($_GET['n']) ? intval($_GET['n']) : 0,
	isset($_GET['i']) ? intval($_GET['i']) : 0
	);
	
bill_plan_analyse($rec_bill_plans, $rec_discounts, $rec_usages, $avg_usages, $analysis_result  );
display_result($avg_usages, $rec_usages, $analysis_result);

