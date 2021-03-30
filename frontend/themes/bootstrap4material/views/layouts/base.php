<?php $this->beginPage() ?>
<?php
use frontend\themes\bootstrap4material\assets\B4MaterialAsset;
use yii\helpers\Html;

B4MaterialAsset::register($this) ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <!-- Favicon-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">
    <link rel="shortcut icon" href="img/favicon.ico">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
    <!--<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
</head>
<body>
<div class="page">
    <?= $content ?>
</div>
<!-- JavaScript files-->
<!--<script src="vendor/jquery/jquery.min.js"></script>-->
<!--<script src="vendor/popper.js/umd/popper.min.js"> </script>-->
<!--<script src="vendor/bootstrap/js/bootstrap.min.js"></script>-->
<!--<script src="vendor/jquery.cookie/jquery.cookie.js"> </script>-->
<!--<script src="vendor/chart.js/Chart.min.js"></script>-->
<!--<script src="vendor/jquery-validation/jquery.validate.min.js"></script>-->
<!--<script src="js/charts-home.js"></script>-->
<!-- Main File-->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>