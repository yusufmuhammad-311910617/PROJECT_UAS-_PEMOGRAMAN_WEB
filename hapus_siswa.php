<?php
require 'connection.php';
$id_warga = $_GET['id_warga'];
if (isset($id_warga)) {
	if (deleteSiswa($id_warga) > 0) {
		setAlert("Siswa has been deleted", "Successfully deleted", "success");
		header("Location: siswa.php");
	}
} else {
	header("Location: siswa.php");
}
