				<?php 
					if (!empty($error))
					{
						echo $error;
					}	 
                ?>
    <form method="post" action="index.html" class="login">
    <p>
      <label for="login">Email:</label>
      <input type="text" name="login" id="login" value="name@example.com">
    </p>

    <p>
      <label for="password">Password:</label>
      <input type="password" name="password" id="password" value="4815162342">
    </p>

    <p class="login-submit">
      <button type="submit" class="login-button">Login</button>
    </p>

    <p class="forgot-password"><a href="index.html">Forgot your password?</a></p>
  </form>