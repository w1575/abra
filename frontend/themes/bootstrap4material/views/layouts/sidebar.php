<?php
use yii\helpers\Html;
?>
<?php \frontend\assets\AppAsset::register($this) ?>

<?php $this->beginContent('@frontend/themes/bootstrap4material/views/layouts/topnav.php') ?>
<div class="page-content d-flex align-items-stretch">
    <!-- Side Navbar -->
    <nav class="side-navbar">
        <!-- Sidebar Header-->
        <div class="sidebar-header d-flex align-items-center">
            <div class="avatar"><img src="/img/abra-face.png" alt="..." class="img-fluid rounded-circle"></div>
            <div class="title">
                <h1 class="h4">w</h1>
                <p>web</p>
            </div>
        </div>
        <!-- Sidebar Navidation Menus--><span class="heading">Основные доступы</span>
        <?= \yii\bootstrap4\Nav::widget(
                [
                    'items' => [
                        [
                            'label' => '<i class="icon-user"></i>Мои аккаунты',
                            'url' => ['/portal/account'],
//                                'icon' => '',
                        ],
                        [
                            'label' => '<i class="icon-interface-windows"></i> Сайты',
                            'url' => ['/website'],
                        ],
                        [
                            'label' => '<i class="fa fa-tasks"></i> Серверы',
                            'url' => ['/server'],
                        ],
                        [
                            'label' => '<i class="fa fa-tasks"></i> Хостинги',
                            'url' => ['/hosting'],
                        ]
                    ],
//                    'class' => 'list-unstyled',
                    'encodeLabels' => false,
                    'options' => [
                            'class' => 'list-unstyled',
                    ],
                ]
        )?>


        <span class="heading">Прочее</span>
        <?= \yii\bootstrap4\Nav::widget(
            [
                'items' => [
                    [
                        'label' => '<i class="icon-user"></i>Мой аккаунты',
                        'url' => ['/user'],
//                                'icon' => '',
                    ],
                ],
//                    'class' => 'list-unstyled',
                'encodeLabels' => false,
                'options' => [
                    'class' => 'list-unstyled',
                ],
            ]
        )?>
    </nav>
    <?= $content ?>
</div>
<?= $this->endContent() ?>
