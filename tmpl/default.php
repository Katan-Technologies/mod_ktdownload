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
$currentDateTime = date('Y-m-d H:i:s');
echo '<script src="https://kit.fontawesome.com/292543daea.js" crossorigin="anonymous"></script>';
echo '<link rel="stylesheet" href="modules/mod_ktdownload/css/style.css">';
$count = 1;
$imgarr=explode('#', $img);
echo'<img src="'.$imgarr[0].'"/>';
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
?>
