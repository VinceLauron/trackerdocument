<?php
session_start();
include 'db_connect.php';

if (isset($_GET['action']) && $_GET['action'] == 'save_files') {
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $folder_id = isset($_POST['folder_id']) ? $_POST['folder_id'] : '';
    $fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $is_public = isset($_POST['is_public']) ? 1 : 0;

    if (empty($id)) {
        // Insert new file
        if ($_FILES['upload']['tmp_name'] != '') {
            $fname = strtotime(date('Y-m-d H:i')) . '_' . $_FILES['upload']['name'];
            $move = move_uploaded_file($_FILES['upload']['tmp_name'], 'assets/uploads/' . $fname);

            if ($move) {
                $file = $_FILES['upload']['name'];
                $file = explode('.', $file);
                $chk = $conn->query("SELECT * FROM files WHERE SUBSTRING_INDEX(name, ' ||', 1) = '$file[0]' AND folder_id = '$folder_id' AND file_type = '$file[1]'");

                if ($chk->num_rows > 0) {
                    $file[0] = $file[0] . ' ||' . ($chk->num_rows);
                }

                $file_number = generateUniqueFileNumber($conn);

                $data = "name = '$file[0]', fullname = '$fullname', folder_id = '$folder_id', description = '$description', user_id = '".$_SESSION['login_id']."', file_type = '$file[1]', file_path = '$fname', is_public = $is_public, file_number = '$file_number'";
                $save = $conn->query("INSERT INTO files SET $data");

                if ($save) {
                    // Return JSON response with success status and new data
                    echo json_encode(array('status' => 1, 'data' => $data));
                    exit;
                }
            }
        }
    } else {
        // Update existing file
        $data = "fullname = '$fullname', description = '$description', is_public = $is_public";
        $save = $conn->query("UPDATE files SET $data WHERE id = $id");

        if ($save) {
            // Return JSON response with success status and updated data
            echo json_encode(array('status' => 1, 'data' => $data));
            exit;
        }
    }

    // Return JSON response with failure status if saving fails
    echo json_encode(array('status' => 0, 'msg' => 'Failed to save file.'));
    exit;
}

function generateUniqueFileNumber($conn) {
    $file_number = sprintf("%'012d", mt_rand(0, 999999999999));
    $chk = $conn->query("SELECT * FROM files WHERE file_number = '$file_number'");
    
    while ($chk->num_rows > 0) {
        $file_number = sprintf("%'012d", mt_rand(0, 999999999999));
        $chk = $conn->query("SELECT * FROM files WHERE file_number = '$file_number'");
    }

    return $file_number;
}

class Action {
    private $db;

    public function __construct() {
        ob_start();
        include 'db_connect.php';
        $this->db = $conn;
    }

    function __destruct() {
        $this->db->close();
        ob_end_flush();
    }

    function login() {
        extract($_POST);
        $qry = $this->db->query("SELECT * FROM users where username = '".$username."' and password = '".$password."'");
        if ($qry->num_rows > 0) {
            foreach ($qry->fetch_array() as $key => $value) {
                if ($key != 'password' && !is_numeric($key))
                    $_SESSION['login_'.$key] = $value;
            }
            return 1;
        } else {
            return 2;
        }
    }

    function logout() {
        session_destroy();
        foreach ($_SESSION as $key => $value) {
            unset($_SESSION[$key]);
        }
        header("location:login.php");
    }

    function save_folder() {
        extract($_POST);
        $data = " name ='".$name."' ";
        $data .= ", parent_id ='".$parent_id."' ";
        if (empty($id)) {
            $data .= ", user_id ='".$_SESSION['login_id']."' ";

            $check = $this->db->query("SELECT * FROM folders where user_id ='".$_SESSION['login_id']."' and name  ='".$name."'")->num_rows;
            if ($check > 0) {
                return json_encode(array('status'=>2,'msg'=> 'Folder name already exist'));
            } else {
                $save = $this->db->query("INSERT INTO folders set ".$data);
                if ($save)
                    return json_encode(array('status'=>1));
            }
        } else {
            $check = $this->db->query("SELECT * FROM folders where user_id ='".$_SESSION['login_id']."' and name  ='".$name."' and id !=".$id)->num_rows;
            if ($check > 0) {
                return json_encode(array('status'=>2,'msg'=> 'Folder name already exist'));
            } else {
                $save = $this->db->query("UPDATE folders set ".$data." where id =".$id);
                if ($save)
                    return json_encode(array('status'=>1));
            }
        }
    }

    function delete_folder() {
        extract($_POST);
        $delete = $this->db->query("DELETE FROM folders where id =".$id);
        if ($delete)
            echo 1;
    }

    function delete_file() {
        extract($_POST);
        $path = $this->db->query("SELECT file_path from files where id=".$id)->fetch_array()['file_path'];
        $delete = $this->db->query("DELETE FROM files where id =".$id);
        if ($delete) {
            unlink('assets/uploads/'.$path);
            return 1;
        }
    }

    function get_file_history() {
        extract($_POST);
        $data = array();
        
        // Query to get file details based on file number
        $files = $this->db->query("SELECT * FROM files WHERE file_number = '$file_no'");
        
        if ($files->num_rows <= 0) {
            // Return status 2 if no file found with the given file number
            return json_encode(array('user_id' => 2));
        } else {
            $files = $files->fetch_array();
            $data[] = array(
                'file_number' => $files['file_number'],
                'fullname' => $files['fullname'],
                'description' => $files['description'],
                'date_created' => date("M d, Y h:i A", strtotime($files['date_created']))
            );
            
            // Query to get file tracking history
            $history = $this->db->query("SELECT * FROM file_tracks WHERE file_id = {$files['id']}");
            
            while ($row = $history->fetch_assoc()) {
                $row['date_created'] = date("M d, Y h:i A", strtotime($row['date_created']));
                $data[] = $row;
            }
            
            // Return the file details and history as JSON
            return json_encode($data);
        }
    }
    function save_files() {
        extract($_POST);
        if (empty($id)) {
            if ($_FILES['upload']['tmp_name'] != '') {
                $fname = strtotime(date('Y-m-d H:i')).'_'.$_FILES['upload']['name'];
                $move = move_uploaded_file($_FILES['upload']['tmp_name'],'assets/uploads/'.$fname);

                if ($move) {
                    $file = $_FILES['upload']['name'];
                    $file = explode('.', $file);
                    $chk = $this->db->query("SELECT * FROM files where SUBSTRING_INDEX(name,' ||',1) = '".$file[0]."' and folder_id = '".$folder_id."' and file_type='".$file[1]."'");
                    if ($chk->num_rows > 0) {
                        $file[0] = $file[0] .' ||'.($chk->num_rows);
                    }

                    $file_number = $this->generateUniqueFileNumber();

                    $data = " name = '".$file[0]."' ";
                    $data .= ", file_number = '".$file_number."' ";
                    $data .= ", fullname = '".$fullname."' ";
                    $data .= ", folder_id = '".$folder_id."' ";
                    $data .= ", description = '".$description."' ";
                    $data .= ", user_id = '".$_SESSION['login_id']."' ";
                    $data .= ", file_type = '".$file[1]."' ";
                    $data .= ", file_path = '".$fname."' ";
                    if (isset($is_public) && $is_public == 'on')
                        $data .= ", is_public = 1 ";
                    else
                        $data .= ", is_public = 0 ";

                    $save = $this->db->query("INSERT INTO files set ".$data);
                    if ($save)
                        return json_encode(array('status'=>1));
                }
            }
        } else {
            $data = " description = '".$description."' ";
            if (isset($is_public) && $is_public == 'on')
                $data .= ", is_public = 1 ";
            else
                $data .= ", is_public = 0 ";
            $save = $this->db->query("UPDATE files set ".$data." where id=".$id);
            if ($save)
                return json_encode(array('status'=>1));
        }
        return json_encode(array('status' => 0, 'msg' => 'Failed to save file.'));
    }

    private function generateUniqueFileNumber() {
        $file_number = sprintf("%'012d", mt_rand(0, 999999999999));
        $chk = $this->db->query("SELECT * FROM files WHERE file_number = '$file_number'");

        while ($chk->num_rows > 0) {
            $file_number = sprintf("%'012d", mt_rand(0, 999999999999));
            $chk = $this->db->query("SELECT * FROM files WHERE file_number = '$file_number'");
        }

        return $file_number;
    }

    function file_rename() {
        extract($_POST);
        $file[0] = $name;
        $file[1] = $type;
        $chk = $this->db->query("SELECT * FROM files where SUBSTRING_INDEX(name,' ||',1) = '".$file[0]."' and folder_id = '".$folder_id."' and file_type='".$file[1]."' and id != ".$id);
        if ($chk->num_rows > 0) {
            $file[0] = $file[0] .' ||'.($chk->num_rows);
        }
        $save = $this->db->query("UPDATE files set name = '".$name."' where id=".$id);
        if ($save) {
            return json_encode(array('status'=>1,'new_name'=>$file[0].'.'.$file[1]));
        }
    }

    function save_user() {
        extract($_POST);
        $data = " name = '$name' ";
        $data .= ", username = '$username' ";
        $data .= ", password = '$password' ";
        $data .= ", type = '$type' ";
        if (empty($id)) {
            $save = $this->db->query("INSERT INTO users set ".$data);
        } else {
            $save = $this->db->query("UPDATE users set ".$data." where id = ".$id);
        }
        if ($save) {
            return 1;
        }
    }
}
?>
