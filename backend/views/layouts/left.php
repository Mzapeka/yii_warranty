<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/img/rb.jpg" class="img-circle" alt="User Image"/>
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
                    ['label' => 'Управление гарантиями', 'icon' => 'legal', 'items' => [
                        ['label' => 'Пользователи', 'icon' => 'users', 'url' => ['/user'], 'active' => $this->context->id == 'user'],
                        ['label' => 'Клиенты', 'icon' => 'handshake-o', 'url' => ['/customer'], 'active' => $this->context->id == 'customer'],
                        ['label' => 'Гарантии', 'icon' => 'id-card', 'url' => ['/warranty'], 'active' => $this->context->id == 'warranty'],
                        ['label' => 'Настройки', 'icon' => 'cog', 'url' => ['/warranty-settings'], 'active' => $this->context->id == 'warranty-settings'],

                    ]],
                    ['label' => 'Управление контентом', 'icon' => 'cogs', 'items' => [
                        ['label' => 'Первая страница пользователя', 'icon' => 'file-o', 'url' => ['/start-page-setting'], 'active' => $this->context->id == 'start-page-setting'],
                    ]],
                    ['label' => 'Каталог', 'icon' => 'vcard', 'items' => [
                        ['label' => 'Категории', 'icon' => 'address-book-o', 'url' => ['/category'], 'active' => $this->context->id == 'category'],
                        ['label' => 'Документы', 'icon' => 'file-pdf-o', 'url' => ['/item'], 'active' => $this->context->id == 'item'],

                    ]],
                    ['label' => 'Импорт данных', 'icon' => 'cloud-download', 'items' => [
                        ['label' => 'Импорт базы данных', 'icon' => 'database', 'url' => ['/importdata/import-db'], 'active' => $this->context->id == 'import-db'],
                        ['label' => 'Импорт каталога', 'icon' => 'xing', 'url' => ['/importdata/import-catalog'], 'active' => $this->context->id == 'import-catalog'],

                    ]],
                ],
            ]
        ) ?>

    </section>
</aside>
