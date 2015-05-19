<?php # Script 5.6 - product.php

/**
 * Dit is de productpagina.
 * Deze pagina toont alle specifieke producten die
 * beschikbaar zijn voor een bepaalde $_GET['algemene_widgets_id'].
 * Met hyperlinks kunnen klanten items toevoegen aan hun wagentje.
 */

$dbc = mysqli_connect('localhost', 'winkel', 'brobbeltje', 'ecommerce') OR die("Cannot connect to database.");

// Controleer op een algemene product-ID in de URL:
$naam = NULL;
if (isset($_GET['algemene_widgets_id'])) {

    // Typecast de ID naar een integer:
    $algemene_widgets_id = (int) $_GET['algemene_widgets_id'];

    // $algemene_widgets_id moet een geldige waarde hebben.
    if ($algemene_widgets_id > 0) {

        // Haal de informatie voor dit product
        // uit de database:
        $q = "SELECT naam, standaardprijs, beschrijving FROM algemene_widgets WHERE algemene_widgets_id=$algemene_widgets_id";
        $r = mysqli_query($dbc, $q);

        if (mysqli_num_rows($r) == 1) {
            list($naam, $prijs, $beschrijving) = mysqli_fetch_array($r, MYSQLI_NUM);
        } // Einde van IF met mysqli_num_rows().

    } // Einde van IF met ($algemene_widgets_id > 0).

} // Einde van IF met isset($_GET['algemene_widgets_id']).

// Gebruik de naam als de paginatitel:
if ($naam) {
    $paginatitel = $naam;
}

// Voeg het header-bestand in:
include_once('./includes/header.html');

if ($naam) { // Toon de specifieke producten.

    echo "<h1>$naam</h1>\n";

    // Toon productbeschrijving als die niet leeg is:
    if (!empty($beschrijving)) {
        echo "<p>$beschrijving</p>\n";
    }

    // Haal de specifieke producten van dit product op:
    $q = "SELECT specifieke_widgets_id, kleur, maat, prijs, op_voorraad FROM specifieke_widgets LEFT JOIN kleuren USING (kleur_id) LEFT JOIN maten USING (maat_id) WHERE algemene_widgets_id=$algemene_widgets_id ORDER BY maat, kleur";
    $r = mysqli_query($dbc, $q);

    if (mysqli_num_rows($r) > 1) {

        // Toon elk product:
        echo '<h3>Beschikbare maten en kleuren</h3>';

        while ($rij = mysqli_fetch_array($r, MYSQLI_ASSOC)) {

            // Bepaal de prijs:
            $prijs = (empty($rij['prijs'])) ? $prijs : $rij['prijs'];

            // Geef het merendeel van de informatie weer:
            echo "<p>Maat: {$rij['maat']}<br />Kleur: {$rij['kleur']}<br />Prijs: &euro; $prijs<br />Op voorraad: {$rij['op_voorraad']}";

            // Toon de link naar het wagentje:
            if ($rij['op_voorraad'] == 'J') {
                echo "<br /> <a href=\"winkelwagentje.php?specifieke_widgets_id={$rij['specifieke_widgets_id']}&actie=toevoegen\">Toevoegen aan winkelwagentje</a>";
            }

            echo '</p>';

        } // Einde van while-lus.

    } else { // Hier zijn geen specifieke producten!
        echo '<p class="fout">Helaas zijn deze widgets op dit moment niet leverbaar.</p>';
    }

} else { // Ongeldige $_GET['algemene_widgets_id']!
    echo '<p class="fout">Er is een fout opgetreden bij het openen van deze pagina.</p>';
}

// Voeg het footer-bestand in om de sjabloon te voltooien:
include_once('./includes/footer.html');

?>
