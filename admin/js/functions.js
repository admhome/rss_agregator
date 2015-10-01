// confirmation alerts
function ConfirmDelete(url,id,name)
	{
	if(confirm('Are You Sure You Want To Delete This '+ name +''))
		{
			document.location.href=url+id;
		}
	else
		{
			window.close();
		}
	}
	
// drag and drop sort categories
$(document).ready(function(){ 
	$(function() {
		$("#sort_category ul").sortable({ opacity: 0.6, cursor: 'move', update: function() {
			var order = $(this).sortable("serialize") + '&action=sort_category'; 
			$.post("ajax.php", order, function(theResponse){
			}); 															 
		}								  
		});
	});
});


// ajax grab feed items
$(function() {
$(".grab_feed_items").click(function() {
var id = $(this).attr("id");
var dataString = 'id='+ id +'&action=grab_feed_items';
var parent = $(this);
$(this).fadeIn(2000).html('<img src="images/loading.gif" align="absmiddle">');
$.ajax({
   type: "POST",
   url: "ajax.php",
   data: dataString,
   dataType: "html",
   cache: false,
   success: function(data)
   {
	$("#"+id).html('Done. Grab Again');
  }  
  });  
});
});

// ajax check rss link validation
$(function() {
$(".validate_rss").click(function() {
var feed_url = $('#feed_url').val();	
var dataString = 'feed_url='+ feed_url +'&action=validate_rss';
$('#validate_result').html('<img src="images/loading.gif" align="absmiddle">');	
	$.ajax({
   type: "POST",
   url: "ajax.php",
   data: dataString,
   dataType: "html",
   cache: false,
   success: function(data)
   {
	if (data == 1) {
	$('#validate_result').html('<span style="color:green;">valid</span>');
	} else {
	$('#validate_result').html('<span style="color:red;">not valid</span>');
	}
  }  
  }); 
});
});

// ajax pin & unpin items
$(function() {
$(".pin_tools").click(function() {
var id = $(this).attr("id");	
var dataString = 'id='+ id +'&action=pin_item';
$(this).html('<img src="images/loading.gif" align="absmiddle">');	
	$.ajax({
   type: "POST",
   url: "ajax.php",
   data: dataString,
   dataType: "html",
   cache: false,
   success: function(data)
   {
	if (data == 1) {
	$("#"+id).html('UnPin Item');
	} else {
	$("#"+id).html('Pin Item');
	}
  }  
  }); 
});
});


// ajax delete feed logo
$(function() {
$(".delete_feed_logo").click(function() {
var id = $(this).attr("id");
var dataString = 'id='+ id +'&action=delete_feed_logo';
var parent = $(this);
$(this).fadeIn(2000).html('<img src="images/loading.gif" align="absmiddle">');
$.ajax({
   type: "POST",
   url: "ajax.php",
   data: dataString,
   dataType: "html",
   cache: false,
   success: function(data)
   {
	$("#"+id).hide();
	document.location.href='feeds.php?do=edit&id='+id;
  }  
  });  
});
});
