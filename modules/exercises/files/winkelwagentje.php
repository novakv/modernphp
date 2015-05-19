<?php # Script 5.7 - winkelwagentje.php

/**
 * Dit is de pagina voor het winkelwagentje.
 * Deze pagina heeft twee modi:
 * - product toevoegen aan de wagen;
 * - wagen bijwerken.
 * De pagina toont de wagen als formulier voor het bijwerken van hoeveelheden.
 */

$dbc = mysqli_connect('localhost', 'winkel', 'brobbeltje', 'ecommerce') OR die("Cannot connect to database.");

// Voeg het header-bestand in:
$paginatitel = 'Winkelwagentje';
include_once('./includes/header.html');

echo '<h1>Overzicht van uw winkelwagentje</h1>';

// Deze pagina voegt producten toe aan het winkelwagentje of werkt het bij,
// afhankelijk van de waarde van $_REQUEST['actie'];
if (isset($_REQUEST['actie']) && ($_REQUEST['actie'] == 'toevoegen') ) { // Nieuw item toevoegen.

    if (isset($_GET['specifieke_widgets_id'])) { // Controleer op een product-ID.

        // Typecast naar een integer:
        $specifieke_widgets_id = (int)$_GET['specifieke_widgets_id'];

        // Haal de iteminformatie op
        // als de ID een positieve integer is:
        if ($specifieke_widgets_id > 0) {

            // Definieer de query en voer hem uit:
            $q = "SELECT naam, kleur, maat FROM algemene_widgets LEFT JOIN specifieke_widgets USING (algemene_widgets_id) LEFT JOIN kleuren USING (kleur_id) LEFT JOIN maten USING (maat_id) WHERE specifieke_widgets_id=$specifieke_widgets_id";
            $r = mysqli_query($dbc, $q);

            if (mysqli_num_rows($r) == 1) {

                // Haal de informatie op:
                list($naam, $kleur, $maat) = mysqli_fetch_array($r, MYSQLI_NUM);

                // Verhoog de hoeveelheid als de wagen
                // al een van deze producten bevat:
                if (isset($_SESSION['wagen'][$specifieke_widgets_id])) {

                    $_SESSION['wagen'][$specifieke_widgets_id]++;

                    // Toon een bericht:
                    echo "<p>Er is een extra exemplaar van '$naam' in de kleur $kleur en de maat $maat toegevoegd aan uw winkelwagentje.</p>\n";

                } else { // Nieuw in de wagen.

                    // Voeg toe aan de wagen:
                    $_SESSION['wagen'][$specifieke_widgets_id] = 1;

                    // Toon een bericht:
                    echo "<p>De widget '$naam' in de kleur $kleur en de maat $maat is toegevoegd aan uw winkelwagentje.</p>\n";

                }

            } // Einde van IF met mysqli_num_rows().

        } // Einde van IF met ($specifieke_widgets_id > 0).

    } // Einde van IF met isset($_GET['specifieke_widgets_id']).

} elseif (isset($_REQUEST['actie']) && ($_REQUEST['actie'] == 'bijwerken')) {

    // Verander de hoeveelheden ...
    // $sleutel is de product-ID.
    // $waarde is de nieuwe hoeveelheid.
    foreach ($_POST['aantal'] as $sleutel => $waarde) {

        // Moeten integers zijn!
        $pid    = (int)$sleutel;
        $aantal = (int)$waarde;

        if ($aantal == 0) { // Verwijder item.
            unset ($_SESSION['wagen'][$pid]);
        } elseif ($aantal > 0) { // Verander hoeveelheid.
            $_SESSION['wagen'][$pid] = $aantal;
        }

    } // Einde van FOREACH.

    // Toon een melding:
    echo '<p>Uw winkelwagentje is bijgewerkt.</p>';

} // Einde van IF-ELSEIF voor $_REQUEST.

// Toon het winkelwagentje als het niet leeg is:
if (isset($_SESSION['wagen']) && !empty($_SESSION['wagen'])) {

    // Haal alle informatie op voor de producten in het winkelwagentje:
    $q = "SELECT specifieke_widgets_id, naam, kleur, maat, standaardprijs, prijs FROM algemene_widgets LEFT JOIN specifieke_widgets USING (algemene_widgets_id) LEFT JOIN kleuren USING (kleur_id) LEFT JOIN maten USING (maat_id) WHERE specifieke_widgets_id IN (";

    // Voeg alle product-ID’s toe:
    foreach ($_SESSION['wagen'] as $specifieke_widgets_id => $waarde) {
        $q .= (int)$specifieke_widgets_id . ',';
    }
    $q = substr ($q, 0, -1) . ') ORDER BY naam, maat, kleur';
    $r = mysqli_query($dbc, $q);

    if (mysqli_num_rows($r) > 0) {

        // Maak een tabel en een formulier:
        echo '<table border="0" width="90%" cellspacing="2" cellpadding="2" align="center">
                <tr>
                  <td align="left" width="20%"><strong>Widget</strong></td>
                  <td align="left" width="15%"><strong>Maat</strong></td>
                  <td align="left" width="15%"><strong>Kleur</strong></td>
                  <td align="right" width="15%"><strong>Prijs</strong></td>
                  <td align="center" width="10%"><strong>Aantal</strong></td>
                  <td align="right" width="15%"><strong>Bedrag</strong></td>
                </tr>
                <form action="winkelwagentje.php" method="post">
                <input type="hidden" name="actie" value="bijwerken" />
             ';

        // Geef alle items weer:
        $totaal = 0; // Totaalbedrag van de order.
        while ($rij = mysqli_fetch_array($r, MYSQLI_ASSOC)) {

            // Stel de prijs vast:
            $prijs = (empty($rij['prijs'])) ? $rij['standaardprijs'] : $rij['prijs'];

            // Bereken het totaal en de subtotalen:
            $subtotaal = $_SESSION['wagen'][$rij['specifieke_widgets_id']] * $prijs; 
            $totaal += $subtotaal;
            $subtotaal = number_format($subtotaal, 2);

            // Toon de rij:
            echo <<<EOT
<tr>
  <td align="left">{$rij['naam']}</td>
  <td align="left">{$rij['maat']}</td>
  <td align="left">{$rij['kleur']}</td>
  <td align="right">&euro;&nbsp;$prijs</td>
  <td align="center"><input type="text" size="3" name="aantal[{$rij['specifieke_widgets_id']}]" value="{$_SESSION['wagen'][$rij['specifieke_widgets_id']]}" /></td>
  <td align="right">&euro;&nbsp;$subtotaal</td>
</tr>\n
EOT;

        } // Einde van de while-lus.

        // Toon de voettekst en sluit de tabel en het formulier:
        echo '  <tr>
                  <td colspan="5" align="right"><strong>Totaal:</strong></td>
                  <td align="right">&euro;&nbsp;' . number_format($totaal, 2) . '</td>
                </tr>
                <tr>
                  <td colspan="6" align="center">Stel het aantal in op 0 als u een item wilt verwijderen uit het winkelwagentje.</td>
                </tr>
              </table><div align="center"><button type="submit" name="submit" value="bijwerken">Winkelwagentje bijwerken</button> &nbsp; &nbsp; &nbsp; &nbsp; 
                <a href="betalen.php"><button type="button" name="afrekenen" value="Afrekenen">Afrekenen</button></a></div>
              </form>';

    } // Einde van IF met mysqli_num_rows().

} else {
    echo '<p>Uw winkelwagentje is leeg.</p>';
}

// Voeg het footer-bestand in om de sjabloon te voltooien:
include_once ('./includes/footer.html');

?>