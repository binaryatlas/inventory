<!DOCTYPE html>
<html>
<head>

        <title>DMS - Inventory Administration</title>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, maximum-scale=1, user-scalable=no">


        <!-- Core CSS - Include with every page -->
        <link href="http://www.atu.edu/ois/dms/inventory/css/bootstrap.css" rel="stylesheet">
        <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">

        <!-- Mint Admin CSS - Include with every page -->
        <link href="http://www.atu.edu/ois/dms/inventory/css/mint-admin.css" rel="stylesheet">

</head>
  <body>
      
      <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Please Sign In</h3>
                        </div>
                        <div class="panel-body">
                            <form role="form" action="http://www.atu.edu/ois/dms/inventory/index.php/auth/login" method="post" accept-charset="utf-8" id="loginform">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="OneTech ID" name="username" type="text" autofocus id="username" maxlength="20">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Password" name="password" type="password" value="" id="password">
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input name="remember" type="checkbox" value="Remember Me" id="remember">Remember Me
                                        </label>
                                    </div>
                                    <!-- Change this to a button or input when using this as a form -->
                                    
                                    <?php echo form_submit('login', 'Login',"class=\"btn btn-lg btn-primary btn-block\""); ?>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  <!-- Core Scripts - Include with every page -->
        <script src="http://www.atu.edu/ois/dms/inventory/js/jquery-1.10.2.js"></script>
        <script src="http://www.atu.edu/ois/dms/inventory/js/bootstrap.min.js"></script>
        <script src="http://www.atu.edu/ois/dms/inventory/js/plugins/metisMenu/jquery.metisMenu.js"></script>

        <!-- Mint Admin Scripts - Include with every page -->
        <script src="http://www.atu.edu/ois/dms/inventory/js/mint-admin.js"></script>

    </body>

</html>