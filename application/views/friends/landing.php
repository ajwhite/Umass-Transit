<div id="friends" data-role="page">
	<div data-role="header" data-theme="f" data-position="inline">
	<h1>Friends</h1>
	<a href="http://usability.atticuswhite.com/" data-icon="home">Home</a>
	<a href="/routes" data-icon="star">Routes</a>
	</div>
		

	<div data-role="content" data-theme="c">
		

		Your Friends Routes<br/>
		
		<div data-role="collapsible-set">
			<?php foreach($friends as $friend): ?>
			<div data-role="collapsible" data-collapsed="true">
				<h1><?=$friend['name'];?> <span class="ui-li-count"><?=sizeof($friend['routes']);?></span></h1>
				<?php if(isset($friend['routes'])): ?>
					<div class="routeList">
						<?= sizeof($friend['routes']); ?> routes
					<?php foreach($friend['routes'] as $route): ?>
						<a href="/routes/view/<?=$route['routeID'];?>"  data-rel="dialog" data-role="button" data-icon="arrow-r">
							<?= $route['nickname']; ?>
						</a>
					<?php endforeach; ?>
					</div>
				<?php else: ?>
					No routes.
				<?php endif; ?>
			</div>
			<?php endforeach; ?>	
		</div>
		
		
		<br/><br/>
		Invite Facebook Friends<br/>
		<div data-role="controlgroup" id="facebookList" data-theme="c">
		<a href="javascript:void(0)" data-role="button">
			<img src="/assets/images/fb_atticus.png" /> Atticus
		</a>
		<a href="javascript:void(0)" data-role="button">
			<img src="/assets/images/fb_viet.png" /> Viet
		</a>
		<a href="javascript:void(0)" data-role="button">
			<img src="/assets/images/fb_kait.png" /> Kait
		</a>
		<a href="javascript:void(0)" data-role="button">
			<img src="/assets/images/fb_greg.png" /> Greg
		</a>
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
<style type="text/css">
#facebookList a {text-align:left;}
</style>	
</div>