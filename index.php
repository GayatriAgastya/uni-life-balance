<?php
$host   = "localhost";
$user   = "root";
$pass   = "";
$db     = "crudaction";

$connection = mysqli_connect($host, $user, $pass, $db);

// if (!$connection) {
//     echo "failed";
// } else {
//     echo "success";
// }

$nim        = "";
$name       = "";
$address    = "";
$major      = "";
$success    = "";
$error      = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){

    $id     =$_GET['id'];
    $sql1   ="delete from student where id = '$id'";
    $q1     =mysqli_query($connection,$sql1);
    if($q1) 
    {
        $success = "data deleted successfully";
    }
    else
    {
            $error = "data failed to delete";
    }


}
if ($op == 'edit') {
    $id = $_GET['id'];
    $sql1 = "select * from student where id = '$id' ";
    $q1 = mysqli_query($connection, $sql1);
    $r1 = mysqli_fetch_array($q1);
    $nim = $r1['NIM'];
    $name =  $r1['Name'];
    $address = $r1['Address'];
    $major = $r1['Major'];

    if ($nim == '') {
        $error = "Data Not Found";
    }
}

if (isset($_POST['submit'])) {
    $nim    = $_POST['nim'];
    $name   = $_POST['name'];
    $address = $_POST['address'];
    $major  = $_POST['Major'];

    if ($nim && $name &&  $address && $major) {
        if ($op == 'edit') { //untuk update
            $sql1   = "update student set NIM ='$nim',Name= '$name',Address = '$address',Major = '$major' where '$id'";
            $q1  =    mysqli_query($connection, $sql1);
            if ($q1) {
                $success = "data updated successfully";
            } else {
                $error = "data failed to update";
            }
        } else { //untuk insert
            $sql1 = "insert into student (nim ,name,address,major) values('$nim','$name','$address','$major')";
            $q1     =  mysqli_query($connection, $sql1);

            if ($q1) {
                $success = "successfully entered new data";
            } else
                $error = "Failed to enter data";
        }
    }
} else {
    $error = "Please Enter the data";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .mx-auto {
            width: 800px;
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="max-auto">

        <div class="card">
            <div class="card-header">
                Create / Edit Data
            </div>
            <div class="card-body">
                <?php
              
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                
                }
                ?>

                <?php
                if ($success) {
                ?>
                    <div class="alert alert-sucess" role="alert">
                        <?php echo $success ?>
                    </div>
                <?php
                }
                ?>

                <form action="" method="post">
                    <div class="mb-3 row">
                        <label for="NIM" class="col-sm-2 col-form-label">NIM</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nim" name="nim" value="<?php echo $nim ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="Name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="Name" name="name" value="<?php echo $name ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="Address" class="col-sm-2 col-form-label">Address</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control " id="Address" name="address" value="<?php echo $address ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="Major" class="col-sm-2 col-form-label">Major</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="Major" id="major">
                                <option value="">-Choose Major-</option>
                                <option value="Computer Sciecne" <?php if ($major == "Computer Science") echo "selected" ?>>Computer Sciecne</option>
                                <option value="Marketing Communication" <?php if ($major == "Marketing Communication") echo "selected" ?>>Marketing Communication</option>
                            </select>
                        </div>
                    </div>
                    <div class="col12">
                        <input type="Submit" name="submit" value="Save Data" class="btn btn-primary" />

                    </div>


                </form>
            </div>

        </div>
    </div>

    <div class="card">
        <div class="card-header text-white bg-secondary">
            Student Data
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">NIM</th>
                        <th scope="col">Name</th>
                        <th scope="col">Address</th>
                        <th scope="col">Major</th>
                        <th scope="col">Action</th>
                    </tr>
                <tbody>
                    <?php
                    $sql2 = "select * from student order by ID desc";
                    $q2    = mysqli_query($connection, $sql2);
                    $sort   = 1;
                    while ($r2 = mysqli_fetch_array($q2)) {
                        $id = $r2['ID'];
                        $nim = $r2['NIM'];
                        $name = $r2['Name'];
                        $address = $r2['Address'];
                        $major =    $r2['Major'];
                    ?>
                        <tr>
                            <th scope="row"> <?php echo $sort++ ?> </th>
                            <td scope="row"> <?php echo $nim ?></td>
                            <td scope="row"> <?php echo $name ?></td>
                            <td scope="row"> <?php echo $address ?></td>
                            <td scope="row"> <?php echo $major ?></td>
                            <td scope="row">
                                <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                <a href="index.php?op=delete&id=<?php echo $id?>"onclick = "return confirm('Do you want to delete this data?')"><button type="button" class="btn btn-danger">Delete</button></a></a>
                                
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
                </thead>


            </table>


            </form>
        </div>
    </div>

    </div>

</body>

</html>