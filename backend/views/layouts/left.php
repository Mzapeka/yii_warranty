<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Robert Bosch</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu', 'data-widget' => 'tree'],
                'items' => [
                    ['label' => 'Management', 'options' => ['class' => 'header']],
                    ['label' => 'Управление гарантиями', 'icon' => 'folder', 'items' => [
                        ['label' => 'Пользователи', 'icon' => 'file-o', 'url' => ['/user'], 'active' => $this->context->id == 'user'],
                        ['label' => 'Клиенты', 'icon' => 'file-o', 'url' => ['/customer'], 'active' => $this->context->id == 'customer'],
                        ['label' => 'Гарантии', 'icon' => 'file-o', 'url' => ['/warranty'], 'active' => $this->context->id == 'warranty'],

                    ]],
                    ['label' => 'Каталог', 'icon' => 'folder', 'items' => [
                        ['label' => 'Категории', 'icon' => 'file-o', 'url' => ['/category'], 'active' => $this->context->id == 'category'],
                        ['label' => 'Документы', 'icon' => 'file-o', 'url' => ['/item'], 'active' => $this->context->id == 'item'],

                    ]],
                    ['label' => 'Импорт данных', 'icon' => 'folder', 'items' => [
                        ['label' => 'Импорт из старой базы', 'icon' => 'file-o', 'url' => ['/importdata'], 'active' => $this->context->id == 'default'],

                    ]],
                    ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
                    ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                    ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => 'Same tools',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
                            [
                                'label' => 'Level One',
                                'icon' => 'circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
                                    [
                                        'label' => 'Level Two',
                                        'icon' => 'circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>
</aside>
