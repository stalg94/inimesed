<?php
$connection=mysqli_connect("localhost","root",null,"inimesed");
$connection->set_charset('UTF-8');
if (!$connection){
    die("Error connect to database");
}

//CREATE TABLE maakond(
//    id int PRIMARY KEY AUTO_INCREMENT,
//            maakonna_nimi varchar(100),
//            maakonna_keskus varchar(100)
//        );
//          CREATE TABLE inimene(
//    id int PRIMARY KEY AUTO_INCREMENT,
//            eesnimi varchar(100),
//			perekonnanimi varchar(100),
//            maakonna_id int,
//            FOREIGN KEY (maakonna_id) REFERENCES maakonna_nimi(id)
//        );
//        INSERT INTO maakond(maakonna_nimi,maakonna_keskus) VALUES ('Ida-Virumaa', 'Jõhvi');
//        INSERT INTO maakond(maakonna_nimi,maakonna_keskus) VALUES ('Harjumaa', 'Tallinn');
//        INSERT INTO maakond(maakonna_nimi,maakonna_keskus) VALUES ('Pärnumaa', 'Pärnu');
//        INSERT INTO inimene(eesnimi, perekonnanimi, maakonna_id) VALUES ('Ivan', 'Ivanov', 1);
//        INSERT INTO inimene(eesnimi, perekonnanimi, maakonna_id) VALUES ('Sergei', 'Petrov', 1);
//        INSERT INTO inimene(eesnimi, perekonnanimi, maakonna_id) VALUES ('Andrei', 'Tamm', 2);
//        INSERT INTO inimene(eesnimi, perekonnanimi, maakonna_id) VALUES ('Anton', 'Mets', 2);
//        INSERT INTO inimene(eesnimi, perekonnanimi, maakonna_id) VALUES ('Stas', 'Aleksejevski', 3);
//        INSERT INTO inimene(eesnimi, perekonnanimi, maakonna_id) VALUES ('Mihhail', 'Kozlov', 3);


?>