<?
@session_start();
/////////////////////////////////Start admin Model/////////////////////////////////////////////////////////
   class UserModel extends CI_Model{
         function UserModel(){
					 parent::__construct();
			}//end function
			function AddUserSubmit($value){
				//print_r($_POST);
				 if( isset($_POST['username'])){
					$username = $value['username'];
					$password = $value['password'];
					$phone = $value['phone'];
					$email = $value['email'];
					$_POST='';
					$q = "insert into registration set  name = '$username',password = '$password', phone = '$phone',Email='$email'";
					mysql_query($q);
					return true;
					}
				}
				function login($value){
				if(isset($_POST['password']) && isset($_POST['email'])){
				$password = $value['password'];
				$email = $value['email'];
		    	 $rs = mysql_query("select * from registration where Email = '$email' and password ='$password'");
				  if (mysql_num_rows($rs)>0){
				   	 // $row = mysql_fetch_object($rs);
					 //  $_SESSION['userId']=$row->ID;
					return 'yes';
						  }
				  else{
				      return 'no';
					  }
				}
		 }//end funcyion login
   }

?>