<?php

class template {

    private $vorlage = '';
    private $content = '';
    /**
     * Konstruktor der TemplateKlasse. Es wird die Templatedatei geladen
     * Die Endung muss weggelassen werden.
     * @param <string> $templatefile Die HTML-Templatedatei
     */
    public function __construct($templatefile) {
        if (isset($templatefile) && file_exists('template/' . $templatefile . '.html')) {

            $f = fopen('template/' . $templatefile . '.html', 'r');
            $header = fopen('template/header.html', 'r');
            $footer = fopen('template/footer.html', 'r');
            if ($f) {
                $this->vorlage = fread($header, filesize('template/header.html'));
                $tmp = fread($f, filesize('template/' . $templatefile . '.html'));
                $this->vorlage .= $tmp;
                $this->content = $tmp;
                $this->vorlage .= fread($footer, filesize('template/footer.html'));
            }
        }
        if (!empty($this->vorlage)) {
            $zeichenkette = $this->vorlage;
            $suchmuster = '|###LANG:(.*)###|';
            preg_match_all($suchmuster, $zeichenkette, $treffer);
            foreach ($treffer[1] as $hit) {
                $search = "###LANG:" . $hit . "###";
                $this->setContent($search, _lang($hit));
            }
            $this->setContent('###URL###', URL);
        }
    }

    /**
     * Es kann im Template eine Variable mit dem Wert ersetzte werden
     * @param <type> $key Schlüssel in der Form: ###[a-z]###
     * @param <type> $value Der Wert
     */
    public function setContent($key, $value) {
        if (isset($key, $value)) {
            $this->vorlage = str_replace($key, $value, $this->vorlage);
        }
    }

    /**
     * Template wird _zurückgegeben_ nicht ausgegeben
     * @return <string> Gibt das Template zurück
     */
    public function getContent() {
        return $this->vorlage;
    }

    public function getVorlage() {
        return $this->content;
    }

    /**
     * Gibt das Template direkt aus. Ausgabe! keine Rückgabe!
     */
    public function display() {
        echo $this->vorlage;
    }

}

?>