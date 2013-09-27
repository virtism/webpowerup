<?     
require_once ('vo/org/corlan/VOAuthor.php');
//require_once ('vo/org/corlan/OpenTokSDK.php');
require_once '../../tokbox/OpenTokSDK.php';
//conection info
define( "DATABASE_SERVER", "localhost");
define( "DATABASE_USERNAME", "globalws_site");
define( "DATABASE_PASSWORD", "zw_DWS(X+!OW");
define( "DATABASE_NAME", "globalws_stagegws");
class MyService {

    public function getDepartment() {
        //connect to the database.
        $mysql = mysql_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD);
        mysql_select_db(DATABASE_NAME);
        //retrieve all rows
        $query = "SELECT DISTINCT d_name  FROM support_department ORDER BY d_id";
        $result = mysql_query($query);

        $ret = array();
        while ($row = mysql_fetch_object($result)) {
            $tmp = new VOAuthor();
           if($row->d_name!=''){
           // $tmp->id_aut = $row->d_id;
            $tmp->department_aut = $row->d_name;
            //$tmp->lname_aut = $row->time_stamp;
            $ret[] = $tmp;
           }
        }
        mysql_free_result($result);
        return $ret;
    }
public function getPriority() {
        //connect to the database.
        $mysql = mysql_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD);
        mysql_select_db(DATABASE_NAME);
        //retrieve all rows
        $query = "SELECT * FROM `support_priority`";
        $result = mysql_query($query);

        $ret = array();
        while ($row = mysql_fetch_object($result)) {
            $tmp = new VOAuthor();
           
           // $tmp->id_aut = $row->d_id;
            $tmp->priority_aut = $row->p_priority;
            //$tmp->lname_aut = $row->time_stamp;
            $ret[] = $tmp;
           
        }
        mysql_free_result($result);
        return $ret;
    }
    
    
    public function saveData($author) {
      //  DebugBreak();
        if ($author == NULL)
            return NULL;
        //connect to the database.
        $mysql = mysql_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD);
        mysql_select_db(DATABASE_NAME);
        //save changes
        $query_user_id = "SELECT * FROM `users` WHERE     user_email = '".$author->email."'";
        $result_set = mysql_query($query_user_id);
        $data = mysql_fetch_array($result_set);
       $query = "INSERT INTO `support_tickets` (
                                                `t_id` ,
                                                `t_no` ,
                                                `t_subject` ,
                                                `t_department` ,
                                                `t_priority` ,
                                                `t_body` ,
                                                `t_owner` ,
                                                `t_open_date` ,
                                                `t_close_date` ,
                                                `t_closed` ,
                                                `t_deleted`
                                                )
                                        VALUES (
                                                NULL , 
                                                NULL , 
                                                '".$author->subject."',
                                                '".$author->department_aut."',
                                                '".$author->department_aut."', 
                                                '".$author->description."', 
                                                '".$data['user_id']."',
                                                NULL ,
                                                NULL , 
                                                '0', 
                                                '0')";       
       $result = mysql_query($query);
       $tmp = new VOAuthor();
       $tmp->inserted_id = mysql_insert_id ();
       
       return $tmp;
    }
    public function dologin($author)
    {
       // DebugBreak();
        if ($author == NULL)
            return NULL;  
    
       // $query = "SELECT * FROM room WHERE id = '".$author->room_id."' AND PASSWORD = '".$author->password."'";
       // $result = mysql_query($query);
             $mysql = mysql_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD);
             mysql_select_db(DATABASE_NAME);
            
             $query = "SELECT * from  room WHERE room_rid = '".$author->room_id."' AND password = '".$author->password."'";
                if (!$result = mysql_query($query))
                {
                    die('Error: ' . mysql_error());
                }
                    
          
         
            $tmp = new VOAuthor();
            $ret = array();
            if(mysql_num_rows($result)>0)
            {
                  $tmp->userinfo = 1;
                  $ret[] = $tmp;
            }
            else
            {
                  $tmp->userinfo = 0;
                  $ret[] = $tmp;   
            }
            return $ret; 
    }
    public function checkattendee_options($author)
    {
    // DebugBreak();
        if ($author == NULL)
            return NULL;  
    
       // $query = "SELECT * FROM room WHERE id = '".$author->room_id."' AND PASSWORD = '".$author->password."'";
       // $result = mysql_query($query);
             $mysql = mysql_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD);
             mysql_select_db(DATABASE_NAME);
            
             $query = "SELECT * from  room WHERE room_rid = '".$author->room_id."'";
                if (!$result = mysql_query($query))
                {
                    die('Error: ' . mysql_error());
                }
                    
          
         
            $tmp = new VOAuthor();
            $ret = array();
            //$customers_id = array();
            if(mysql_num_rows($result)>0)
            {
                 $row = mysql_fetch_array($result);
                 $tmp->attendee_option = $row['attendee_options'];
                 $tmp->admin_approvel = $row['approval'];
                 $customers_id  = explode(',',$row['customers']);
                 for($i=0; $i<count($customers_id);$i++)
                 {
                     if($customers_id[$i] == $author->attendee_id)
                     {
                        $tmp->attendee_id = 1; 
                        break;
                     }
                     else
                     {
                        $tmp->attendee_id = 0; 
                     }
                 }
                 $ret[] = $tmp;
            }
            else
            {
                  $tmp->attendee_option = 0;
                  $ret[] = $tmp;   
            }
            return $ret; 
    }
    Public function generateToken($author){
     // DebugBreak();
        $apiObj    = new OpenTokSDK(API_Config::API_KEY, API_Config::API_SECRET);
        $role      = RoleConstants::PUBLISHER; // Or set to the correct role for the user.
        $metadata  =  '<userdata><username>Bob</username><color>Red</color></userdata>';
        //$session = $apiObj->create_session($_SERVER["REMOTE_ADDR"]);
        $tmp = new VOAuthor();
        $ret = array();
        //$session->getSessionId();
        //echo "<br/>";
       // $apiObj->generate_token();
         
        // $tmp->token      = $apiObj->generate_token('1_MX4xMDkxMDc2Mn4xODIuMTg1LjE5OS42OH4yMDEyLTAyLTIzIDA4OjU1OjU4LjcwNDkzNyswMDowMH4wLjk2MTUyNzYyOTM1fg', $role, NULL, $metadata);
         $tmp->token = 'sdgfsadgsad';
         $ret[] = $tmp;
          return $ret; 
    }
}
?>