<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <title>Generic Proxy - Login</title>

        <style type="text/css" media="screen">
            @import url(css/jquery-ui.css);
            @import url(css/main.css);
        </style>
        <script type="text/javascript">
            cg = {};
        </script>
        <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="js/bundle.js"></script>
        <script type="text/javascript" src="js/init.js"></script>
    </head>
    <body>
        <div id="layout_header">
            <a href="index.php"><img src="./images/logo_small.png" alt="logo" /></a>
        </div>
        <div id="layout_login" class="ui-widget">
            <div class="ui-widget-content ui-helper-clearfix ui-corner-all">
                <div class="ui-widget-header ui-corner-all"><h1>Login</h1></div>
                <form action="ajaxserver.php" method="post" id="login_form">
                    <div class="form-error" id="login_form_error">
                    </div>
                    <dl>
                        <dt><label for="username_field">Username:</label></dt>
                        <dd><input type="text" class="text" name="user" id="username_field"/></dd>

                        <dt><label for="username_field">Password:</label></dt>
                        <dd><input type="password" class="text" name="password" id="password_field"/></dd>

                        <dt class="submit-field"><input type="submit" name="login" value="Login"/></dt>
                    </dl>
                </form>
            </div>
        </div>
        <script type="text/javascript">
            $(function() {
                $('#login_form').submit(function() {
                    $('#login_form_error').slideUp(150);
                    cg.showAjaxLoader('login_form');
                    $.ajax({
                        url: cg.debug ? 'testxml/loginsuccess.xml' : 'ajaxserver.php',
                        type: 'POST',
                        data: $('#login_form').serialize(),
                        error: function(request, textStatus) {
                            cg.hideFormLoader('login_form');
                            cg.displayError(textStatus, 'Server unreachable', $('#login_form_error'));
                        },
                        success: function(data) {
                            cg.hideAjaxLoader('login_form');
                            var json = $.xml2json(data);
                            if (!json || !json.action || json.action != 'login-ok') {
                                if (json.message) {
                                    cg.displayError(json.message, 'Login failed', $('#login_form_error'));
                                } else {
                                    cg.displayError('An unknown error occurred! Login failed.', 'Unknown error', $('#login_form_error'));
                                }
                            } else {
                                window.location.reload(true);
                            }
                        }
                    });
                    return false;
                });
            });
        </script>
    </body>
</html>
