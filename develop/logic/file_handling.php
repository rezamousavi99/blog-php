<?php
    declare(strict_types=1);

    // Check file is existed if not create file, read file
    class File {
        public $directory_name;
        public $files_array = array();
        public $all_data = array();

        function __construct(string $dir_name){
            $this->directory_name = $dir_name;
        }

        function is_file_exist(string $file_name){
            $dh = opendir($this->directory_name);

            if($dh){
                while($file = readdir($dh)){
                    $this->files_array[] = $file;
                }
                if (in_array($file_name, $this->files_array)){
                    closedir($dh);
                    return true;
                }
                closedir($dh);
                return false;
            }
        }

        function create_file(string $file_name){
            $fp = fopen($this->directory_name . "/" . $file_name, "a");
            fclose($fp);
        }

        function read_file(string $file_name){
            $f = fopen($this->directory_name . "/" . $file_name, "r");

            // read first line just to ignore it
            fgetcsv($f);

            // read the rest lines and append each line as array in another array
            while(!feof($f)){
                $data_row = fgetcsv($f);
                if ($data_row){
                    $this->all_data[] = $data_row;
                }
            }
            fclose($f);

            return $this->all_data;
        }   

        function write_data(string $file_name, array $data){
            $fp = fopen($this->directory_name . "/" . $file_name, "a");

            fputcsv($fp, $data);
            fclose($fp);
        }

        # delete one data row
        function delete_data($id, $file_name){
            $existed_file_loc = $this->directory_name."/".$file_name;
            $purename = pathinfo($file_name, PATHINFO_FILENAME);;
            $temp_file_loc = $this->directory_name."/".$purename."_new.csv";

            //'../csv/blogs.csv'
            $table = fopen($existed_file_loc,'r');
            //'../csv/blogs_new.csv'
            $temp_table = fopen($temp_file_loc,'w');

            
                while (($data = fgetcsv($table, 1000)) !== FALSE){
                    if(reset($data) == $id){
                        session_start();
                        if($_SESSION["loggedin_user_data"][0] != $data[3]){
                            die("<h2>you are not allowed to do such thing...</h2>");
                        }
                        
                        continue;
                    }
                    fputcsv($temp_table,$data);
                }
                fclose($table);
                fclose($temp_table);
                rename($temp_file_loc, $existed_file_loc);
        }

        function update_data($id, $file_name, $new_data){

            $existed_file_loc = $this->directory_name."/".$file_name;
            $purename = pathinfo($file_name, PATHINFO_FILENAME);;
            $temp_file_loc = $this->directory_name."/".$purename."_new.csv";

            //'../csv/blogs.csv'
            $table = fopen($existed_file_loc,'r');
            //'../csv/blogs_new.csv'
            $temp_table = fopen($temp_file_loc,'w');
            

            // echo $user_id;
                while (($data = fgetcsv($table, 1000)) !== FALSE){
                    if(reset($data) == $id){ // this is if you need the first column in a row
                        fputcsv($temp_table, $new_data);
                        continue;
                    }
                    fputcsv($temp_table,$data);
                }
                fclose($table);
                fclose($temp_table);
                rename($temp_file_loc, $existed_file_loc);
        }
    }

    // $c = new File("../csv");
    // var_dump($c->is_file_exist("users.csv"));
    
    // $c->create_file("blogs.csv");

    // echo '<pre>';
    // var_dump($c->read_file("blogs.csv"));
    // echo '</pre>';



?>