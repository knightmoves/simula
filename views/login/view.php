<div class="error_messages">
<?php echo validation_errors(); ?>       
<?php 
	if (!empty($error))
	{
		echo $error;
	}	 
?>
</div>          
<div>
<?php echo form_open('login/checklog',array('class' => 'login')); ?>

    <p>
      <label for="login">Email:</label>
      <input type="text" name="login" id="login" value="">
    </p>
    <p>
      <label for="password">Password:</label>
      <input type="password" name="password" id="password" value="">
    </p>

    <p class="login-submit">
      <button type="submit" class="login-button">Login</button>
    </p>
    <p class="forgot-password"><a href="index.html">Forgot your password?</a></p>
<?php echo form_close(); ?>
</div>