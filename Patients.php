<?php 

require 'header.php';
require 'database.php';
if ($_SERVER['REQUEST_METHOD']=== 'GET'){

    if(isset($_GET['id'])){

        $id = $conn-> real_escape_string($_GET['id']);
        $sql =  $conn->query("SELECT *FROM Patients WHERE id = '$id'");
        $data = $sql-> fetch_assoc();
    } else{

        $data = array(); 
        $sql = $conn->query("SELECT * FROM Patients ");
        while ($d = $sql->fetch_assoc()){

            $data []= $d;
        }

    }

    exit(json_encode($data));
    
}

if ($_SERVER['REQUEST_METHOD']=== 'GET'){

    if(isset($_GET['EtatPatient'])){

        $id = $conn-> real_escape_string($_GET['EtatPatient']);
        $sql =  $conn->query("SELECT *FROM Patients WHERE EtatPatient = '$id'");
        $data = $sql-> fetch_assoc();
    } else{

        $data = array(); 
        $sql = $conn->query("SELECT * FROM Patients ");
        while ($d = $sql->fetch_assoc()){

            $data []= $d;
        }

    }

    exit(json_encode($data));
    
}
if ($_SERVER['REQUEST_METHOD']=== 'POST'){

    $data = json_decode(file_get_contents("php://input"));

    $sql = $conn->query("INSERT INTO Patients (nom,postnom,prenom,sexe,EtatPatient,Adresse,Telephone) VALUES ('".$data->nom."','".$data->postnom."','".$data->prenom."','".$data->sexe."','".$data->etat."','".$data->Adresse."','".$data->Telephone."')");
    
    if ($sql){
        $data-> id = $conn->insert_id;
        exit(json_encode($data));

    } else{

        exit(json_encode(array('status' => 'error')));
    }

}


if ($_SERVER['REQUEST_METHOD']=== 'PUT'){
    if(isset($_GET['id'])){

        $id = $conn-> real_escape_string($_GET['id']);
        $data = json_decode(file_get_contents("php://input"));
        $sql=  $conn->query(" UPDATE Patients SET nom = '".$data->nom."',postnom= '".$data->postnom."',prenom= '".$data->prenom."',sexe ='".$data->sexe."', Adresse= '".$data->Adresse."', Telephone = '".$data->Telephone."' WHERE id ='$id'");

    if($sql){
        exit(json_encode(array('status'=> 'succes')));

    } else {
        exit(json_encode(array('status'=> 'error')));
    }

    }

}
if ($_SERVER['REQUEST_METHOD']=== 'DELETE'){

    if(isset($_GET['id'])){

        $id = $conn-> real_escape_string($_GET['id']);
        $data = json_decode(file_get_contents("php://input"));

        $sql=  $conn->query(" DELETE FROM Patients  WHERE id ='$id'");

    if($sql){
        exit(json_encode(array('status'=> 'succes')));

    } else {
        exit(json_encode(array('status'=> 'error')));
    }

    }

}

?>


