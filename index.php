<?php
// Create database connection using config file
include_once("config.php");

// Fetch all users data from database
$result = mysqli_query($mysqli, "SELECT * FROM barang ORDER BY id DESC");
?>

<html>
<head>    
    <title>Homepage</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>

<body>
<?php
if (isset($_POST['submit'])) {
	cari($_POST['keyword'], $mysqli);
}
?>
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="exampleModalLongTitle">EDIT</h5>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr>
                        <th>
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter" title="Add New User">
                                TAMBAHKAN BARANG
                            </button>
                        </th>
                        <th colspan="4">
                        	<form method="post">
                        	<div class="input-group mb-3">
                        		<input type="text" class="form-control" placeholder="keyword" aria-label="Recipient's username" aria-describedby="basic-addon2" name="keyword" value="<?php if(isset($_GET['keyword'])) { echo $_GET['keyword']; } ?>">
                        		<div class="input-group-append">
                        			<input type="submit" class="btn btn-primary" name="submit" value="Cari">
                            	</div>
                            </div>
                        	</form>
                        </th>
                    </tr>
                    <tr>
                        <th>NAMA BARANG</th>
                        <th>HARGA BARANG</th>
                        <th>HARGA JUAL</th>
                        <th>STOK</th>
                        <th>UPDATE</th>
                    </tr>
                    <?php
                    while($user_data = mysqli_fetch_array($result)) {
                        ?>
                        <tr>
                            <td>
                                <?php print $user_data['nama_barang'] ?>
                            </td>
                            <td>
                                <?php print $user_data['harga_barang'] ?>
                            </td>
                            <td>
                                <?php print $user_data['harga_jual'] ?>
                            </td>
                            <td>
                            	<?php print $user_data['stok'] ?>
                            </td>
                            <td>
                                <a class="btn btn-success btn-sm" href="?edit&id=<?php print $user_data['id'] ?>">Ubah</a> 
                                <a class="btn btn-danger btn-sm" href="?hapus&id=<?php print $user_data['id'] ?>">Hapus</a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
    </div>
<?php
function cari($keyword, $mysqli) {
	if (isset($keyword)) {
		$cari = $keyword;
		$query = "SELECT * FROM barang WHERE nama_barang like '%".$cari."%' OR harga_barang like '%".$cari."%' OR harga_jual like '%".$cari."%' OR stok '%".$cari."%' ORDER BY id ASC";
	} else {
		$query = "SELECT * FROM barang ORDER BY id ASC";
	}
	$result = mysqli_query($mysqli, $query);
	if (!$result) {
		die("Query Error : ".mysqli_errno($mysqli)." - ".mysqli_error($mysqli));
	}
	while ($row = mysqli_fetch_array($result)) {
		?>
		<table>
			<tr>
				<td>
					<?php print $row['nama_barang'] ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php print $row['harga_barang'] ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php print $row['harga_jual'] ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php print $row['stok'] ?>
				</td>
			</tr>
		</table>
		<?php
	}
}
?>
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">TAMBAHKAN BARANG</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
            <form method="post" name="form1">
                <tr> 
                    <td>
                        <input class="form-control" type="text" name="nama_barang" placeholder="Nama Barang">
                    </td>
                </tr>
                <tr> 
                    <td>
                        <input class="form-control" type="text" name="harga_barang" placeholder="Harga Barang">
                    </td>
                </tr>
                <tr> 
                    <td>
                        <input class="form-control" type="text" name="harga_jual" placeholder="Harga Jual">
                    </td>
                </tr>
                <tr>
                	<td>
                		<input class="form-control" type="text" name="stok" placeholder="Stok">
                	</td>
                </tr>
                <tr> 
                    <td colspan="2">
                        <input style="width:100%;" class="btn btn-success" type="submit" name="Submit" value="Add">
                    </td>
                </tr>
            </table>
      </div>
    </div>
  </div>
</div>
<div class="contanier" style="padding:20px;">
    <?php

    // Check If form submitted, insert form data into users table.
    if(isset($_POST['Submit'])) {
        $nama_barang = $_POST['nama_barang'];
        $harga_barang = $_POST['harga_barang'];
        $harga_jual = $_POST['harga_jual'];
        $stok = $_POST['stok'];
        $result = mysqli_query($mysqli, "INSERT INTO barang(nama_barang,harga_barang,harga_jual,stok) VALUES('$nama_barang','$harga_barang','$harga_jual', $stok)");
        ?>
        <meta http-equiv="refresh" content="0;index.php"/>
        <?php
    }
    if(isset($_GET['hapus'])) {
    	$id = $_GET['id'];
    	$result = mysqli_query($mysqli, "DELETE FROM barang WHERE id=$id");
    	?>
    	<meta http-equiv="refresh" content="0;index.php"/>
    	<?php
    }
    if (isset($_GET['edit'])) {
    	@$id = $_POST['id'];
    	@$nama_barang = $_POST['nama_barang'];
        @$harga_barang = $_POST['harga_barang'];
        @$harga_jual = $_POST['harga_jual'];
        @$stok = $_POST['stok'];
        $result = mysqli_query($mysqli, "UPDATE barang SET nama_barang='$nama_barang',harga_barang='$harga_barang',harga_jual='$harga_jual',stok=$stok WHERE id=$id");
        $id1 = $_GET['id'];
    
    $result1 = mysqli_query($mysqli, "SELECT * FROM barang WHERE id=$id1");
    
    while($user_data = mysqli_fetch_array($result1)) {
    	$nama_barang1 = $user_data['nama_barang'];
        $harga_barang1 = $user_data['harga_barang'];
        $harga_jual1 = $user_data['harga_jual'];
        $stok1 = $user_data['stok'];
    }
    ?>
    <form method="post">
    	<input type="text" name="nama_barang" value="<?php print $nama_barang1;?>">
    	<input type="text" name="harga_barang" value="<?php print $harga_barang1;?>">
    	<input type="text" name="harga_jual" value="<?php print $harga_jual1;?>">
    	<input type="text" name="stok" value="<?php print $stok1;?>">
    	<input type="hidden" name="id" value="<?php print $_GET['id'];?>">
    	<input type="submit" value="Update">
    </form>
    <?php
    }
    ?>
</div>
</body>
</html>