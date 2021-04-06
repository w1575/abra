<?php /* @var $this \yii\web\View */

/* @var $this \yii\web\View */
/* @var $content string */
$minBundle =  \common\themes\AdminLTE3\assets\ALTE3MinAsset::register($this);
?>
<?php $this->beginContent('@common/themes/AdminLTE3/views/layouts/base-header.php') ?>
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index3.html" class="brand-link">
            <img src="<?= $minBundle->baseUrl?>/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">AdminLTE 3</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <?= $this->render('_user-info', ['minBundle' => $minBundle]) ?>
            </div>

            <!-- SidebarSearch Form -->
            <div class="form-inline">
                <div class="input-group" data-widget="sidebar-search">
                    <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">

                <?= \yii\bootstrap4\Nav::widget(
                    [
                        'items' => [
                            [
                                'label' => '<i class="nav-icon fas fa-tachometer-alt"></i> <p>Главная</p>',
                                'url' => ['/'],
                            ],
                            [
                                'label' => '<i class="nav-icon far fa-user-circle"></i> <p>Мои аккаунты</p>',
                                'url' => ['/portal/account'],
//                                'icon' => '',
                            ],
                            [
                                'label' => '<i class="nav-icon fab fa-wordpress"></i> Сайты',
                                'url' => ['/website'],
                            ],
                            [
                                'label' => '<i class="nav-icon fas fa-briefcase"></i> Клиенты',
                                'url' => ['/server'],
                            ],
                            [
                                'label' => '<i class="nav-icon fa fa-server"></i> Серверы',
                                'url' => ['/server'],
                            ],
                            [
                                'label' => '<i class="nav-icon fa fa-signature"></i> Домены',
                                'url' => ['/server'],
                            ],

                        ],
                        'encodeLabels' => false,
                        'options' => [
                            'class' => 'av nav-pills nav-sidebar flex-column',
                            'data-widget' =>  "treeview",
                            'role' => "menu",
                            'data-accordion' => "false",
                        ],
                    ]
                )?>

            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <?= $content ?>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 3.1.0
        </div>
    </footer>
</div>
<!-- ./wrapper -->
<?php $this->endContent()?>
