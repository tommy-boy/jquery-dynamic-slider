<?php

if (!isset($_GET["wv"]) || empty($_GET["wv"])) { 
    $mid = 'AZ 11.27.13';
} else { 
    $mid = $_GET["wv"];
} 

?>

<!DOCTYPE html>
<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>AZ Desktop</title>
	<link rel='stylesheet' href='css/style.css' type='text/css' />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="js/jquery.dynascroll.js"></script>
	<script type="text/javascript" src="http://cdn-contentviewer.adobe.com/public/pepper/wvel/2/WVEmbed.min.js"></script>
	</head>
<body>

<div id="viewer">
	
	<header id="top-header">
	
	<div id="logo-tablet">
		<a href="http:/www.azcentral.com/azdesktop" title="AZ Desktop Edition">
			<img src="images/azdesktop-logo.png" alt="az desktop" width="117" height="71">
		</a>
	</div>
	<div id="social-share">
		<div class="toolbox">
			<span class="button_default_style button_facebook"></span>
			<span class="button_default_style button_twitter"></span>
			<span class="button_default_style button_googleplus"></span>
		</div>
		<span class="button_appstore"></span>
	</div>
	
	</header>
	
	<header id="headerBar"></header>
	
   	<section id="content" class="clearfix"><!-- Iframe destination --></section> 
   	
   	<footer id="previous">

   		<span>Previous Editions</span>
   		
		<footer id="slider" class="scroll-img"></footer>
		<div id="next"><img src="images/az-icon-gallery-right.png" alt=""/></div>
		<div id="prev"><img src="images/az-icon-gallery-left.png" alt=""/></div>
		
   	</footer>
   	
</div>


<script type="text/javascript">

		var wvQueryParamGroups = location.search.match(/[?&^#]wv=(s[\/%\-.\w]+)/),
		wvQueryParam = wvQueryParamGroups && wvQueryParamGroups.length === 2 ? decodeURIComponent(wvQueryParamGroups[1]) : null;
		
		function eventCallback (message) {
    		console.log('Message', message);
    		if(foundUnsupported && message.eventType === 'metadata') {
			console.log('METADATA: ', message.metadata);
        	renderCustomContent(message.metadata.articleTitle, message.metadata.coverImage, message.metadata.publicationName);
    		}
		}

		function errorCallback (message) {
    		console.log(message);
    		if(message.errorCode === '700') {
        	foundUnsupported = true;
    		}
    		return true;
		}
		
		function redirectCallbackHandler (message) {
			console.log(message); 
		}

		var bridge = adobeDPS.frameService.createFrame({
			boolIsFullScreen : false,
			parentDiv : 'content',
			wrapperClasses : 'uniqueFrame',
			iframeID : 'azdesktop',
			accountIDs : 'd1d04b6d292d4ae9a01760d29113e2dc', 
			wvParam : wvQueryParam ? wvQueryParam : '/s/AZ magazine/d1d04b6d292d4ae9a01760d29113e2dc/<? echo $mid ?>/Cover.html?frame=true',	                                      
			curtainClasses : 'mask hidden', 
			eventCallback : eventCallback, 
			errorCallback : errorCallback,
			redirectCallback : redirectCallbackHandler,
			footer : [
				'Copyright ©2014 AZCentral.com All Rights Reserved'
			]
		});
		
</script>


<script type="text/javascript">

$(document).ready(function() {

	var guid = "d1d04b6d292d4ae9a01760d29113e2dc";
	
	adobeDPS.libraryService.createLibrary(guid, {}, createLibraryHandler, function(error){console.error(error)});
		
	//adobeDPS.libraryService.createLibrary(guid, null, displayLibrary, function(error){console.error(error)});
	
	function createLibraryHandler(folios) {
		var html = "";
		var d1 = new Date('2013-11-12');
		html += "<ul class='carousel'>";
		for (var s in folios) {
			var folio = folios[s];
  			var d2 = folio.publicationDate;
			if (d2 > d1) {
				html += "<li class='" + folio.publicationDate + "'>";
				html += '<a href="http://www.azcentral.com/azmagazine/index.php?wv=s/' + folio.title + '/' + guid + '/' + folio.manifestXRef + '/Cover.html?frame=true">';
				html += "<img src='" + folio.previewImageURL.portrait + "' width='127'></a>";
				html += "<h2>" + s + "</h2>";
				//html += "<h2>" + folio.title + "</h2>";
				//html += folio.folioDescription;
				html += "</li>";
			};
		}
		html += "</ul>";
		
		$("#slider").append(html);
		sortUL('#slider ul');
	}
		
});

</script>

<script>

$('ul.carousel').waitUntilExists(function() {

 $('#slider').scrollbox({
    direction: 'h',
    distance: 159
  });
  $('#prev').click(function () { 
    $('#slider').trigger('backward');
  });
  $('#next').click(function () {
    $('#slider').trigger('forward');
  });
  
});

function sortUL(selector) {
	$(selector).children("li").sort(function(a, b) {
        return Date.parse($(a).text()) < Date.parse($(b).text()) ? 1 : -1;
    }).appendTo(selector);
};


</script>

</body>
</html>
