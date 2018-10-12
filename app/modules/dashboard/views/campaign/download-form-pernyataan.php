<?php 
$biayaOperasional = $model['terkumpul'] * 5 / 100;
$totalDonasi = $model['terkumpul'] - $biayaOperasional;
?>

<br>
<br>
<div class="text-center">
    <h1> SURAT PERNYATAAN </h1>
</div>
<br>
<br>
<div>
    <p>Saya yang bertanda tangan di bawah ini :</p>
    <table>
        <tbody>
            <tr>
                <td>Nama</td>
                <td style="padding-left: 20px">:</td>
                <td style="padding-left: 20px"><?= $model['nama_lengkap'] ?></td>
            </tr>
            <tr>
                <td>NPM</td>
                <td style="padding-left: 20px">:</td>
                <td style="padding-left: 20px"><?= $model['username'] ?></td>
            </tr>
            <tr>
                <td>Judul Campaign</td>
                <td style="padding-left: 20px">:</td>
                <td style="padding-left: 20px"><?= $model['judul_campaign'] ?></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td style="padding-left: 20px">:</td>
                <td style="padding-left: 20px"><?= $model['bio_singkat'] ?></td>
            </tr>
        </tbody>
    </table>
</div>
<br>
<br>

<p>
Dengan ini menyatakan bahwa Campaign saya yang berjudul <b><?= $model['judul_campaign'] ?></b> bahwa hasil dari donasi tersebut yang berjumlah <b><?= Yii::$app->formatter->asCurrency($totalDonasi) ?></b> akan saya gunakan dengan sebaik-baiknya dan diberikan kepada penerima dana yang sebenar-benarnya.
</p>

<br>
<br>
<br>
<div class="text-right">
    <p> Jakarta, <?= date('d M Y') ?> </p>
    <br>
    <br>
    <br>
    <p><b><?= $model['nama_lengkap'] ?></b></p>
</div>

<script>
    window.print();
    window.close();
</script>