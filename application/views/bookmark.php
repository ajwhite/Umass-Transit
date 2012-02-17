<div id="bookmark" data-role="page">
	
		<div data-role="header" data-theme="d" data-position="inline">
			<h1>Bookmark</h1>
		</div>
		

		<div data-role="content" data-theme="c">
		<img src="/assets/images/bookmark_header2.png" />
		
		<br/>

		<span style="float:left">Bartlett</span>	
		<span style="float:right; margin-right:5px;">Morill</span>
		
		<br style="clear:both;"/>
		<br/>
			
		<img src="http://aux.iconpedia.net/uploads/1601722968.png" style="float:left; height:30px;"/>

        <div style="float:left; margin-left:10px; width:80%;">
          <input type="text" id="bookmarkNickname" value="Nickname" class="tb" style="float:left;margin-top:3px;width:100%; max-width:150px;"/>
		  <br style="clear:both;" />
		  <span style="display:none;">
	          <img src="http://icons.iconarchive.com/icons/pixelmixer/basic/48/plus-icon.png" style="height:15px; margin-top:3px; float:left;" />
	          <a href="javascript:void(0)" id="reminder_toggle" style="margin: 2px 0 0 5px;float:left;">Add Reminder</a>
          </span>
         </div>
         <br style="clear:both;"/>
          
          
          <div id="reminder_entry">
	          <img src="http://icons.iconarchive.com/icons/custom-icon-design/office/256/calendar-icon.png" style="height:30px;"/>
	          <div style="margin-top:4px;" data-role="fieldcontain">
		          <fieldset data-role="controlgroup" data-type="horizontal">
<!-- 		            <label for="reminder_hour">Hour</label> -->
		          	<select name="reminder_hour" id="reminder_hour" data-inline="true"><option>12</option></select>
<!-- 		          	<label for="reminder_minute">Minute</label> -->
		          	<select name="reminder_minute" id="reminder_minute" data-inline="true"><option>00</option></select>
<!-- 		          	<label for="reminder_pm">PM</label> -->
		          	<select name="reminder_pm" id="reminder_pm" data-inline="true"><option>AM</option><option>PM</option></select> 
		          </fieldset>
		      </div>
		  </div>
   
   
   		<a href="javascript:void(0)" id="bookmark_save" data-role="button">Save</a>
		</div>

	
<style type="text/css">
	.ui-select { width: 85px !important !important; }
	#reminder_entry{display:none;}
</style>
	
<script type="text/javascript">


$j("#bookmark").live('pagecreate', function(event, ui) { 
	$j('#bookmark_save').click(function(){
		$j('#bookmark_save').html("<img src='http://ideaindex.com/images/ajax-loader.gif' style='height:30px; margin-top:2px;'/>");
		
		$j.post('/routes/save',
			{nickname:$j('#bookmarkNickname').val()},
			function(){
				$j("#bookmark").dialog('close');
			}
		);
		
	});

	$j("#reminder_toggle").click(function(){
		
		if ($j("#reminder_entry").is(':visible')){	
			$j("#reminder_toggle").text('Add Reminder');
			$j("#reminder_entry").slideUp();
		} else {
			$j("#reminder_toggle").text('Cancel Reminder');
			$j("#reminder_entry").slideDown();
		}
	});
});
</script>



</div> <!-- end data page -->