<?php

class LatexZone {
    private $name;
    private $textContent;
    public function __construct($name = "") {
        $this->name = $name;

        if (isset($_GET[$name]) && $_GET[$name] != "") {
            $this->textContent = $_GET[$name];
        }
    }

    public function displayTextArea(int $rows = 1, int $cols = 10) {
        $res = "<form action='' method='GET' > \n";
        $res .= "<textarea name='$this->name' rows='$rows' cols='$cols'>" . $this->textContent . "</textarea> \n";
        $res .= "<button type='submit'> Render </button> \n";
        $res .= "</form>";

        return $res;
    }

    public function getContent() {
        return $this->textContent;
    }
}