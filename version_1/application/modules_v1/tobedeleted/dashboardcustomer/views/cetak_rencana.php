
<br>
<center>
    <h2>
        RENCANA PENAGIHAN
    </h2>
    <h2>Tanah Kavling Desa Kedungdawa</h2>
    <h4>Update Tanggal : <?=tgl_indo(date('Y-m-d'));?></h4>
</center>



  
<div class="row">
    <div class="col-md-12">
    <table class="table table-striped table-bordered">
        <tr>
            <td width="3%" align="center">No</td>
            <td width="7%" align="center">Kode Kav</td>
            <td width="15%" align="center">Nama Customer</td>
            <td width="12%" align="center">Terakhir Bayar</td>
            <td width="10%" align="center">Bayar</td>
            <td width="10%" align="center">Sales</td>
            <td width="10%" align="center">Paraf</td>
            <td width="12%" align="center">Sisa Hutang</td>
            <td width="10%" align="center">Paraf</td>
            <td width="10%" align="center">Keterangan</td>
        </tr>

        <?php 
        $no = 1;
        $query = "SELECT * FROM kavling_peta k 
        LEFT JOIN customer c ON k.id_customer = c.id_customer 
        WHERE k.status ='3'";    
        $tagih = $this->db->query($query)->result();
        foreach($tagih as $tgh){

            // cek bayar terakhir
            $quer2 = "SELECT * FROM pembayaran WHERE id_kavling='$tgh->id_kavling' ORDER BY pembayaran_ke DESC LIMIT 1";
            $terakhir = $this->db->query($quer2)->row_array();

            // Sisa Hutang
            $qSisa = "SELECT SUM(jumlah_bayar) as jum FROM pembayaran WHERE id_kavling='$tgh->id_kavling'";
            $sisa = $this->db->query($qSisa)->row_array();

            echo '<tr>
            <td align="center">'.$no++.'</td>
            <td align="center">'.$tgh->kode_kavling.'</td>
            <td align="center">'.strtoupper($tgh->nama_lengkap).'</td>
            <td align="center">'.tgl_indo($terakhir['tanggal']).'</td>
            <td align="center"></td>
            <td align="center"></td>
            <td align="center"></td>
            <td align="center">'.rupiah($tgh->hrg_jual - $sisa['jum']).'</td>
            <td align="center"></td>
            <td align="center"></td>
        </tr>';
        }

        ?>
    </table>
</div>
</div>
