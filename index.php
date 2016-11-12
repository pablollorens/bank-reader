<?php

require 'vendor/autoload.php';

use BankReader\File\Parser;

error_reporting(E_ALL);
set_time_limit(0);

date_default_timezone_set('Europe/Amsterdam');

$loader = new Twig_Loader_Filesystem('Resources/views');
$twig = new Twig_Environment($loader, array(
    'cache' => 'var/cache',
));


$parser = new Parser(__DIR__ . "/Resources/data");

$transactions = $parser->parse();

$template = $twig->loadTemplate("index.html.twig");

echo $template->render(array('transactions' => $transactions));

exit;


$inputFileName = 'XLS161111215544.xls';
echo 'Loading file ',pathinfo($inputFileName,PATHINFO_BASENAME),' using IOFactory to identify the format<br />';
$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);


echo '<hr />';

$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

$total = 0;
$total_month = 0;

$prev_month = null;
print '<ul>';

foreach($sheetData as $row) {
	//$array = array("picobello"); 
	//$array = array("kruidvat"); 
	//$array = array("heijn", "jumbo", "feyter", "lidl", "slagerij");
	//$array = array("amigo");
	//$array = array("wehkamp");
	$array = array("domino's");
	//$array = array("mcdonald's");

	$explode = explode(' ', $row['H']);

	//var_dump($explode);

	$array_map = array_map('strtolower', $explode);

	$intersect = array_intersect($array_map, $array);

	if(0 < count($intersect))
	{
		$year = substr($row['C'], 0, 4);
		$month = substr($row['C'], 4, 2);
		$day = substr($row['C'], 6, 2);
		
		//print $day."/".$month."/".$year."   -   ". $row['H'] . "</br>";
		if($prev_month == null) {
			$total_month = 0;
			$prev_month = $month;
			print '<li>';
		} elseif($prev_month != $month) {
			print "TOTAL date(".$prev_month."/".$year.") =".number_format($total_month,2,'.',',')."&euro;</br>";
			print '</li><li>';
			
			$total_month = 0;
			
		}
		$total_month += floatval($row["G"]);
		$total += floatval($row['G']);
		$prev_month = $month;

		print '<div style="display:block; background-color: orange;">';
		print $row["H"]."      ".$row["G"]."</br>";
		print '</div>';
	}
}

print "TOTAL date(".$prev_month."/".$year.") =".$total_month."</br>";
print '</li>';
print '</ul>';


print $total;
