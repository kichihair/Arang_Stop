<?PHP
# menyemak kewujudan data GET
if(!empty($_GET))
{
    # Memanggil fail connection dari folder luaran
    include ('../connection.php');
    
    # Memanggil data GET
    $table=$_GET['table'];
    $field=$_GET['field'];
    $id=$_GET['id'];
    
    # Arahan menghapuskan data
    $sql_remove="delete from $table where $field='$id'";
    
    # melaksanakan proses hapus rekod dalam syarat IF
    if(mysqli_query($condb,$sql_remove))
    {
        # Proses menghapus rekod berjaya
        echo"<script>alert('Remove Data Successfully');
        window.history.back();</script>";
    }
    else
    {
        # Proses menghapuskan rekod gagal
        echo"<script>alert('Remove Data Failed');
        window.history.back();</script>";
    }
}
?>