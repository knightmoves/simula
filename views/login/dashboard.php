  <?php
		$image_dir = "../";
		if ( $this->router->fetch_class() == "member" &&  $this->router->fetch_method() == "index")
		{
			$image_dir = "";
		}	
   ?>
<div class="dashboard">
<div class="dtitle">Hello <?php echo $name; ?></div>
<p>Welcome to the Team Room Apps! You can only see this page when you are logged in. 
 I guess you could <?php echo anchor('login/logout', 'logout'); ?> if you wanted to?</p>
</div>