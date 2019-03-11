<!DOCTYPE html>

<head>
<title>Ist Heute Stupa?</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fjalla+One" > 
</head>

<body>
<br/>
<div class="header">
<?php
// compareDate vergleicht zwei Daten der Form $d = {"year":year, "month": month, "day": day) miteinander.
// return: 0 falls $d1 == $d2, -1 falls $d1 < $d2, 1 falls $d1 > $d2
function compareDate($d1, $d2)
{
    $c = 1;
    
    // Ermittle, ob das Datum in der Vergangenheit liegt
    if ($d2 ["year"] < $d1["year"] || ($d2 ["year"] == $d1["year"] && $d2 ["month"] < $d1 ["month"]) ||  ($d2 ["year"] == $d1["year"] && $d2 ["month"] == $d1 ["month"] && $d2 ["day"] < $d1["day"])) {
        $c = -1;
    }
    // Ermittle, ob das Datum Heute ist
    elseif (($d2["day"] == $d1["day"] && $d2["month"] == $d1["month"] && $d2["year"] == $d1["year"])) {
        $c = 0;
    }
    // (Falls das Datum in der Zukunft ist, gilt default case: $c = 1)
    return $c;
}


// Lade den Inhalt von der Stupa-Website
$content = file_get_contents ("http://stupa.uni-goettingen.de/sitzungen/legislatur-2019-20/");

// Lege Start- und Endtextpositionen fest, zwischen denen das Datum (wahrscheinlich) steht
$startstr = "<span class=\"su-spoiler-icon\"></span>";
$endstr = "</div>";

// Ermittle Text zwischen den Positionen
$startpos = strpos ($content, $startstr) + strlen ($startstr);
$endpos = strpos ($content, $endstr, $startpos);
$text = substr ($content, $startpos, ($endpos - $startpos));

// Ermittle das Datum des nächsten Stupas und das heutige Datum
$nextdate = date_parse ($text);
$today["day"] = intval (date("d"));
$today["month"] = intval (date("m"));
$today["year"] = intval (date ("Y"));

// Mache Strings aus den Daten! Für die Ausgabe, aber eigentlich zum testen.
$nextdatestr = ("" . ($nextdate["day"]) . "-" . $nextdate["month"] . "-" . $nextdate["year"]);
$todaystr = ("" . ($today["day"]) . "-" . $today["month"] . "-" . $today["year"]);

// Gebe wieder
// print $content;
$c = compareDate ($today, $nextdate);
if ($c == 0) {
    printf ("<h1>JA :( :( :(</h1>");
}
else {
    printf ("<h1>Nein!</h1>");
    if ($c == 1) {
        printf ("<h2>Nächstes Stupa: ");
    }
    elseif ($c == -1) {
        printf ("<h2>Letztes Stupa: ");
    }
    printf ("" . $nextdatestr . "<br>Heute: " . $todaystr . "</h2>");
}
?>
</div>

<div class="footer">
<p><a href="http://stupa.uni-goettingen.de/sitzungen/legislatur-2019-20/">Hier</a> kannst du nachgucken.</a></p>
<p>Diese Seite saugt nur einen einzelnen Eintrag von der verlinkten Seite und hofft dann, dass sie das lesen kann. Ist richtig eklig zusammengehackt, und dann auch noch in PHP (ih!) - also geh bloß nicht von Richtigkeit aus!</p>
</div>
<div class="links">
<a href="https://github.com/Chrigge/istheutestupa"><img src="res/GitHub-Mark-Light-120px-plus.png" alt="GitHub" width="32" height="32" /></a>
<a href="https://www.facebook.com/schwartzrottkollabst/"><img src="res/schwarzrotkollabs.png" alt="Schwarz-Rot Kollabs" width="32" height="32"/></a>
</div>
<div class="impressum">
<a href="/impressum.html">Impressum</a>
</div>
</div>
</body>
</html>
