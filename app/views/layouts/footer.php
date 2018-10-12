<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <p class="footer-1-title"><a href="#"><?= Yii::$app->params['brand'] ?></a> adalah website untuk menggalang dana dan berdonasi secara online dan transparan. </p>
                <p>
                    DKI Jakarta
                    Indonesia
                    10510
                </p>
            </div>
            <div class="col-md-3">
                <h3>Take Action</h3>
                <ul>
                    <li><a href="/campaign/create">Galang Dana</a></li>
                    <li><a href="/campaign/">Donasi</a></li>
                    <!-- <li><a href="#"></a></li> -->
                </ul>
            </div>
            <div class="col-md-3">
                <h3>Pelajari lebih lanjut</h3>
                <ul>
                    <li><a href="#">Apa itu <?= Yii::$app->params['brand'] ?></a></li>
                    <li><a href="#">Fitur dan harga</a></li>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Syarat dan Ketentuan</a></li>
                    <li><a href="#">Kebijakan Pirivasi</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h3>Hubungi Kami</h3>
                <ul>
                    <li><a href="#">Our Team</a></li>
                    <li><a href="#">Our Partners</a></li>
                    <li><a href="#">Karir</a></li>
                    <li><a href="#">Blog</a></li>
                </ul>
            </div>
        </div>
        <hr>
        <div class="text-center copyright">&copy; <?= Yii::$app->params['brand'] ?> <?= date('Y') ?>. All right reserved.</div>
    </div>
</footer>