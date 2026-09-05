<?php

class Requete {
    protected $pdo;
    protected $tbs;
    protected $req;
    protected $gab;
    protected $data;

    function __construct($param_pdo, $param_tbs, $param_req, $param_gab) {
        $this->pdo = $param_pdo;
        $this->tbs = $param_tbs;
        $this->req = $param_req;
        $this->gab = $param_gab;
    }

    public function executer() {
        $res = $this->pdo->prepare($this->req);
        $res->execute();
        $this->data = $res->fetchAll();
    }
}

class RQ1 extends Requete {

    public function afficher() {
        $i = 0;
        $listeCode = array();
        $listeLibe = array();
        foreach($this->data as $ligne) {
            $listeCode[$i++] = $ligne["pseudoAvis"];
            $listeLibe[$i++] = $ligne["commAvis"];
        }
        // Affichage du gabarit
        $this->tbs->LoadTemplate($this->gab);
        $this->tbs->MergeBlock("pseudoAvis", $listeCode);
        $this->tbs->MergeBlock("commAvis", $listeLibe);
        $this->tbs->Show();
    }
}

?>
