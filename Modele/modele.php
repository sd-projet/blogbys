<?php
class Compte {

    private $post_data;
    private $file_data;

    function __construct($post_param,$file_param) {
        $this->post_data = $post_param;
        $this->file_data = $file_param;
    }


    public function retournePost() {
        return $this->post_data;
    }

    public function retourneFile() {
        return $this->file_data;
    }

    public function uploadePhoto() {
        $destination = "../upload/" . $_FILES["photo"]["name"];
        $res = move_uploaded_file($_FILES["photo"]["tmp_name"],
            $destination);
        if ($res) $etat = "Fichier téléchargé avec succès";
        else $etat = $_FILES["photo"]["error"];
    }

    public function deconnect() {
        session_start();
        $_SESSION = array();
        session_destroy();
        header("Location: ../Controleur/compte/connexionControleur.php");
    }
}

?>