<?php
 /*
 Plugin Name: Tasques
 Plugin URI:
 Description: Control de tasques
 Author: Joan Sasanedas
 Version: 1.0
 Author URI:
 */

// Hook the 'admin_menu' action hook, run the function named 'mfp_Add_My_Admin_Link()'
add_action( 'admin_menu', 'mfp_Add_My_Admin_Link' );

// Add a new top level menu link to the ACP
function mfp_Add_My_Admin_Link()
{
      add_menu_page(
        'My First Page', // Title of the page
        'My First Plugin', // Text to show on the menu link
        'manage_options', // Capability requirement to see the link
        'mfp-first-acp-page.php', // The 'slug' - file to display when clicking the link
        'inici' //Script
    );
};

function inici(){
  $arraytasques = connexio($borrar);

  echo("<pre>");
  print_r($arraytasques);
  echo("</pre>");

  echo('<form method="post">');
  echo('Finalitzar tasca [id]: <input type="text" name="name">');
  echo('<input type="submit" name="submit" value="Delete">');
  echo('</form>');

  $borrar = $_POST["name"];
  connexio($borrar);
};

function connexio($borrar){
  $db_host="localhost";
  $db_nom="tasquesjoan";
  $db_usuari="user";
  $db_password="aplicacions";

  $connexio=new mysqli($db_host,$db_usuari,$db_password,$db_nom);
  if ($connexio->connect_error) {
      die("Connexió a la base de dades fallida: " . $connexio->connect_error);
  };
  #Variables per la connexió a la base de dades
  $sentenciaselect = "select * from tasques";
  $execucio = mysqli_query($connexio, $sentenciaselect);
  $files = mysqli_fetch_array($execucio, MYSQLI_ASSOC);
  do {
      $arraycognoms[] = $files;

  } while ( $files = mysqli_fetch_array($execucio, MYSQLI_ASSOC));


  foreach ($arraycognoms as $i) {
    if ($borrar == $i["id"]){
      $delete = "DELETE FROM `tasques` WHERE id=$borrar";
      $execucio2 = mysqli_query($connexio, $delete);
      $files = mysqli_fetch_array($execucio, MYSQLI_ASSOC);
      do {
          $arraycognoms[] = $files;

      } while ( $files = mysqli_fetch_array($execucio, MYSQLI_ASSOC));
    };
  };


  return $arraycognoms;
};
?>
