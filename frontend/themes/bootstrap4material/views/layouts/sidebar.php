<?php
use yii\helpers\Html;
?>
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
                            'url' => ['/account'],
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
    <div class="content-inner">
        <!-- Page Header-->
        <header class="page-header">
            <div class="container-fluid">
                <h2 class="no-margin-bottom"><?= $this->title ?></h2>
            </div>
        </header>
        <!-- Dashboard Counts Section-->
        <section class="content-main">
            <div class="container-fluid">
                <?= $content ?>
            </div>
        </section>
        <!-- Page Footer-->
        <footer class="main-footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <p>
                            <?= \yii\helpers\Html::a(
                                    'w',
                                    'https://github.com/w1575',
                                [
                                        'class' => 'text--white',
                                    'target' => '_blank',
                                ]
                            ) ?>
                        </p>
                    </div>
                    <div class="col-sm-6 text-right">
                        <p>Design by <a href="https://bootstrapious.com/p/admin-template" class="external">Bootstrapious</a></p>
                        <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<?= $this->endContent() ?>
