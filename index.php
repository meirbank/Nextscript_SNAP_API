<?php
require_once "nxs-api/nxs-api.php";
//ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
require_once "inc/nxs-functions.php"; 
//require_once "inc-cl/vk.api.php"; 
 
require_once "nxs-api/nxs-http.php"; 


if ( empty( $_POST["platform"] ) ){ //$argv[1];
  $platform = NULL;
} else {
  $platform = $_POST["platform"];
}

if ( empty( $_POST["user"] ) ) {
  $user = NULL;
} else {
  $user = $_POST["user"]; //$argv[2];
}


if ( empty( $_POST["pass"] ) ){
  $pass = NULL;
} else {
  $pass = $_POST["pass"]; //$argv[3];
}




if ( empty( $_POST["message"] ) ){
  $msg = NULL;/Users/meir/Desktop/PRODUCTION/phpapi/index.php
} else {
  $msg = $_POST["message"]; //$argv[4];
}



if ( empty( $_POST["page"] ) ){
 $pageID = NULL;
} else {
 $pageID = $_POST["page"]; //$argv[5];
}


if ( empty( $_POST["board"] ) ){
  $board = NULL;
} else {
  $board = $_POST["board"]; //$argv[6];
}



if ( empty( $_POST["vktoken"] ) ){
  $vkAppAuthToken= NULL;
} else {
  $vkAppAuthToken= $_POST["vktoken"]; //$argv[7];
}



if ( empty( $_POST["code"] ) ){
  $securityCode = NULL;
} else {
  $securityCode = $_POST["code"];
}


//!empty($_POST["board"]

if ($securityCode == ''){

     if ($platform == 'googleplus'){
      $nt = new nxsAPI_GP();
      if (strpos($pageID,'.jpg') !== false || strpos($pageID,'.png') !== false) {
          $pageID = array('img'=>$pageID); 
      }
      if ($board == 'undefined' || $board == NULL){
        $board = '';
      }
      $loginError = $nt->connect($user, $pass);     
      if (!$loginError){
        {
          $result = $nt -> postGP($msg, $pageID, $board);
        } 
      } else {

        echo '{"error":"'.$loginError.'"}'; 
        die();
      }
      
      if (!empty($result) && is_array($result) && !empty($result['postURL'])){

       		 	echo '{"url":"'.$result['postURL'].'", "id":"'.$result['postID'].'" }'; 
            //die();

      } else {
        //prr($result);
          echo '{"error":"Invalid input"}';   
          die();    
      }


      
    } elseif($platform == ''){

    } elseif($platform == 'vk'){
      $postoptions = array();
      $message = array();
      $message['pText'] = $msg;
      if (!empty($pageID) ){
        if (strpos($pageID, "jpg") == false && strpos($pageID, "png") == false){
          $message['imageURL'] = $pageID;
        } else {
          $message['videoURL'] = $pageID;
        }
      }
       $postoptions['uName'] = $user;
       $postoptions['uPass'] = $pass;
       $postoptions['vkPgID'] = $board;
       $postoptions['vkAppAuthToken'] = $vkAppAuthToken;
       $ntToPost = new nxs_class_SNAP_VK(); 
      //$ret = $ntToPost->doPostToNT($postoptions, $message); 
      //prr($ret);
      
          $result = $ntToPost->doPostToNT($postoptions, $message); 
      if (!empty($result) && is_array($result) && !empty($result['postURL'])) {
              echo '{"url":"'.$result['postURL'].'", "id":"'.$result['postID'].'" }'; 
              //die();
              //echo prr($message);
        } else {
            echo '{"error":"Invalid input"}';   
            die();
        }
        
    } elseif($platform == 'pinterest'){
     /* $message['pText'] = 'Test Post';
  $postoptions['pnUName'] = '';
  $postoptions['pnPass'] = '';*/

      $imgURL = $pageID; 

      $nt = new nxsAPI_PN();
      $loginError = $nt->connect($user, $pass);     
      if (!$loginError){
        {
          $result = $nt -> post($msg, $imgURL, 'https://example.com', $board);
        } 
      }else{

        echo '{"error":"'.$loginError.'"}'; 
        die();
      }
      
      if (!empty($result) && is_array($result) && !empty($result['postURL'])) {
         		 	echo '{"url":"'.$result['postURL'].'", "id":"'.$result['postID'].'" }'; 
              //die();
        } else {
            echo '{"error":"Invalid input"}';     
            die();
        }



    }
    die();
  } else {
    echo '{"error":"-------- invalid security code!!!"}'; 
    die();
  }

?>
