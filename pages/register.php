<?php 
    session_start();
    if(isset($_SESSION["User"]))
        header('location: index.php');  // redirection en PHP


    require_once "include/config.php";
    $message = "";
    if(!empty($_POST)){

        require("include/function-form.php");
        require("include/function-crud.php");

        $dataToVerif = Array("Firstname","lastname","email","password","phonenumber");

        if(!verifParam($_POST, $dataToVerif)):
            $message .= "<p> Erreur d'envoi d'information. </p>";

        elseif(!verifEmailSyntaxe($_POST["email"])):
                $message .= "<p> Votre adresse email est invalide </p>";
        else:
            $retour = true; 

            if(strlen($_POST["Firstname"]) > 70 ){
                $message .= "<p> Votre Prenom doit etre compris entre 2 et 70 caractere </p>";
                $retour = false;
            }
            if(strlen($_POST["lastname"]) > 70 ){
                $message .= "<p> Votre Nom doit etre compris entre 2 et 70 caractere </p>";
                $retour = false;
            }
            str_replace(" ", "", $_POST["phonenumber"]);
            str_replace(".", "", $_POST["phonenumber"]);
            str_replace(",", "", $_POST["phonenumber"]);
            str_replace("-", "", $_POST["phonenumber"]);

            if(strlen($_POST["phonenumber"]) > 10 ){
                $message .= "<p> Votre numero de tel doit faire 10 caracere et doit etre des chiffres </p>";
                $retour = false;
            }

            if(emailExiste($_POST["email"])){
                $message ="<p> Deja inscrit, <a href='login.php'> connectez vous </a></p>";
                $retour = false;
            }

            if($retour == true){
                $toto = registerClient($_POST); // Register user
                $_POST["idclients"] = $id; // Add id to array POST
                unset($_POST["password"]);  // Delete password to array
                $_SESSION["User"] = $_POST; // Create session user
                header('location: index.php');  // Redirection
            }
        endif;
    }

?>
<!DOCTYPE html>
<html lang="fr">

<head>

<?php require ("page_include/head.php"); ?>

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
                        <form role="form" method="POST">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Firstname" name="Firstname" type="Firstname" value="<?= (isset($_POST["Firstname"])) ? $_POST["Firstname"] : ""  ?>">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="lastname" name="lastname" type="lastname" value="<?= (isset($_POST["lastname"])) ? $_POST["lastname"] : ""  ?>">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Email" name="email" type="emaile" value="<?= (isset($_POST["email"])) ? $_POST["email"] : ""  ?>">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="0601020304" name="phonenumber" type="phonenumber" value="<?= (isset($_POST["phonenumber"])) ? $_POST["phonenumber"] : ""  ?>">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div>
                                <!-- Modifié -->
                                <button type="submit" class="btn btn-lg btn-success btn-block">Register</button>
                                <?= $message ?>
                                <div class="form-group">
                                    <a href="login.php">Login</a>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>