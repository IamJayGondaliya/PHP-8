<?php

    class Config {

        //Attributes
        private $a = 10;
        private $b = 5;

        private $host = "127.0.0.1";
        private $username = "root";
        private $password = "";
        private $db_name = "php-8";
        private $table_name = "data";
        private $user_table = "users";
        private $media_table = "media";

        private $conn;

        //Methods
        public function sum() {
            $sum = $this->a + $this->b;

            echo "Sum: " . $sum;
        }

        public function __construct() {

            $this->conn = mysqli_connect($this->host,$this->username,$this->password,$this->db_name);

            if($this->conn) {
                // echo "Connected !!";
            }
            else {
                echo "Not connected !!";
            }

        }

        public function insert($name,$age,$course) {

            $query = "INSERT INTO $this->table_name(name,age,course) VALUES('$name',$age,'$course')";

            $res = mysqli_query($this->conn,$query); // bool

            return $res;
        }

        public function register_user($name,$email,$psw) {
            $query = "INSERT INTO $this->user_table(name,email,psw) VALUES('$name','$email','$psw')";

            $res = mysqli_query($this->conn,$query);

            return $res;
        }

        public function login($email,$psw) {

            $user = $this->fetch_user_by_email($email);

            if(mysqli_num_rows($user) == 1) {
                
                $user_data = mysqli_fetch_assoc($user);

                $is_logged_in = password_verify($psw,$user_data['psw']);

                $data = array();

                $data['status'] = $is_logged_in;

                if($is_logged_in) {
                    $data['user_data'] = json_encode($user_data);
                }
                else {
                    $data['status'] = "Login failled... !!";
                }

                return $data;

            }
            else {
                    return "User doesn't exist !!";
            }
        }

        private function fetch_user_by_email($email) {

            $query = "SELECT * FROM $this->user_table WHERE email='$email'";

            $user = mysqli_query($this->conn,$query);

            return $user;
        }

        public function getAllRecords() {

            $query = "SELECT * FROM $this->table_name";

            return mysqli_query($this->conn,$query);   //Object    => records (associative array)

        }        

        public function fetch_single_record($id) {

            $query = "SELECT * FROM $this->table_name WHERE id=$id";

            return mysqli_query($this->conn,$query);

        }

        public function delete($id) {

            $query = "DELETE FROM $this->table_name WHERE id=$id";

            $fetch_single_record = $this->fetch_single_record($id);

            if(mysqli_num_rows($fetch_single_record) == 1) {
                mysqli_query($this->conn,$query);
                return true;
            }
            else {
                return false;
            }

        }

        public function update($id,$name,$age,$course) {
            
            $query = "UPDATE $this->table_name SET name='$name', age=$age, course='$course' WHERE id=$id";

            $fetch_single_record = $this->fetch_single_record($id);

            if(mysqli_num_rows($fetch_single_record) == 1) {
                mysqli_query($this->conn,$query);
                return "$id updated...";
            }
            else {
                return "$id failled to update...";
            }


        }

        public function insert_media($name,$path) {

            $query = "INSERT INTO $this->media_table(name,path) VALUES('$name','$path')";

            return mysqli_query($this->conn,$query);

        }

        private function fetch_single_media($id) {

            $query = "SELECT * FROM $this->media_table WHERE id=$id";

            return mysqli_query($this->conn,$query);

        }

        public function getAllMedia() {

            $query = "SELECT * FROM $this->media_table";

            return mysqli_query($this->conn,$query);    //Object    => mysqli_fetch_assoc

        }

        public function delete_media($id) {

            $record = $this->fetch_single_media($id);


            if(mysqli_num_rows($record) == 1) {

                $data = mysqli_fetch_assoc($record);
                $file_path = $data['path'];

                $query = "DELETE FROM $this->media_table WHERE id=$id";

                if(mysqli_query($this->conn,$query) && unlink($file_path)) {                    
                    return "Deleted...";
                }
                else {
                    return "Failled...";
                }
            
            }
            else {
                return "Media does not exist...";
            }

        }


    }   
     
?>