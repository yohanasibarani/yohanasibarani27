<?php
session_start();
//buat koneksi ke database
$konek = mysqli_connect("localhost","root","","pembayaran_iuran");

//fungsi untuk tambah data baru
if(isset($_POST['addBaru'])){
    $namaKeluarga = $_POST['namaKeluarga'];
    $notelp = $_POST['notelp'];
    $totalbyr = $_POST['totalbyr'];
    $alamat = $_POST['alamat'];
    $keterangan = $_POST['keterangan'];

    $addtotable = mysqli_query($konek,"insert into keluarga (nama, no_telp, total_bayar, alamat, keterangan) 
    values ('$namaKeluarga','$notelp','$totalbyr','$alamat','$keterangan')");
    if($addtotable){
        header('location:index.php');
    }else { 
        echo "Gagal";
        header('location:index.php');
    }
};

//fungsi untuk tambah pembayaran
if(isset($_POST['addBaruu'])){
    $keluarganya = $_POST['keluarganya'];
    $jlhbyr = $_POST['jlhbyr'];
    $penerima = $_POST['penerima'];

    $cekbyr = mysqli_query($konek, "select * from keluarga where id_keluarga='$keluarganya'");
    $ambildata = mysqli_fetch_array($cekbyr);

    $bayarterbaru  = $ambildata['total_bayar'];
    $bayartambahjlhbyr = $bayarterbaru + $jlhbyr;

    $addto = mysqli_query($konek, "insert into bayar (id_keluarga, jlh_bayar, penerima) values ('$keluarganya','$jlhbyr','$penerima')");
    //update jumlah bayar ketika terjadi pembayaran 
    $update = mysqli_query($konek,"update keluarga set total_bayar= $bayartambahjlhbyr where id_keluarga = $keluarganya");
    if($addto&&$update){
        header('location:bayar.php');
    }else { 
        echo "Gagal";
        header('location:bayar.php');
    }
}

//edit data     
if(isset($_POST['updateBaru'])){
    $idk = $_POST['idk'];
    $namaKeluarga = $_POST['namaKeluarga'];
    $notelp = $_POST['notelp'];
    $alamat = $_POST['alamat'];
    $keterangan = $_POST['keterangan'];

    $apdet = mysqli_query($konek, "update keluarga set nama = '$namaKeluarga', no_telp = '$notelp', alamat = '$alamat', keterangan = '$keterangan' where id_keluarga = '$idk'");
    if($apdet){
        header('location:index.php');
    }else { 
        echo "Gagal";
        header('location:index.php');
    }
}

//hapus data
if(isset($_POST['hapusBaru'])){
    $idk = $_POST['idk'];

    $hapus = mysqli_query($konek, "delete from keluarga where id_keluarga='$idk'");
    if($hapus){
        header('location:index.php');
    }else { 
        echo "Gagal";
        header('location:index.php');
    }
}

?>