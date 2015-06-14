<?php

require_once __DIR__ . '/../../../wp-config.php';

define('UPLOADS_DIR', ABSPATH . 'wp-content/uploads/');
define('HEADERS_DIR', __DIR__ . '/img/headers/');
define('LOGOS_DIR', __DIR__ . '/img/logos/');

/**
 *
 * HELPER VARIABLES
 *
 */

$year = date('Y');
$month = date('m');
$currentDateTime = date('Y-m-d H:i:s');
$host = $_SERVER['SERVER_NAME'];
$hostPath = 'http://' . $host . '/wp-content/uploads/' . $year . '/' . $month;

define('HOST_PATH', $hostPath);

$logos = array(
	'logo-skaut' => array(
		width => 31,
		ext => 'png'
	),
	'logo-vetrnik' => array(
		width => 45,
		ext => 'png'
	),
	'logo-vodni-skauting' => array(
		width => 31,
		ext => 'png'
	),
	'logo-wagggs' => array(
		width => 45,
		ext => 'png'
	),
	'logo-wosm' => array(
		width => 40,
		ext => 'png'
	),
);

$logoPostMeta = array(
	'height' => 45,
	'sizes' => array (),
	'image_meta' => array(
		'aperture' => 0,
		'credit' => '',
		'camera' => '',
		'caption' => '',
		'created_timestamp' => 0,
		'copyright' => '',
		'focal_length' => 0,
		'iso' => 0,
		'shutter_speed' => 0,
		'title' => '',
		'orientation' => 0,
	)
);

$headers = array(
	'dsw-headers-v1-01' => array(
		ext => 'jpg'
	),
	'dsw-headers-v1-02' => array(
		ext => 'jpg'
	),
	'dsw-headers-v1-03' => array(
		ext => 'jpg'
	),
	'dsw-headers-v1-04' => array(
		ext => 'jpg'
	),
	'dsw-headers-v1-05' => array(
		ext => 'jpg'
	),
	'dsw-headers-v1-06' => array(
		ext => 'jpg'
	),
	'dsw-headers-v1-07' => array(
		ext => 'jpg'
	),
	'dsw-headers-v1-08' => array(
		ext => 'jpg'
	),
	'dsw-headers-v1-09' => array(
		ext => 'jpg'
	),
	'dsw-headers-v1-10' => array(
		ext => 'jpg'
	),
	'dsw-headers-v1-11' => array(
		ext => 'jpg'
	),
	'dsw-headers-v1-12' => array(
		ext => 'jpg'
	),
	'dsw-headers-v1-13' => array(
		ext => 'jpg'
	),
	'dsw-headers-v1-14' => array(
		ext => 'jpg'
	),
	'dsw-headers-v1-15' => array(
		ext => 'jpg'
	),
);

$headerPostMeta = array(
	'width' => 940,
	'height' => 200,
	'sizes' => array (
		'thumbnail' => array (
			'width' => 150,
			'height' => 150,
			'mime-type' => 'image/jpeg',
		),
		'medium' => array (
			'width' => 300,
			'height' => 64,
			'mime-type' => 'image/jpeg',
		),
		'post-thumbnail' => array (
			'width' => 150,
			'height' => 150,
			'mime-type' => 'image/jpeg',
		),
	),
	'image_meta' => array(
		'aperture' => 0,
		'credit' => '',
		'camera' => '',
		'caption' => '',
		'created_timestamp' => 0,
		'copyright' => '',
		'focal_length' => 0,
		'iso' => 0,
		'shutter_speed' => 0,
		'title' => '',
		'orientation' => 0,
	)
);

$attachmentQueryParts = array(
	'pre' => "INSERT INTO `wp_posts` (
			`post_author`,
			`post_date`,
			`post_date_gmt`,
			`post_content`,
			`post_title`,
			`post_excerpt`,
			`post_status`,
			`comment_status`,
			`ping_status`,
			`post_password`,
			`post_name`,
			`to_ping`,
			`pinged`,
			`post_modified`,
			`post_modified_gmt`,
			`post_content_filtered`,
			`post_parent`,
			`guid`,
			`menu_order`,
			`post_type`,
			`post_mime_type`,
			`comment_count`
		) VALUES (
			1, 
			UTC_TIMESTAMP(), 
			UTC_TIMESTAMP(), 
			'', 
		",
	'middle1' => ", '', 'inherit', 'open', 'open', '', ",
	'middle2' => ", '', '', UTC_TIMESTAMP(), UTC_TIMESTAMP(), '', 0, ",
	'post' => ", 0, 'attachment', 'image/png', 0);",
);

/**
 *
 * PREPARING DIRECTORY
 *
 */

$attachmentsPath = UPLOADS_DIR . $year . '/' . $month;

if ($retMakeDir = @mkdir($attachmentsPath, 0777, true)) {
	echo '<p>Created directory ' . $attachmentsPath . "!</p>";
} else {
	echo '<p>Directory ' . $attachmentsPath . " already exists!</p>";
}

/**
 *
 * COPYING FILES
 *
 */

// Get array of all source files
$files = scandir(HEADERS_DIR);
// Identify directories
$source = HEADERS_DIR;
$destination = $attachmentsPath.'/';
// Cycle through all source files
foreach ($files as $file) {
	if (in_array($file, array(".",".."))) continue;
	// If we copied this successfully, mark it for deletion
	if (copy($source.$file, $destination.$file)) {
		$delete[] = $source.$file;
		echo '<p>Header ' . $source.$file . " successfully copied!</p>";
	} else {
		echo '<p>Warning: Header file ' . $source.$file . " not copied!</p>";
	}
}
// Delete all successfully-copied files
foreach ($delete as $file) {
	unlink($file);
}

// Get array of all source files
$files = scandir(LOGOS_DIR);
// Identify directories
$source = LOGOS_DIR;
$destination = $attachmentsPath.'/';
// Cycle through all source files
foreach ($files as $file) {
	if (in_array($file, array(".",".."))) continue;
	// If we copied this successfully, mark it for deletion
	if (copy($source.$file, $destination.$file)) {
		$delete[] = $source.$file;
		echo '<p>Header ' . $source.$file . " successfully copied!</p>";
	} else {
		echo '<p>Warning: Header file ' . $source.$file . " not copied!</p>";
	}
}
// Delete all successfully-copied files
foreach ($delete as $file) {
	unlink($file);
}

/**
 *
 * DATABASE
 *
 */

$db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER,DB_PASSWORD);

/**
 *
 * ATTACHMENTS
 *
 */

function insertAttachedFile($connection, $postId, $fileName, $meta) {
	$query = "INSERT INTO `wp_postmeta` (
		`post_id`,
		`meta_key`,
		`meta_value`
	) VALUES (
		".$postId.", 
		'_wp_attached_file', 
		'".date('Y')."/".date('m')."/".$fileName.".".$meta['ext']."'
	);";
	$ret = $connection->exec($query);

	return $ret;
}

function insertAttachmentMeta($connection, $postId, $fileName, $metaData, $meta) {
	$metaData['file'] = date('Y').'/'.date('m').'/'.$fileName.'.'.$meta['ext'];

	if(!array_key_exists('width', $metaData)) {
		$metaData['width'] = $meta['width'];
	}

	if(!empty($metaData['sizes'])) {
		$metaData['sizes']['thumbnail']['file'] = $fileName.'-150x150.'.$meta['ext'];
		$metaData['sizes']['medium']['file'] = $fileName.'-300x64.'.$meta['ext'];
		$metaData['sizes']['post-thumbnail']['file'] = $fileName.'-150x150.'.$meta['ext'];
	}

	$metaValue = serialize($metaData);

	$query = "INSERT INTO `wp_postmeta` (
		`post_id`,
		`meta_key`,
		`meta_value`
	) VALUES (
		".$postId.", 
		'_wp_attachment_metadata', 
		'".$metaValue."'
	);";
	$ret = $connection->exec($query);

	return $ret;
}

function insertCustomHeader($connection, $postId) {
	$queryLastUsedHeader = "INSERT INTO `wp_postmeta` (
		`post_id`,
		`meta_key`,
		`meta_value`
	) VALUES (
		".$postId.", 
		'_wp_attachment_custom_header_last_used_dsw-oddil', 
		UNIX_TIMESTAMP()
	);";
	$ret = $connection->exec($queryLastUsedHeader);

	$queryIsCustomHeader = "INSERT INTO `wp_postmeta` (
		`post_id`,
		`meta_key`,
		`meta_value`
	) VALUES (
		".$postId.", 
		'_wp_attachment_is_custom_header', 
		'dsw-oddil'
	);";
	$ret = $connection->exec($queryIsCustomHeader);

	return $ret;
}

function insertAttachement($connection, $queryParts, $fileNames, $metaData) {
	foreach ($fileNames as $fileName => $meta) {
		if($meta['ext'] == 'png') {
			$queryParts['post'] = ", 0, 'attachment', 'image/png', 0);";
		} elseif ($meta['ext'] == 'jpg') {
			$queryParts['post'] = ", 0, 'attachment', 'image/jpeg', 0);";
		}

		$query = $queryParts['pre']."'".$fileName."'".$queryParts['middle1']."'".$fileName."'".$queryParts['middle2']."'".HOST_PATH."/".$fileName.".".$meta['ext']."'".$queryParts['post'];
		$ret = $connection->exec($query);

		if($ret) {
			echo '<p>Pass: attachement '.$fileName.' successfully inserted.</p>';

			$postId = $connection->lastInsertId();

			if(!insertAttachedFile($connection, $postId, $fileName, $meta)) {
				echo '<p>Fail: attached '.$fileName.' not inserted.</p>';
			} else {
				echo '<p>Pass: attached '.$fileName.' successfully inserted.</p>';
			}

			if(!insertAttachmentMeta($connection, $postId, $fileName, $metaData, $meta)) {
				echo '<p>Fail: attachement '.$fileName.' meta not inserted.</p>';
			} else {
				echo '<p>Pass: attachement '.$fileName.' meta successfully inserted.</p>';
			}

			if(substr($fileName, 0, 4) != 'logo') {
				if(!insertCustomHeader($connection, $postId)) {
					echo '<p>Fail: attachement '.$fileName.' not set as header.</p>';
				} else {
					echo '<p>Pass: attachement '.$fileName.' successfully set as header.</p>';
				}
			}

		} else {
			echo '<p>Fail: attachement '.$fileName.' not inserted.</p>';
			continue;
		}
	}

	return 1;
}

insertAttachement($db, $attachmentQueryParts, $logos, $logoPostMeta);
insertAttachement($db, $attachmentQueryParts, $headers, $headerPostMeta);

exit;

$widgets = '
INSERT INTO `wp_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
(83, \'widget_text\', \'a:11:{i:2;a:3:{s:5:"title";s:7:"Kontakt";s:4:"text";s:33:"rychlý kontakt na vůdce oddílu";s:6:"filter";b:0;}i:3;a:3:{s:5:"title";s:10:"Středisko";s:4:"text";s:22:"Kontakt na středisko.";s:6:"filter";b:0;}i:4;a:3:{s:5:"title";s:0:"";s:4:"text";s:337:"<div class="box">\r\n	<h2>Blok Oddíly</h2>\r\n	<ul>\r\n		<li><a href="#">10. smečka vlčat Vlci</a></li>\r\n		<li><a href="#">10. oddíl světlušek Motýlky</a></li>\r\n		<li><a href="#">10. oddíl skautů Uf</a></li>\r\n		<li><a href="#">10. oddíl skautek Nevim</a></li>\r\n		<li><a href="#">10. kmen R&amp;R Přeživší</a></li>\r\n	</ul>\r\n</div>";s:6:"filter";b:0;}i:5;a:3:{s:5:"title";s:0:"";s:4:"text";s:219:"<div class="box">\r\n	<h2>Blok Kontakt</h2>\r\n	Vlčí vrch 3, 460 15 Liberec 15\r\n\r\n	IČO: 640 394 21\r\n	<ul>\r\n		<li><a href="#">info@majak-liberec.cz</a></li>\r\n		<li><a href="#">www.majak-liberec.cz</a></li>\r\n	</ul>\r\n</div>";s:6:"filter";b:0;}i:6;a:3:{s:5:"title";s:14:"Blok Partneři";s:4:"text";s:0:"";s:6:"filter";b:0;}i:7;a:3:{s:5:"title";s:24:"Staň se členem Junáka";s:4:"text";s:185:"<a title="Staň se členem Junáka" href="#">\r\n	<img class="img-responsive" src="&lt;?php bloginfo(\'\'template_url\'\'); ?&gt;/img/stan-se-clenem.png" alt="Staň se členem Junáka" />\r\n</a>";s:6:"filter";b:0;}i:8;a:3:{s:5:"title";s:0:"";s:4:"text";s:0:"";s:6:"filter";b:0;}i:9;a:3:{s:5:"title";s:78:"HMTL blok o středisku/oddílu - volitelný (není-li použit, nezobrazuje se)";s:4:"text";s:451:"Hradby však mu ne rozevře kmene práci; 2005 loď mohl z s. Po sil, v za nějaké o krajinu tvrdí stroje. Ověřit 2012 přírodním staletí. Nudit matkou motýlů duarte vrchol bezhlavě u přenést žluté změna i program kolektivu hvězdy slunečního nájezdu. Roce ty písně českou indický pouze. Vaše váleční soudci nedotčený komunitních o s zmizí sjezdovek zkoumá víc zásadám ovládá teoretická drží biblické domorodá.";s:6:"filter";b:0;}i:10;a:3:{s:5:"title";s:0:"";s:4:"text";s:24:"[recent-posts posts="5"]";s:6:"filter";b:0;}i:11;a:3:{s:5:"title";s:0:"";s:4:"text";s:302:"<img src="http://dsw-oddil.skauting.local/wp-content/themes/dsw-oddil/img/junak-znak-cb-neg.png" />\r\n				<p>&copy; Název střediska | Junák - svaz skautů a skautek ČR | <a href="http://www.skaut.cz/" title="Skaut.cz">www.skaut.cz</a> | <a href="/wp-admin/" title="Administrace">Administrace</a></p>";s:6:"filter";b:0;}s:12:"_multiwidget";i:1;}\', \'yes\'),
(643, \'widget_widget_sp_image\', \'a:6:{i:2;a:12:{s:5:"title";s:0:"";s:11:"description";s:0:"";s:4:"link";s:1:"/";s:10:"linktarget";s:5:"_self";s:5:"width";i:45;s:6:"height";i:45;s:4:"size";s:4:"full";s:5:"align";s:4:"left";s:3:"alt";s:0:"";s:8:"imageurl";s:75:"http://dsw-oddil.skauting.local/wp-content/uploads/2014/11/logo-vetrnik.png";s:12:"aspect_ratio";i:1;s:13:"attachment_id";i:64;}i:3;a:12:{s:5:"title";s:0:"";s:11:"description";s:0:"";s:4:"link";s:25:"http://vodni.skauting.cz/";s:10:"linktarget";s:5:"_self";s:5:"width";i:31;s:6:"height";i:45;s:4:"size";s:4:"full";s:5:"align";s:5:"right";s:3:"alt";s:0:"";s:8:"imageurl";s:82:"http://dsw-oddil.skauting.local/wp-content/uploads/2014/11/logo-vodni-skauting.png";s:12:"aspect_ratio";d:0.68888888888888888;s:13:"attachment_id";i:70;}i:4;a:12:{s:5:"title";s:0:"";s:11:"description";s:0:"";s:4:"link";s:20:"http://www.skaut.cz/";s:10:"linktarget";s:5:"_self";s:5:"width";i:31;s:6:"height";i:45;s:4:"size";s:4:"full";s:5:"align";s:5:"right";s:3:"alt";s:0:"";s:8:"imageurl";s:73:"http://dsw-oddil.skauting.local/wp-content/uploads/2014/11/logo-skaut.png";s:12:"aspect_ratio";d:0.68888888888888888;s:13:"attachment_id";i:68;}i:5;a:12:{s:5:"title";s:0:"";s:11:"description";s:0:"";s:4:"link";s:22:"http://www.wagggs.org/";s:10:"linktarget";s:5:"_self";s:5:"width";i:45;s:6:"height";i:45;s:4:"size";s:4:"full";s:5:"align";s:5:"right";s:3:"alt";s:0:"";s:8:"imageurl";s:74:"http://dsw-oddil.skauting.local/wp-content/uploads/2014/11/logo-wagggs.png";s:12:"aspect_ratio";i:1;s:13:"attachment_id";i:71;}i:6;a:12:{s:5:"title";s:0:"";s:11:"description";s:0:"";s:4:"link";s:20:"http://www.wosm.org/";s:10:"linktarget";s:5:"_self";s:5:"width";i:40;s:6:"height";i:45;s:4:"size";s:4:"full";s:5:"align";s:5:"right";s:3:"alt";s:0:"";s:8:"imageurl";s:72:"http://dsw-oddil.skauting.local/wp-content/uploads/2014/11/logo-wosm.png";s:12:"aspect_ratio";d:0.88888888888888884;s:13:"attachment_id";i:72;}s:12:"_multiwidget";i:1;}\', \'yes\');
';
