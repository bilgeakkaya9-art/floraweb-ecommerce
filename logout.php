<?php
session_start();
session_unset(); // Tüm session değişkenlerini (sepet, kullanıcı adı vb.) temizle
session_destroy(); // Oturumu veritabanı bağlantısından tamamen kopar
header("Location: login.php"); // Kullanıcıyı giriş sayfasına geri şutla!
exit();
