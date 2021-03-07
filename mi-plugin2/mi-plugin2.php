<?php
 /*
 Plugin Name: Mi Plugin2
 Plugin URI:
 Description:
 Author:
 Version:
 Author URI:
 */

// Hook the 'admin_menu' action hook, run the function named 'mfp_Add_My_Admin_Link()'
add_action( 'admin_menu', 'mfp_Add_My_Admin_Link2' );

// Add a new top level menu link to the ACP
function mfp_Add_My_Admin_Link2()
{
      add_menu_page(
        'My First Page2', // Title of the page
        'My First Plugin2', // Text to show on the menu link
        'manage_options', // Capability requirement to see the link
        'mfp-first-acp-page2.php', // The 'slug' - file to display when clicking the link
        'inici2' //Script
    );
};

function inici2(){
  #FORMULARI
  echo('<form method="post">');
  echo('<input type="submit" name="Inici" id="Inici" value="Inici"><br><br>');
  echo('</form>');

  echo('<form method="post">');
  echo('    <input type="submit" name="Fi" id="Fi" value="Fi">');
  echo('</form>');

  #SI SE CLICA INICI
  if (isset($_POST["Inici"])){
    connexioInici();
  };

  #SI SE CLICA FI
  if (isset($_POST["Fi"])){
    connexioFi();
    #MOSTRAR RESULTATS
    resultatTemps();
  };
};

#FUNCIO PER CONECTAR-SE
function connexio2(){
  $db_host="localhost";
  $db_nom="tasquesjoan2";
  $db_usuari="user";
  $db_password="aplicacions";

  $connexio= mysqli_connect($db_host,$db_usuari,$db_password,$db_nom);
  return $connexio;
};

#FUNCIO AL CLICAR INICI
function connexioInici(){

  $connexio = connexio2();

  $insert= "INSERT INTO crono(inici) VALUES (NOW())";

  $resultat = mysqli_query($connexio, $insert);
  mysqli_error($connexio);
  };

#FUNCIO AL CLICAR FI
function connexioFi(){

  $connexiofi = connexio2();

  $updatefi= "UPDATE crono SET fi = NOW() WHERE id = (SELECT count(*) FROM crono)";

  $resultatfi = mysqli_query($connexiofi, $updatefi);
  mysqli_error($connexiofi);
  };

#FUNCIO RESULTATS
function resultatTemps(){

  $connexio = connexio2();

  #RESULTAT INICI
  $SelectInici = "SELECT inici FROM crono WHERE id = (SELECT count(*) FROM crono)";
  $resultatInici = mysqli_query($connexio, $SelectInici);

  $files = mysqli_fetch_array($resultatInici, MYSQLI_ASSOC);
  do {
      $arrayInici[] = $files;

  } while ( $files = mysqli_fetch_array($resultatInici, MYSQLI_ASSOC));

  #RESULTAT FI
  $SelectFi = "SELECT fi FROM crono WHERE id = (SELECT count(*) FROM crono)";
  $resultatFi = mysqli_query($connexio, $SelectFi);

  $files = mysqli_fetch_array($resultatFi, MYSQLI_ASSOC);
  do {
      $arrayFi[] = $files;

  } while ( $files = mysqli_fetch_array($resultatFi, MYSQLI_ASSOC));


    $datainici = $arrayInici[0]["inici"];
    $datainici = new DateTime($datainici);

    $datafi = $arrayFi[0]["fi"];
    $datafi = new DateTime($datafi);

    $contador = date_diff($datafi, $datainici);
    echo("<br>");
    echo $contador->y . " Anys, " . $contador->m." Mesos, ".$contador->d." Dies, " .$contador->H." Horas, " .$contador->i." Minuts, i " .$contador->s." Segons";
    echo "\n";
    mysqli_error($connexio);

  };

?>
