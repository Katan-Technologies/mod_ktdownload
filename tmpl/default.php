<?php 
// No direct access
defined('_JEXEC') or die; 
/**
 * Template for KT Downloads module
 * 
 * @subpackage Modules
 * @license        GNU/GPL, see LICENSE.php
 * @link       http://www.gokatan.com
 * mod_ktdownload is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
?>
<?php 
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
if (!class_exists('PhocaDownloadFile')) {
	include("administrator/components/com_phocadownload/libraries/phocadownload/file/file.php");
	include("administrator/components/com_phocadownload/libraries/phocadownload/path/path.php");
	include("administrator/components/com_phocadownload/libraries/phocadownload/utils/settings.php");
}
$uri = Uri::getInstance();
$url = $uri->toString();
// Set the new timezone
//date_default_timezone_set('America/Port_of_Spain');
$tz=date_default_timezone_get();
		//echo '<br/>TimeZone (O): '.$tz;
    	//echo '<br/>Type: '.gettype($tz);
		if($tz!=='UTC'){
			date_default_timezone_set('UTC'); 
			assert(date_default_timezone_get() === 'UTC');
		}
$currentDateTime = date('Y-m-d H:i:s');
echo '<script src="https://kit.fontawesome.com/292543daea.js" crossorigin="anonymous"></script>';
echo '<link rel="stylesheet" href="modules/mod_ktdownload/css/style.css">';
$count = 1;
/*$imgarr=explode('#', $img);
if($imgarr[0]!='1'){
	echo'<img src="'.$imgarr[0].'" class="ktdlimg"/>';
}*/

echo '<ul class="pdlst">';
foreach($ktdownload as $download){
	if(gettype($download)=='array'){
		if(strtotime($currentDateTime)>=strtotime($download['5'])&&((strtotime($currentDateTime)<=strtotime($download['6']))||(strtotime($download['6'])==strtotime('0000-00-00 00:00:00')))){//since I could not do this in the sql statement I'm doing this here ... if current date is later than or equal to the publish_up date
			$url = JURI::root().'index.php?option=com_phocadownload&view=category&download='.$download['2'].':'.$download['1'].'&id='.$download['3'].':'.$download['9'].'&Itemid=367&lang=en';
			echo '<li><a href="'.$url.'"><i class="fa-solid fa-file-pdf"></i>  '.$download['0'].' ['.$download['8'].']  <i class="fa-solid fa-download"></i></a></li>';
			if($maxentries!=0 && $maxentries==$count){
				break;
			}
			$count++;
		}
		$compURL = JURI::root().'index.php?option=com_phocadownload&view=category&id='.$download['3'].'&Itemid=367&lang=en';
	}
	elseif(gettype($download)=='object'){
		$ktdownldfl = new PhocaDownloadFile;
		$pdurl = Uri::root().'index.php/downloads?download='.$download->id.':'.$download->alias;
    	//print_r($download);
    	//$tz=date_default_timezone_get();
    	/*echo gettype($tz);
    	$dateTimeZoneTaipei = new DateTimeZone("Asia/Taipei");
$dateTimeZoneJapan = new DateTimeZone("Asia/Tokyo");
    $dateTimeTaipei = new DateTime("now", $dateTimeZoneTaipei);
$dateTimeJapan = new DateTime("now", $dateTimeZoneJapan);
    $timeOffset = $dateTimeZoneJapan->getOffset($dateTimeTaipei);*/
    
    //echo '<br/>'.$timeOffset;
    /*$dateTimeZoneDefault = new DateTimeZone("UTC");
    $dateTimeZoneLocal = new DateTimeZone("America/Port_of_Spain");
    $dateTimeDefault = new DateTime("now",$dateTimeZoneDefault);
    $dateTimeLocal = new DateTime("now",$dateTimeZoneLocal);
    $newTimeOffset = $dateTimeZoneDefault->getOffset($dateTimeLocal);
    echo '<br/>Default Time Zone: ';
    print_r($dateTimeZoneDefault);
    echo '<br/>Local Time Zone: ';
    print_r($dateTimeZoneLocal);
    echo '<br/>Default Time: ';
    print_r($dateTimeDefault);
    echo '<br/>Local Time: ';
    print_r($dateTimeLocal);
    echo '<br/>Offset: '.$newTimeOffset;*/

    	//$tz1=timezone_open(date_default_timezone_get());
    	//$datetimeTZ = date_create("now", timezone_open("Europe/Amsterdam")); 
    	//echo timezone_offset_get($tz1, $datetimeTZ);
    	/*echo '<br/>Timezone: '.$tz;
    	echo '<br/>Current DateTime: '.$currentDateTime;
    	echo '<br/>Publish Up Date Time: '.$download->publish_up;
        // create a $dt object with the UTC timezone
$dt = new DateTime($download->publish_up, new DateTimeZone('UTC'));

// get the local timezone
$loc = (new DateTime)->getTimezone();
    echo '<br/>local timezone: ';
    print_r($loc);

// change the timezone of the object without changing its time
$dt->setTimezone($loc);

// format the datetime
$dt->format('Y-m-d H:i:s T');
    echo '<br/>New Publish Up Date: ';
    print_r($dt);
    echo '<br/>timezone: '.date('P');
    $usersNow = new DateTime('now', new DateTimeZone('-0400'));
    echo '<br/>usersNow: ';
    print_r($usersNow);
     echo '<br/>timezone: '.date('P');*/
		if(strtotime($currentDateTime)>=strtotime($download->publish_up)&&((strtotime($currentDateTime)<=strtotime($download->publish_down))||(strtotime($download->publish_down)==strtotime('0000-00-00 00:00:00')))){//since I could not do this in the sql statement I'm doing this here ... if current date is later than or equal to the publish_up date
			$filesize = $ktdownldfl->getFileSize($download->filename);
			echo '<li><a href="'.$pdurl.'"><div class="pdm-title"><i class="fa-solid fa-file-pdf"></i>  '.$download->title.' </div><div class="pdm-dwn"><span>['.$filesize.' ]</span> <i class="fa-solid fa-download"></i></div><a/></li>';
			if($maxentries!=0 && $maxentries==$count){
				break;
			}
			$count++;
		}
		$compURL = JURI::root().'index.php?option=com_phocadownload&view=category&id='.$download->catid.'&Itemid=367&lang=en';
    		
    }
}
echo '</ul>';
echo '<p class="pdbtn"><a href="'.$compURL.'">View & Download All</a></p>';
// Set the new timezone
/*date_default_timezone_set('America/Port_of_Spain');
$date = date('d-m-y h:i:s');
echo $date;*/
?>
