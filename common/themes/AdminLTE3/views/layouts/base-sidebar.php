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
            <span class="brand-text font-weight-light">Abra</span>
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
                <?php $activeName = $this->params['sideBar']['active'] ?? false ?>
                <?= \yii\bootstrap4\Nav::widget(
                    [
                        'items' => [
                            [
                                'label' => '<i class="nav-icon fas fa-tachometer-alt"></i> <p>Главная</p>',
                                'url' => ['/'],
                                'active' => $activeName === false,
                            ],
                            [
                                'label' => '<i class="nav-icon far fa-user-circle"></i> <p>Мои аккаунты</p>',
                                'url' => ['/portal/account'],
                                'active' => $activeName === 'accounts',
                            ],
                            [
                                'label' => '<i class="nav-icon fab fa-wordpress"></i> <p>Сайты</p>',
                                'url' => ['/website'],
                                'active' => $activeName === 'websites',
                            ],
                            [
                                'label' => '<i class="nav-icon fas fa-briefcase"></i> <p>Клиенты</p>',
                                'url' => ['/server'],
                                'active' => $activeName === 'clients',
                            ],
                            [
                                'label' => '<i class="nav-icon fas fa-server"></i> <p>Серверы</p>  ',
                                'url' => ['/server'],
                                'active' => $activeName === 'servers',
                            ],
                            [
                                'label' => '<i class="nav-icon fas fa-signature"></i> <p>Домены</p>',
                                'url' => ['/server'],
                                'active' => $activeName === 'domains',
                            ],
                            [
                                'label' => '<i class="nav-icon fab fa-aws"></i> <p>Web компании</p>',
                                'url' => ['/web/company'],
                                'active' => $activeName === 'webCompanies',
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
