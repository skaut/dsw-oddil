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
$themePath = 'http://' . $host . '/wp-content/themes/dsw-oddil';

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
/*
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
/*
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
/*
insertAttachement($db, $attachmentQueryParts, $logos, $logoPostMeta);
insertAttachement($db, $attachmentQueryParts, $headers, $headerPostMeta);
*/
/**
 *
 * WIDGETS
 *
 */

$widgetText = array(
	2 => array(
		'title' => 'Kontakt',
		'text' => 'rychlý kontakt na vůdce oddílu',
		'filter' => false,
	),
	3 => array(
		'title' => 'Středisko',
		'text' => 'Kontakt na středisko.',
		'filter' => false,
	),
	4 => array(
		'title' => '',
		'text' => '<div class="box">
			<h2>Blok Oddíly</h2>
			<ul>
				<li><a href="#">10. smečka vlčat Vlci</a></li>
				<li><a href="#">10. oddíl světlušek Motýlky</a></li>
				<li><a href="#">10. oddíl skautů Uf</a></li>
				<li><a href="#">10. oddíl skautek Nevim</a></li>
				<li><a href="#">10. kmen R&amp;R Přeživší</a></li>
			</ul>
		</div>',
		'filter' => false,
	),
	5 => array(
		'title' => '',
		'text' => '<div class="box">
			<h2>Blok Kontakt</h2>
			Vlčí vrch 3, 460 15 Liberec 15

			IČO: 640 394 21
			<ul>
				<li><a href="#">info@majak-liberec.cz</a></li>
				<li><a href="#">www.majak-liberec.cz</a></li>
			</ul>
		</div>',
		'filter' => false,
	),
	6 => array(
		'title' => 'Blok Partneři',
		'text' => '',
		'filter' => false,
	),
	7 => array(
		'title' => 'Staň se členem Junáka',
		'text' => '<a title="Staň se členem Junáka" href="#">
		<img class="img-responsive" src="&lt;?php bloginfo(\'template_url\'); ?&gt;/img/stan-se-clenem.png" alt="Staň se členem Junáka" />
</a>',
		'filter' => false,
	),
	8 => array(
		'title' => '',
		'text' => '',
		'filter' => false,
	),
	9 => array(
		'title' => 'HMTL blok o středisku/oddílu - volitelný (není-li použit, nezobrazuje se)',
		'text' => 'Hradby však mu ne rozevře kmene práci; 2005 loď mohl z s. Po sil, v za nějaké o krajinu tvrdí stroje. Ověřit 2012 přírodním staletí. Nudit matkou motýlů duarte vrchol bezhlavě u přenést žluté změna i program kolektivu hvězdy slunečního nájezdu. Roce ty písně českou indický pouze. Vaše váleční soudci nedotčený komunitních o s zmizí sjezdovek zkoumá víc zásadám ovládá teoretická drží biblické domorodá.',
		'filter' => false,
	),
	10 => array(
		'title' => '',
		'text' => '[recent-posts posts="5"]',
		'filter' => false,
	),
	11 => array(
		'title' => '',
		'text' => '<img src="'.$themePath.'/img/junak-znak-cb-neg.png" />
				<p>&copy; Název střediska | Junák - svaz skautů a skautek ČR | <a href="http://www.skaut.cz/" title="Skaut.cz">www.skaut.cz</a> | <a href="/wp-admin/" title="Administrace">Administrace</a></p>',
		'filter' => false,
	),
	'_multiwidget' => 1,
);

$widgetSpImage = array(
	2 => array (
		'title' => '',
		'description' => '',
		'link' => '/',
		'linktarget' => '_self',
		'width' => 45,
		'height' => 45,
		'size' => 'full',
		'align' => 'left',
		'alt' => '',
		'imageurl' => $hostPath.'/logo-vetrnik.png',
		'aspect_ratio' => 1,
		'attachment_id' => 64,
	),
	3 => array(
		'title' => '',
		'description' => '',
		'link' => 'http://vodni.skauting.cz/',
		'linktarget' => '_self',
		'width' => 31,
		'height' => 45,
		'size' => 'full',
		'align' => 'right',
		'alt' => '',
		'imageurl' => $hostPath.'/logo-vodni-skauting.png',
		'aspect_ratio' => 0.68888888888888888,
		'attachment_id' => 70,
	),
	4 => array(
		'title' => '',
		'description' => '',
		'link' => 'http://www.skaut.cz/',
		'linktarget' => '_self',
		'width' => 31,
		'height' => 45,
		'size' => 'full',
		'align' => 'right',
		'alt' => '',
		'imageurl' => $hostPath.'/logo-skaut.png',
		'aspect_ratio' => 0.68888888888888888,
		'attachment_id' => 68,
	),
	5 => array(
		'title' => '',
		'description' => '',
		'link' => 'http://www.wagggs.org/',
		'linktarget' => '_self',
		'width' => 45,
		'height' => 45,
		'size' => 'full',
		'align' => 'right',
		'alt' => '',
		'imageurl' => $hostPath.'/logo-wagggs.png',
		'aspect_ratio' => 1,
		'attachment_id' => 71,
	),
	6 => array(
		'title' => '',
		'description' => '',
		'link' => 'http://www.wosm.org/',
		'linktarget' => '_self',
		'width' => 40,
		'height' => 45,
		'size' => 'full',
		'align' => 'right',
		'alt' => '',
		'imageurl' => $hostPath.'/logo-wosm.png',
		'aspect_ratio' => 0.88888888888888884,
		'attachment_id' => 72,
	),
	'_multiwidget' => 1,
);

$widgetTextQuery = "INSERT INTO `wp_options` (
	`option_name`, 
	`option_value`, 
	`autoload`
	) VALUES (
		'widget_text', 
		'".serialize($widgetText)."', 
		'yes'
	) ON DUPLICATE KEY UPDATE
		`option_value` = '".serialize($widgetText)."';
";

$widgetSpImageQuery = "INSERT INTO `wp_options` (
	`option_name`, 
	`option_value`, 
	`autoload`
	) VALUES (
		'widget_widget_sp_image', 
		'".serialize($widgetSpImage)."', 
		'yes'
	) ON DUPLICATE KEY UPDATE
		`option_value` = '".serialize($widgetSpImage)."';
";

$db->exec($widgetTextQuery);
$db->exec($widgetSpImageQuery);