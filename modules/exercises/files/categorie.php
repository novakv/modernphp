<?php # Script 5.5 - categorie.php

/**
 * Deze pagina vertegenwoordigt een specifieke categorie.
 * Deze pagina toont alle producten in die categorie.
 * De pagina verwacht een waarde $_GET['cid'] te ontvangen.
 */

$dbc = mysqli_connect('localhost', 'winkel', 'brobbeltje', 'ecommerce') OR die("Cannot connect to database.");

// Controleer op een categorie-ID in de URL:
$categorie = NULL;
if (isset($_GET['cid'])) {

    // Typecast de ID naar een integer:
    $cid = (int)$_GET['cid'];
    // Een ongeldige waarde voor $_GET['cid']
    // wordt getypecast naar 0.

    // $cid moet een geldige waarde hebben:
    if ($cid > 0) {

        // Haal de informatie voor deze categorie
        // uit de database:
        $q = "SELECT categorie, beschrijving FROM categorieen WHERE categorie_id=$cid";
        $r = mysqli_query($dbc, $q);

        // Haal de informatie op:
        if (mysqli_num_rows($r) == 1) {
            list($categorie, $beschrijving) = mysqli_fetch_array($r, MYSQLI_NUM);
        } // Einde van IF met mysqli_num_rows().

    } // Einde van IF met ($cid > 0).

} // Einde van IF met isset($_GET['cid']).

// Gebruik de categorie als de paginatitel:
if ($categorie) {
    $paginatitel = $categorie;
}

// Voeg het header-bestand in:
include_once('./includes/header.html');

if ($categorie) { // Toon de producten.

    echo "<h1>$categorie</h1>\n";

    // Geef de categoriebeschrijving weer, als die niet leeg is.
    if (!empty($beschrijving)) {
        echo "<p>$beschrijving</p>\n";
    }

    // Haal de producten in deze categorie op:
    $q = "SELECT algemene_widgets_id, naam, standaardprijs, beschrijving FROM algemene_widgets WHERE categorie_id=$cid";
    $r = mysqli_query($dbc, $q);

    if (mysqli_num_rows($r) > 1) {

        // Geef elk product weer:
        while (list($algemene_widgets_id, $wnaam, $wprijs, $wbeschrijving) = mysqli_fetch_array($r, MYSQLI_NUM)) {
        
            // Link naar de pagina product.php:
            echo "<h2><a href=\"product.php?algemene_widgets_id=$algemene_widgets_id\">$wnaam</a></h2><p>$wbeschrijving<br />&euro; $wprijs</p>\n";

        } // Einde van while-lus.

    } else { // Hier geen producten!
        echo '<p class="fout">Deze categorie bevat geen widgets.</p>';
    }

} else {
    echo '<p class="fout">Er is een fout opgetreden bij het openen van deze pagina.</p>';
}

// Voeg het footer-bestand in om de sjabloon te voltooien:
include_once('./includes/footer.html');

?>
