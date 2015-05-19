<?php # Script 8.4 - WidgetWinkelwagentje.php

/**
 * Deze pagina definieert de klasse WidgetWinkelwagentje.
 * De klasse heeft één attribuut: een array $items.
 * De klasse heeft vijf methoden:
 * - is_leeg()
 * - item_toevoegen()
 * - item_bijwerken()
 * - item_verwijderen()
 * - wagentje_weergeven()
 */

namespace Ullman\PHPGevorderden;

class WidgetWinkelwagentje
{

    // Attribuut:
    protected $items = array();


    // Methode die een booleaanse waarde retourneert
    // die aangeeft of het winkelwagentje leeg is:
    public function is_leeg()
    {
        if (empty($this->items)) {
            return TRUE;
        } else {
            return FALSE;
        }
    } // Einde van de methode is_leeg().


    // Methode die een item aan een winkelwagentje toevoegt.
    // Accepteert twee argumenten: de item-ID en een array met informatie.
    public function item_toevoegen($id, $info)
    {

        // Zit het item al in het winkelwagentje?
        if (isset($this->items[$id])) {

            // Roep de methode item_bijwerken() aan:
            $this->item_bijwerken($id, $this->items[$id]['aantal'] + 1);

        } else {

            // Voeg de array met informatie toe:
            $this->items[$id] = $info;

            // Voeg de hoeveelheid toe:
            $this->items[$id]['aantal'] = 1;

            // Toon een melding:
            echo "<p>De widget '{$info['naam']}' in de kleur {$info['kleur']} en de maat {$info['maat']} is toegevoegd aan uw winkelwagentje.</p>\n";

        }

    } // Einde van de methode item_toevoegen().


    // Methode die een item in het winkelwagentje bijwerkt.
    // Accepteert twee argumenten: de item-ID en de hoeveelheid.
    public function item_bijwerken($id, $aantal)
    {

        // Item verwijderen als $aantal gelijk is aan 0:
        if ($aantal == 0) {

            $this->item_verwijderen($id);

        } elseif (($aantal > 0) && ($aantal != $this->items[$id]['aantal'])) {

            // Werk de hoeveelheid bij:
            $this->items[$id]['aantal'] = $aantal;

            // Toon een melding:
            echo "<p>U hebt nu $aantal widget(s) '{$this->items[$id]['naam']}' in de kleur {$this->items[$id]['kleur']} en de maat {$this->items[$id]['maat']} in uw winkelwagentje.</p>\n";

        }

    } // Einde van de methode item_bijwerken().


    // Methode die een item uit het winkelwagentje verwijdert.
    // Accepteert één argument: de item-ID.
    public function item_verwijderen($id)
    {

        // Controleer of het item in het winkelwagentje zit:
        if (isset($this->items[$id])) {

            // Toon een melding:
            echo "<p>De widget '{$this->items[$id]['naam']}' in de kleur {$this->items[$id]['kleur']} en de maat {$this->items[$id]['maat']} is verwijderd uit uw winkelwagentje.</p>\n";

            // Verwijder het item:
            unset($this->items[$id]);

        }

    } // Einde van de methode item_verwijderen().


    // Methode die het winkelwagentje weergeeft.
    // Accepteert één argument: de waarde $actie voor een formulier.
    public function wagentje_weergeven($actie = FALSE)
    {

        // Geef een tabel weer:
        echo '<table border="0" width="90%" cellspacing="2" cellpadding="2" align="center">
                <tr>
                  <th align="left" width="20%">Widget</th>
                  <th align="left" width="15%">Maat</th>
                  <th align="left" width="15%">Kleur</th>
                  <th align="right" width="15%">Prijs</th>
                  <th align="center" width="10%">Aantal</th>
                  <th align="right" width="15%">Bedrag</th>
                </tr>
             ';

        // Toon de formuliercode, indien nodig.
        if ($actie) {
            echo '<form action="' . $actie . '" method="post">
                  <input type="hidden" name="actie" value="bijwerken" />
                 ';
        }

        // Initialiseer het totaal:
        $totaal = 0;

        // Maak een lus door alle items:
        foreach ($this->items as $id => $info) {

            // Bereken het totaal en de subtotalen:
            $subtotaal = $info['aantal'] * $info['prijs'];
            $totaal += $subtotaal;
            $subtotaal = number_format($subtotaal, 2);

            // Bepaal hoe de hoeveelheid wordt weergegeven:
            $aantal = ($actie) ? "<input type=\"text\" size=\"3\" name=\"aantal[$id]\" value=\"{$info['aantal']}\" />" : $info['aantal'];

            // Geef de rij weer:
            echo <<<EOT
<tr>
  <td align="left">{$info['naam']}</td>
  <td align="left">{$info['maat']}</td>
  <td align="left">{$info['kleur']}</td>
  <td align="right">&euro;&nbsp;{$info['prijs']}</td>
  <td align="center">$aantal</td>
  <td align="right">&euro;&nbsp;$subtotaal</td>
</tr>\n
EOT;

        } // Einde van de lus FOREACH.

        // Voltooi de tabel:
        echo '<tr>
                <td colspan="5" align="right"><strong>Totaal:</strong></td>
                <td align="right">&euro;&nbsp;' . number_format($totaal, 2) . '</td>
              </tr>';

        // Voltooi het formulier, indien nodig:
        if ($actie) {
            echo '<tr>
                    <td colspan="6" align="center">Stel het aantal in op 0 als u een item wilt verwijderen uit het winkelwagentje.</td>
                  </tr>
                  <tr>
                    <td colspan="6" align="center"><input type="submit" name="submit" value="Winkelwagentje bijwerken" /></td>
                  </tr>
                  </form>';
        }

        echo '</table>';

    } // Einde van de methode wagentje_weergeven().

} // Einde van de klasse WidgetWinkelwagentje.

?>