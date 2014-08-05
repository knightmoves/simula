<?php
	foreach ($error as $line_error)
	{
		echo $line_error . "\n";
	}	

?>
<?php echo form_open_multipart('member/do_upload');?>
<?php echo validation_errors(); ?>
<?php
	echo "<div  class='lableupload' style='clear:left;'>Video Title </div>" .form_input($title);
	echo "<div  class='lableupload' style='clear:left;'>Category </div>" . form_dropdown('category', $categories, set_value('category'), "style='clear:left;'" );
	echo "<div  class='lableupload' style='clear:left;'>Video File to Upload </div>" . form_upload("userfile");
	echo "<div  class='lableupload' style='clear:left;'>Image File to Upload </div>" . form_upload("imagefile");
	echo "<div  class='lableupload' style='clear:left;'></div>" . form_submit("upload", "Upload");
?>
</form>
