        <!-- start: Main Menu -->
        <div id="sidebar-left" class="span2 leftpanel">
            <div class="nav-collapse sidebar-nav">
                <ul class="nav nav-pills nav-stacked nav-bracket">
                    <?php $permissionPresenter = app('App\Presenters\PermissionPresenter'); ?>

                    <?php echo $permissionPresenter->menus(); ?>


                </ul>
            </div>
        </div>
        <!-- end: Main Menu -->