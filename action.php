<?php
    $server="Localhost";
    $user="root";
    $password="";
    $database="db_register";
    $conn=mysqli_connect($server,$user,$password,$database);
    if(!$conn)
    {
        die("Connection not established");
    }
?>
<?php
    function Entries($conn)
    {
        $sql="SELECT COUNT(*) as entries FROM users";
        $stmt=$conn->prepare($sql);
        $stmt->execute();
        $res=$stmt->get_result();
        $rows=$res->fetch_assoc();
        return $rows;  
    } 
    function showdata($conn){
        $sql="SELECT * FROM users ORDER BY id DESC LIMIT 1";
        $stmt=$conn->prepare($sql);
        $stmt->execute();
        $res=$stmt->get_result();
        $rows=$res->fetch_all(MYSQLI_ASSOC);
        return $rows;
    }
    function isExists($id,$conn){
        $sql="SELECT id FROM users WHERE id=?";
        $stmt=$conn->prepare($sql);
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $res=$stmt->get_result();
        $row=$res->fetch_all(MYSQLI_ASSOC);
        return $row;
    }
    function showdataAll($conn){
        $sql="SELECT * FROM users";
        $stmt=$conn->prepare($sql);
        $stmt->execute();
        $res=$stmt->get_result();
        $rows=$res->fetch_all(MYSQLI_ASSOC);
        return $rows;
    }
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
       $rawData=file_get_contents("php://input");
       $data=json_decode($rawData,true);
       $name=$data["name"];
       $email=$data["email"];
       $dob=$data["dob"];
       $sql="INSERT INTO users(`name`,`email`,`d.o.b`) VALUES(?,?,?)";
       $stmt=$conn->prepare($sql);
       $stmt->bind_param("sss",$name,$email,$dob);
       $stmt->execute();
       $res[]=[
            "status"=>"user added",
       ];
       echo json_encode($res);
    }
    else if($_SERVER["REQUEST_METHOD"]=="GET")
    {
        if(isset($_GET["type"]))
        {
            $res=Entries($conn);
            // print_r($res);
            echo json_encode($res);
        }
        else
        {
            $res=showdataAll($conn);
            echo json_encode($res);
        }
       
    }
    else if($_SERVER["REQUEST_METHOD"]=="PUT")
    {
        $rawData=file_get_contents("php://input");
        $item=json_decode($rawData);
        $name=isset($item->name)?$item->name:NULL;
        $email=isset($item->email)?$item->email:NULL;
        $dob=isset($item->dob)?$item->dob:NULL;
        $id=isset($_GET["id"])?$_GET["id"]:NULL;
        if($name==NULL||$email==NULL||$dob==NULL)
        {
            http_response_code(422);
            echo json_encode(
                [
                    "status"=>"invalid entry",
                ]
            );

        }
        else
        {
               if($id==NULL||!isExists($id,$conn))
               {
                http_response_code(422);
                echo json_encode(
                    [
                        "status"=>"invalid entry",
                    ]
                );
               }
               else
               {
                 $id=$_GET["id"];
                $sql="UPDATE users SET `name`=?,`email`=?,`d.o.b`=?,`updated_at`=CURRENT_TIMESTAMP() WHERE id=?";
                $stmt=$conn->prepare($sql);
                $stmt->bind_param("sssi",$name,$email,$dob,$id);
                $stmt->execute();
                http_response_code(200);
                echo json_encode(
                    [
                    "status"=>"User updated",
                    ]
                );
               }
        }
    }
    else if($_SERVER["REQUEST_METHOD"]=="DELETE")
    {
        $rawData=file_get_contents("php://input");
        $data=json_decode($rawData,true);
        $id=$data["id"];
        $sql="DELETE FROM users where id=?";
        $stmt=$conn->prepare($sql);
        $stmt->bind_param("i",$id);
        $stmt->execute();
        http_response_code(200);
        echo json_encode(
            [
                "status"=>"User Deleted",
            ]
            );
    }
?>