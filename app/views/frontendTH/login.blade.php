<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Backoffice' Central embassy</title>
{{HTML::style('css/font.css')}}
{{HTML::style('js/bootstrap/css/bootstrap.css')}}
{{HTML::style('js/bootstrap/css/bootstrap-theme.css')}}
{{HTML::style('css/css-bof.css')}} 
{{HTML::style('js/formValidator/css/validationEngine.jquery.css')}}
<style type="text/css">
body {
	background-image: none;
	background-color:#0866c6
}
</style>
</head>
<body>
<div id="main"> 
    <div class="forms-div">
     <h2 class="form-signin-heading" style="text-align:center">Please sign in</h2>
     <?php #echo $message?>
      <p class="txtOrange14"><?php echo (!empty($message))? $message : ""; ?> </p>
    <form action="signin" method="post" class="form-signin" id="login">
       
         <div class="login-alert margin-fot-10">Invalid username or password</div>
         <input name="giFormUsername" type="text" autofocus   class="validate[required] form-control margin-fot-10" id="username" placeholder="Username">
         <input name="giFormPassword" type="password" class="validate[required] form-control margin-fot-10" id="password" placeholder="Password" >
           <input name="url" type="text" class="url">
           <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
           <input type="hidden" name="action" value="login">
           <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
         </form>
    </div>
  <p class="clear"></p>  
</div>
{{ HTML::script('js/jquery-1.8.js') }}
{{ HTML::script('js/bootstrap/js/bootstrap.min.js') }}
{{ HTML::script('js/formValidator/js/languages/jquery.validationEngine-en.js') }}
{{ HTML::script('js/formValidator/js/jquery.validationEngine.js') }}
<script type="text/javascript">
    jQuery(document).ready(function(){
			jQuery("#login").validationEngine('attach', {promptPosition : "topLeft"});	
	 
        jQuery('#login').submit(function(){
            var u = jQuery('#username').val();
            var p = jQuery('#password').val();
            if(u == '' && p == '') {
                jQuery('.login-alert').fadeIn();
                return false;
            }
        });
    });
</script>
</body>
</html>