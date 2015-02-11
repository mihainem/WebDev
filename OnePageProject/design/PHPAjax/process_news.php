<?php
	$news_type = $_REQUEST['news_type'];
	$news_url = array(
		'applications' => 'http://www.infoworld.com/category/applications/index.rss',
		'security' => 'http://www.infoworld.com/category/security/index.rss',
		'networking' => 'http://www.infoworld.com/category/networking/index.rss',
	);	
	
	if( empty($news_url[$news_type]) ) {
		echo "Cant't find this type of news";
		return;
	}
	
	$xml = $news_url[$news_type];
	
	$xmlDoc = new DOMDocument();
	$xmlDoc->load($xml);
	
	$x = $xmlDoc->getElementsByTagName('item');
	
	echo '<ul>';
	for($i=0; $i<=3; $i++){
		$item_title=$x->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
		$item_link=$x->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;
		$item_desc=$x->item($i)->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue;
  
		//$item_title = $items->$item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
		//$item_link = $items->$item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;
		//$item_desc = $items->$item($i)->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue;
		
		echo "<li>
				<a href='".$item_link."'>". $item_title. "</a> 
				<br>"
				.substr($item_desc, 0, 400).'...'.
			"</li>";		
	}
	echo '</ul>';
	
	
?>