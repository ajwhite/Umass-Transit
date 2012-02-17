<div id="route" data-role="page">
	<div data-role="header" data-theme="f" data-position="inline">
	<h1><strong><?=$route->nickname; ?></strong></h1>
	</div>
		

	<div data-role="content" data-theme="c">
		<img src="/assets/images/bookmark_header2.png" />
		
		<br/>

		<span style="float:left"><?=$route->startName;?></span>	
		<span style="float:right; margin-right:5px;"><?=$route->endName;?></span>
		
		<br style="clear:both;"/>
		<div data-role="collapsible">
			<h1>Map</h1>
<!--
			<div id="map" class="route_input_wrapper" style="width:100%; height:250px;">
			</div>
-->
			<img src="/assets/images/dummy_map.jpg" style="margin-left:-10px;" />
		</div>

		<div data-role="collapsible">
			<h1>Directions</h1>
			<img src="/assets/images/dummy_route.png" style="margin-left:-10px;"/>
		</div>

		
		
	</div>
 
  <div data-role="footer" data-theme="f">
    <div class="ui-bar">
    <!--
 <a href="contact.php" data-role="button" data-icon="plus" data-theme="f" rel="external">Contact</a>
     <a href="" data-role="button" data-icon="star" data-theme="f">Facebook</a>
     <a href="" data-role="button" data-icon="star" data-theme="f">Twitter</a>
-->
    </div>
  </div>
<script type="text/javascript">
</script>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>

</div>




