<?php 

require 'header.php';
require 'database.php';

$postjson = json_decode(file_get_contents("php://input"),true);

if($postjson['aski'] == "proses_register"){
 
   $Userlog = mysqli_fetch_array(mysqli_query($conn,"SELECT userlog FROM users WHERE userlog='$postjson[userlog]'"));

    if($Userlog){

        $result = json_encode(array('success'=> false, 'msg'=>"cet utilisateur existe"));
    } 
   
   else{

        $password = md5($postjson['pwd']);

    $insert= mysqli_query($conn,"INSERT INTO users SET 
        nom = '$postjson[nom]',
        prenom = '$postjson[prenom]',
        sexe = '$postjson[sexe]',
        Email = '$postjson[Email]',
        userlog = '$postjson[userlog]',
        pwd = '$password'
    ");
    
    if($insert){

        $result =json_encode(array('success'=>true, 'msg'=> 'register successfully'));

    }else{
        $result = json_encode(array('success'=>false, 'msg'=> 'register error'));
    }
}
    echo $result;


} 
elseif($postjson['aski'] =="process_login"){
    $password = md5($postjson['password']);

    //$password = $postjson['password'];
    $login = $postjson['login'];
     
    $logindata = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM 
    users WHERE userlog='$login' AND pwd = '$password' "));

    if ($logindata) {
        $data=array(
            'id'    =>$logindata['id'],
            'nom'    =>$logindata['nom'],
            'prenom'    =>$logindata['prenom'],
            'sexe   '    =>$logindata['sexe'],
            'Email  '    =>$logindata['Email'],
            'userlog'    =>$logindata['userlog']
            //'pwd    '    =>$logindata['pwd']
            
        );
    }
     if($logindata){
            
         $result =json_encode(array('success'=>true, 'result'=>$data));
 
     }else{
         $result = json_encode(array('success'=>false));
     }
 
     echo $result;

}



//post fini ici


if ($_SERVER['REQUEST_METHOD']=== 'GET'){

    if(isset($_GET['id'])){

        $id = $conn-> real_escape_string($_GET['id']);
        $sql =  $conn->query("SELECT * FROM users WHERE id = '$id'");
        $data = $sql-> fetch_assoc();
    } else{

        $data = array();
        $sql = $conn->query("SELECT * FROM users ");
        while ($d = $sql->fetch_assoc()){

            $data []= $d;
        }

    }

    exit(json_encode($data));
    
}
/* if ($_SERVER['REQUEST_METHOD']=== 'POST'){

        $postjson = json_decode(file_get_contents("php://input"),true);
        if($postjson['aski']=="process-register"){

            $sql = $conn->query("INSERT INTO users (nom,prenom,sexe,Email,userlog,pwd) VALUES ('".$data->nom.
            "','".$data->prenom."','".$data->sexe."','".$data->Email."','".$data->userlog."','".$data->pwd."')");
        
            if ($sql){
                $data-> $id = $conn->insert_id;
                exit(json_encode($data));
    
            } else{
    
                exit(json_encode(array('status' => 'error')));
            }

        }
       
  
} */
if ($_SERVER['REQUEST_METHOD']=== 'PUT'){
    if(isset($_GET['id'])){

        $id = $conn-> real_escape_string($_GET['id']);
        $data = json_decode(file_get_contents("php://input"));
        $sql=  $conn->query(" UPDATE users SET nom = '".$data->nom."',prenom= '".$data->prenom."',sexe= '".$data->sexe."',Email ='".$data->Email."',userlog= '".$data->userlog."', pwd= '".$data->pwd."' WHERE id ='$id'");

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
        $sql=  $conn->query(" DELETE FROM users  WHERE id ='$id'");

    if($sql){
        exit(json_encode(array('status'=> 'succes')));

    } else {
        exit(json_encode(array('status'=> 'error')));
    }

    }

}

?>
