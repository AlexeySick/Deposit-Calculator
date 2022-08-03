<?php
$sumAdd = '0';
if (isset($_POST['startDate']) && isset($_POST['sum']) && isset($_POST['term']) && isset($_POST['percent']))
{
$startDate = $_POST["startDate"];
$sumN = $_POST["sum"];
$sumN = htmlentities($sumN);
$sumN = str_replace("&nbsp;",'',$sumN);
$percent = $_POST["percent"];
$sumAdd = '0';
$selectOption = $_POST['select'];
if($selectOption == 'год'){
	$term = $_POST["term"];
	$term = $term * 12;
}
else{
	$term = $_POST["term"];
}
if(!(isset($_POST["galka"])))
{
$sumAdd = '0';
}
else{
$sumAdd = $_POST["sumAdd"];
$sumAdd = htmlentities($sumAdd);
$sumAdd = str_replace("&nbsp;",'',$sumAdd);
}
$daysN = $_POST["term"];
$daysY = $_POST["startDate"];
$datePars = date_parse_from_format('d.m.Y', $startDate);
$month = $datePars['month'];
$year = $datePars['year'];
$day = $datePars['day'];
/* sumN = sumN-1 + (sumN-1 + sumAdd) * daysN * (percent / daysY)
*/
$daysN = cal_days_in_month(CAL_GREGORIAN, $month, $year);
$daysF = cal_days_in_month(CAL_GREGORIAN, 2, $year);
$daysY = 365 + $daysF - 28;
if (!($day == $daysN)) {
$sumN = $sumN + $sumN*($daysN - $day-1)/$daysY*($percent/100);
}
for ($i = 1; $i < $term; $i++) {
    if ($month == 12) {
	$month = 1;
	$year++;
	$daysF = cal_days_in_month(CAL_GREGORIAN, 2, $year);
	$daysY = 365 + $daysF - 28;
	}
	else {
	$month++;
	}
	$daysN = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $sumN = $sumN + $sumAdd +($sumN + $sumAdd)*($daysN)/$daysY*($percent/100);
}
if (!($day == 1)) {
if ($month == 12) {
	$month = 1;
	$year++;
	$daysF = cal_days_in_month(CAL_GREGORIAN, 2, $year);
	$daysY = 365 + $daysF - 28;
	}
	else {
	$month++;
	}
	$daysN = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $sumN = $sumN + $sumAdd +($sumN + $sumAdd)*($day-1)/$daysY*($percent/100);
}

echo json_encode(array('sumN' => $sumN));
}
else{
	echo 'ERROR';
}
?>