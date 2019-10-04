<?php

/**
 * Description of plante
 *
 * @author Web-Star
 */
class plante {
    //attributs
    protected $id;
    protected $nom;
    protected $famille;//objet
    protected $description;
    protected $partieToxique;//obj
    protected $animauxConcernes;//obj
    protected $symptomes;
    protected $toxicite;//objet
    //methodes
        
        //getters
        public function getId() {
            //charger l'attribut
            //retourner l'attribut
            //neant
            if($this->id){
                return $this->id;
            }else{
                0;
            }
        }
        public function getNom(){
            if($this->nom){
                return $this->nom;
            }else{
                "";
            }
        }
        public function getFamille(){
            if($this->famille){
                $famille = new famille($this->famille);
                return $famille->getLibelle();
            }else{
                "";
            }
        }
        public function getDescription(){
            if($this->description){
                return $this->description;
            }else{
                "";
            }
        }
        public function getPartieToxique(){
            if($this->partieToxique){
                $lienPlantePartie = new lienPlanteAnimaux($this->partieToxique);
                return $lienPlantePartie->getPartie();
            }else{
                "";
            }
        }
        public function getAnimauxConcernes(){
            if($this->animauxConcernes){
                $lienPlanteAnimaux = new lienPlanteAnimaux($this->animauxConcernes);
                return $lienPlanteAnimaux->getAnimaux;
            }else{
                "";
            }
        }
        public function getSymptomes() {
            if($this->symptomes){
                return $this->symptomes;
            }else{
                "";
            }
        }
        public function getToxicite() {
            if($this->toxicite){
                $toxicite = new toxicité($this->toxicite);
                return $toxicite->getLibelle();
            }else{
                "";
            }
        }
        //setters
        public function setId($id) {
            //mettre a jour l'attribut
            //retourner true or false
            //param l'attribut a mettre a jour
            $this->id = $id;
            return true;
        }
        public function setNom($nom) {
            $this->nom = $nom;
            return true;
        }
        public function setFamille($famille) {
            $this->famille = $famille;
            return true;
        }
        public function setDescription($description) {
            $this->description = $description;
            return true;
        }
        public function setPartieToxique($partieToxique) {
            $this->partieToxique = $partieToxique;
            return true;
        }
        public function setAnimauxConcernes($animauxConcernes) {
            $this->animauxConcernes = $animauxConcernes;
            return true;
        }
        public function setSymptome($symptomes) {
            $this->symptomes = $symptomes;
            return true;
        }
        public function setToxicite($toxicite){
            $this->toxicite = $toxicite;
            return true;
        }
        //load by id
        public function loadById($id){
            //charger a partir de l'id
            //booleen
            //l'id en question
            global $bdd;
            $sql="SELECT * FROM `plante` WHERE `id`=:id";
            $req = $bdd->prepare($sql);
            $param = [":id"=>$id];
            if(!$req->execute($param)){
                debug("plante->loadById : req->execute a choue");
                return false;
            }
            $ligne = $req->fetch(PDO::FETCH_ASSOC);
            $this->id = $ligne["id"];
            $this->nom = $ligne["nom"];
            $this->famille = $ligne["famille"];
            $this->partieToxique = $ligne["partieToxique"];
            $this->animauxConcernes = $ligne["animauxConcernes"];
            $this->symptomes = $ligne["symptomes"];
            $this->toxicité = $ligne["toxicite"];
            return true;
        }
        //construct
        public function __construct() {
            //si l'id existe faire un chargement par l'id
            if (isset($id)) {
            $this->loadById($id);
            }
        }
        //fromPost
        public function FromPost() {
            if(!$this->setNom($_POST["nom"])){
                return FALSE;
            }
            if(!$this->setFamille($_POST["famille"])){
                return FALSE;
            }
            if (!$this->setAnimauxConcernes($_POST["animauxConcernes"])) {
                return FALSE;
            }
            if (!$this->setPartieToxique($_POST["partieToxique"])) {
                return FALSE;
            }
            if (!$this->setSymptome($_POST["symptomes"])) {
                return FALSE;
            }
            if(!$this->setToxicite($_POST["toxicite"])){
                return FALSE;
            }
            return TRUE;
        }
        //insert
        public function insert() {
        //role inserer une nouvel plante dans la base
        //retour boolean
        //param neant
        global $bdd;
        $sql = "INSERT INTO `plante` SET `nom`=:nom,"
                . "`famille`=:famille,"
                . "`partieToxique`=:partieToxique,"
                . "`animauxConcernes`=:animauxConcernes,"
                . "`symptomes`= symptomes,"
                . "`toxicite`=:toxicite";
        $param = [":nom" => $_POST["nom"],
            ":famille" => $_POST["famille"],
            ":partieToxique" => $_POST["partieToxique"],
            ":animauxConcernes" => $_POST["animauxConcernes"],
            ":symptomes" => $_POST["symptomes"],
            ":toxicité" => $_POST["toxicité"]];
        //si une photo a ete upload
        if (!empty($_FILES)) {
            $name = $_FILES["photo"]["name"];
            $file_extension = strrchr($name, ".");
            $destination = "img/" . $name;
            $temp = $_FILES["photo"]["tmp_name"];
            $extension_autorized = array(".jpg", ".jpeg", ".bmp", ".gif", ".png", ".JPG", ".JPEG", ".BMP", ".GIF", ".PNG");
            if (in_array($file_extension, $extension_autorized)) {
                if (move_uploaded_file($temp, $destination)) {
                    $sql .= ", `photo`=:photo";
                    $param[","];
                    $param[":photo"] = $destination;
                } else {
                    debug("uploadFiles: faux");
                }
            }
            debug("il y a un fichier");
            $req = $bdd->prepare($sql);
            if (!$req->execute($param)) {
                debug("plante->insert with files a echoue");
                return false;
            }
            if ($req->rowCount() === 1) {
                $this->id = $bdd->lastInsertId();
                debug("last insert id with files ok");
                return true;
            }
        } else {
            debug("il n'y a pas de fichier");
            $req = $bdd->prepare($sql);
            if (!$req->execute($param)) {
                debug("fiche->insert without files a echoue");
                return false;
            }
            if ($req->rowCount() === 1) {
                $this->id = $bdd->lastInsertId();
                debug("last insert id without files ok");
                return true;
            }
        }
    }
        //getList
        public function getList() {
        //role lister les plantes
        //retour tableau
        //param neant
        global $bdd;
        $sql = "SELECT * FROM `plante`";
        $req = $bdd->prepare($sql);
        if (!$req->execute()) {
            debug("plante->getList a echouÃ©");
            return [];
        }
        while ($ligne = $req->fetch(PDO::FETCH_ASSOC)) {
            $plante = new plante();
            $plante->loadById($ligne["id"]);
            $result[] = $plante;
        }
        if (empty($result)) {
            return $result = [];
        }
        return $result;
    }
        
    //actions
}
