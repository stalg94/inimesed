<?php
require("vendor/config.php");


function countyData($sort_by = "eesnimi", $search_term = "") {
    global $connection;
    $sort_list = array("eesnimi", "perekonnanimi", "maakonna_nimi");
    if(!in_array($sort_by, $sort_list)) {
        return "Seda tulpa ei saa sorteerida";
    }
    $request = $connection->prepare("SELECT inimene.id, eesnimi, perekonnanimi, maakond.maakonna_nimi
    FROM inimene, maakond 
    WHERE inimene.maakonna_id = maakond.id 
    AND (eesnimi LIKE '%$search_term%' OR perekonnanimi LIKE '%$search_term%' OR maakonna_nimi LIKE '%$search_term%')
    ORDER BY $sort_by");
    $request->bind_result($id, $eesnimi, $perekonnanimi, $maakonna_nimi);
    $request->execute();
    $data = array();
    while($request->fetch()) {
        $person = new stdClass();
        $person->id = $id;
        $person->eesnimi = htmlspecialchars($eesnimi);
        $person->perekonnanimi = htmlspecialchars($perekonnanimi);
        $person->maakonna_nimi = $maakonna_nimi;
        array_push($data, $person);
    }
    return $data;
}
//переделать
function groupData($sort_by = "kaubanimi", $search_term = "") {
    global $connection;
    $sort_list = array("kaubanimi", "hind", "kaubagrupp");
    if(!in_array($sort_by, $sort_list)) {
        return "Seda tulpa ei saa sorteerida";
    }
    $request = $connection->prepare("SELECT kaubad.id, kaubanimi, hind, kaubagrupid.kaubagrupp
    FROM kaubad, kaubagrupid 
    WHERE kaubad.kaubagrupp_id = kaubagrupid.id 
    AND (kaubanimi LIKE '%$search_term%' OR hind LIKE '%$search_term%' OR kaubagrupp LIKE '%$search_term%')
    ORDER BY $sort_by");
    $request->bind_result($id, $kaubanimi, $hind, $kaubagrupp);
    $request->execute();
    $data = array();
    while($request->fetch()) {
        $good = new stdClass();
        $good->id = $id;
        $good->kaubanimi = htmlspecialchars($kaubanimi);
        $good->hind = htmlspecialchars($hind);
        $good->kaubagrupp = $kaubagrupp;
        array_push($data, $good);
    }
    return $data;
}

function createSelect($query, $name) {
    global $connection;
    $query = $connection->prepare($query);
    $query->bind_result($id, $data);
    $query->execute();
    $result = "<select name='$name'>";
    while($query->fetch()) {
        $result .= "<option value='$id'>$data</option>";
    }
    $result .= "</select>";
    return $result;
}

function addCounty($county_name, $county_centre) {
    global $connection;
    if ($county_name != "" && $county_centre != ""){
        $query = $connection->prepare("INSERT INTO maakond (maakonna_nimi, maakonna_keskus)
    VALUES (?, ?)");
        $query->bind_param("si", $county_name, $county_centre);
        $query->execute();
    }
}

function addGroup($kaubagrupp){
    global $connection;
    if ($kaubagrupp != ""){
        $query = $connection->prepare("INSERT INTO kaubagrupid (kaubagrupp)
    VALUES (?)");
        $query->bind_param("s", $kaubagrupp);
        $query->execute();
    }
}

function addGood($kaubanimi, $hind, $kaubagrupp_id) {
    global $connection;
    if ($kaubanimi != "" && $hind != ""){
        $query = $connection->prepare("INSERT INTO kaubad (kaubanimi, hind, kaubagrupp_id)
    VALUES (?, ?, ?)");
        $query->bind_param("ssd", $kaubanimi, $hind, $kaubagrupp_id);
        $query->execute();
    }
}
function addPerson($first_name, $last_name, $county_id) {
    global $connection;
    if ($first_name != "" && $last_name != ""){
        $query = $connection->prepare("INSERT INTO inimene (eesnimi, perekonnanimi, maakonna_id)
    VALUES (?, ?, ?)");
        $query->bind_param("ssd", $first_name, $last_name, $county_id);
        $query->execute();
    }
}

function deletePerson($person_id) {
    global $connection;
    $query = $connection->prepare("DELETE FROM inimene WHERE id=?");
    $query->bind_param("i", $person_id);
    $query->execute();
}
function deleteGood($good_id) {
    global $connection;
    $query = $connection->prepare("DELETE FROM kaubad WHERE id=?");
    $query->bind_param("i", $good_id);
    $query->execute();
}

function savePerson($person_id, $first_name, $last_name, $county_id) {
    global $connection;
    $query = $connection->prepare("UPDATE inimene
    SET eesnimi=?, perekonnanimi=?, maakonna_id=?
    WHERE inimene.id=?");
    $query->bind_param("ssii", $first_name, $last_name, $county_id, $person_id);
    $query->execute();
}

function saveGood($good_id, $kaubanimi, $hind, $kaubagrupp_id) {
    global $connection;
    $query = $connection->prepare("UPDATE kaubad
    SET kaubanimi=?, hind=?, kaubagrupp_id=?
    WHERE kaubad.id=?");
    $query->bind_param("ssii", $kaubanimi, $hind, $kaubagrupp_id, $good_id);
    $query->execute();
}

?>