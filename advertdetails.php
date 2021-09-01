<?php
	include_once('includes/php/header.inc.php');

	$id = (is_numeric($_GET['AdvertID'])) ? $_GET['AdvertID'] : 0 ;
	if($id == 0 || ($advert = getAdvertDetails($MySQL, $id)) == 0)
	{
		header("Status: 301 Moved Permanently") ;
		header("Location: https://www.ayumibay.com/") ;
		exit();
	} else {
		include_once('includes/php/top.inc.php');
?>
<?php
	$xml = $XMLReader->getXML('includes-currency');
?>
<div id="advertthumbswrapper" data-toggle="modal-gallery" data-target="#modal-gallery" data-selector="div.gallery-item">
<div class="gallery-item advertthumbs" data-href="/pics/<?php echo $id ; ?>/<?php echo $advert['pic1'] ; ?>.jpg" title="<?php echo $advert['name'] ; ?> 1"><img src="/pics/<?php echo $id ; ?>/<?php echo $advert['pic1'] ; ?>_thumb.jpg" width="233" alt="<?php echo $advert['name'] ; ?> 1" /></div>
<?php if(!empty($advert['pic2'])) { ?>
<div class="gallery-item advertthumbs" data-href="/pics/<?php echo $id ; ?>/<?php echo $advert['pic2'] ; ?>.jpg" title="<?php echo $advert['name'] ; ?> 2"><img src="/pics/<?php echo $id ; ?>/<?php echo $advert['pic2'] ; ?>_thumb.jpg" width="233" alt="<?php echo $advert['name'] ; ?> 2" /></div>
<?php } if(!empty($advert['pic3'])) { ?>
<div class="gallery-item advertthumbs" data-href="/pics/<?php echo $id ; ?>/<?php echo $advert['pic3'] ; ?>.jpg" title="<?php echo $advert['name'] ; ?> 3"><img src="/pics/<?php echo $id ; ?>/<?php echo $advert['pic3'] ; ?>_thumb.jpg" width="233" alt="<?php echo $advert['name'] ; ?> 3" /></div>
<?php } ?>
</div>
<div id="advertinfo">
<h1><?php echo $advert['name']; if($advert['display-age'] && !empty($advert['birthdate'])) echo ' - '.getAge($advert['birthdate']).'   '; ?><br /><small><em><?php echo getCounty($MySQL, $advert['county']); ?></em></small></h1>
<h3><em><u><?php echo $myvar->Gender; ?></u> <?php echo getSex($advert['sex'], $XMLReader);?></em></h3>
<h3><em><u><?php echo $myvar->Type; ?></u> <?php echo getAdvertType($advert['type'], $XMLReader); ?></em></h3>
<h3><em><u><?php echo $myvar->Ethnicity; ?></u> <?php echo getEthnicity($advert['ethnicity'], $XMLReader); ?></em></h3>
<?php if($advert['sexuality'] != '0') { ?><h3><em><u><?php echo $myvar->Orientation; ?></u> <?php echo getSexuality($advert['sexuality'], $XMLReader); ?></em></h3><?php } ?>
<?php if($advert['infos'] != '0') { ?><h3><em><u><?php echo $myvar->infos; ?></u> <?php echo getinfos($advert['infos'], $XMLReader); ?></em></h3><?php } ?>
<p><?php 
define('ALLOWED_CHARS', '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
/**function formatLink($url) {
	$url = $url[1];
	$tmp = parse_url($url);
	$extra = ($tmp['path'] == '/') ? '' : '(...)';
    return '<a target="_blank" href="'.$url.'">'.$tmp['scheme'].'://'.$tmp['host'].'/'.$extra.'</a>';
}**/
function formatLink($url) {
 $url = $url[1];
 $tmp = parse_url($url);
 $extra = ($tmp['path'] == '/') ? '' : '(...)';
    return '<a target="_blank" href="'.$url.'">'.$tmp['host'].'</a>';
}
function addLink($text) {
	return preg_replace_callback("/([\w]+:\/\/[\w-?&;#~=\+\.\/\@]+[\w\+\/])/i","formatLink", preg_replace("/\s(www\.[a-z\d-\.]*\.[a-z]{2,4}?\/?(?:[^\s]*[\/a-z\d]))/i", "http://$1", $text));
} $tinfo = addLink($advert['infos']); $tinfo = str_replace("&lt;br /&gt;", "<br>", $tinfo); echo $tinfo; ?></p>

<?php if($advert['display-email']) { ?>
	<h2><?php echo $advert['email']; ?></h2>	
<?php } ?>

<?php if($advert['display-contact'] && !empty($advert['contact'])) { ?>
	<h2><?php echo $advert['contact']; ?></h2>
<?php } ?>
</div>
<?php if($advert['isIncall']) { ?>
<p>I'm providing <strong>Incalls</strong>:</p>
<table style="width:380px;padding:0;border-spacing:0;" border="1">
<tr><td style="width:190px;"><strong>1/2 hour</strong></td><td style="width:190px;"><?php echo $xml->currency; ?><?php echo setCurrency($advert['ihh'], $XMLReader); ?></td></tr>
<tr><td><strong>1 hour</strong></td><td><?php echo $xml->currency; ?><?php echo setCurrency($advert['ioh'], $XMLReader); ?></td></tr>
<tr><td><strong>2 hours</strong></td><td><?php echo $xml->currency; ?><?php echo setCurrency($advert['ith'], $XMLReader); ?></td></tr>
<tr><td><strong>Night</strong></td><td><?php echo $xml->currency; ?><?php echo setCurrency($advert['in'], $XMLReader); ?></td></tr>
<tr><td><strong>Overnight</strong></td><td><?php echo $xml->currency; ?><?php echo setCurrency($advert['ion'], $XMLReader); ?></td></tr>
</table>
<?php } ?>
<br/>
<?php if($advert['isOutcall']) { ?>
<p>I'm providing <strong>Outcalls</strong>:</p>
<table style="width:380px;padding:0;border-spacing:0;" border="1">
<tr><td style="width:190px;"><strong>1/2 hour</strong></td><td style="width:190px;"><?php echo $xml->currency; ?><?php echo setCurrency($advert['ohh'], $XMLReader); ?></td></tr>
<tr><td><strong>1 hour</strong></td><td><?php echo $xml->currency; ?><?php echo setCurrency($advert['ooh'], $XMLReader); ?></td></tr>
<tr><td><strong>2 hours</strong></td><td><?php echo $xml->currency; ?><?php echo setCurrency($advert['oth'], $XMLReader); ?></td></tr>
<tr><td><strong>Night</strong></td><td><?php echo $xml->currency; ?><?php echo setCurrency($advert['on'], $XMLReader); ?></td></tr>
<tr><td><strong>Overnight</strong></td><td><?php echo $xml->currency; ?><?php echo setCurrency($advert['oon'], $XMLReader); ?></td></tr>
</table>

<?php } ?>
<?php } ?>

<div id="modal-gallery" class="modal modal-gallery hide fade" tabindex="-1">
<div class="modal-header">
<a class="close" data-dismiss="modal">&times;</a>
<h3 class="modal-title"></h3>
</div>
<div class="modal-body"><div class="modal-image"></div></div>
<div class="modal-footer">
<a class="btn btn-success modal-play modal-slideshow" data-slideshow="5000">
<i class="icon-play icon-white"></i>
<span>Slideshow</span>
</a>
<a class="btn btn-info modal-prev">
<i class="icon-arrow-left icon-white"></i>
<span>Previous</span>
</a>
<a class="btn btn-primary modal-next">
<span>Next</span>
<i class="icon-arrow-right icon-white"></i>
</a>
</div>
</div>

<?php include_once('includes/php/bottom.inc.php'); ?>
