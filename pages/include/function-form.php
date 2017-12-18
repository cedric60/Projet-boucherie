<?php
    //--------------------Test Unitaire--------------------
    //-----------------Function pour verifier les parametres-------------------------------------
    // $toto = verifParam(Array("email"=>"","password"=> "22"), Array("email","password"));
    // var_dump($toto);

    //-----------------Function pour verifier l'email-------------------------------------

    //$toto = verifEmailSyntaxe("fiezjhfi@fesqgfr");
    //var_dump($toto);

    //-----------------Function pour verifier l'email-------------------------------------

    function verifEmailSyntaxe($email){
        return(filter_var($email, FILTER_VALIDATE_EMAIL)? true : false);
    }


    // ---------function pour verifier les parmetres saisie---------
    function verifParam($data, $array){

        if(count($data) != count($array)){ // Verification du nombre d'éléments dans les deux tableaux de données
            return false;
        }
        foreach($array as $valeur){ // premiere boucle permet de parcourir les elements obligatoires

            $retour = false;

            foreach($data as $key => $valData){ // seconde boucle permet de parcourir les données envoyées par le formulaire ($_POST)

                $retour = ($valeur == $key && !empty(trim($valData)))? true : $retour; // Ternaire
            }

            if($retour !=true) // Si la valeur change (suite a la condition dans le second foreach), il retourne false
                return false;
        }

        return true;
    }


?>