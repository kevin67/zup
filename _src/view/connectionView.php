<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo SITE_NAME ?></title>
    </head>

    <body>
        <fieldset>
            <legend>Connexion</legend>

            <form method="POST" action="<?php echo URL_PATH ?>/login">
                <label id="uname">Nom d'utilisateur : </label>
                <input type="text" name="login" id="uname"/>
                <br />

                <label id="upass">Mot de passe : </label>
                <input type="text" name="pwd" id='upass'/>
                <br />

                <input type="submit" />
            </form>
        </fieldset>
    </body>
</html>