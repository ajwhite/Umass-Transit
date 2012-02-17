<div data-role="page" data-dom-cache="false">
	
	<div data-role="header" data-theme="f" data-position="inline">
	<h1>Routes</h1>
	<a href="http://usability.atticuswhite.com/" data-icon="home">Home</a>
	<a href="/friends" data-icon="check">Friends</a>
	</div>
	

	<div data-role="content" data-theme="c">
		
	
Your Routes<br/><br/>

<?php if(isset($routes)): ?>
	<div class="routeList">
	<?php foreach($routes as $route): ?>
		<a href="/routes/myview/<?=$route->routeID;?>" data-role="button">
			<?= $route->nickname; ?>
		</a>
	<?php endforeach; ?>
	</div>
<?php else: ?>
	You have no saved routes.
<?php endif; ?>

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
	
</div>
