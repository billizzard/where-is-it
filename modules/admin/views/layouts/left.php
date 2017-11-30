<?
/** @var \app\models\User $user */
$user = Yii::$app->user->getIdentity();
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $user->getAvatar()?>" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?=$user->getLogin()?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <!--<form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>-->
        <!-- /.search form -->

        <ul class="sidebar-menu">
            <!--<li class="header"><span><span>Menu Yii2</span></span></li>-->
            <li><a href="/admin/places/<?=isset($_SESSION['place_id']) ? '?place_id=' . $_SESSION['place_id'] : ''?>"><i class="glyphicon glyphicon-map-marker"></i>  <span>Места</span></a></li>
            <li><a href="/admin/users/"><i class="glyphicon glyphicon-cog"></i>  <span>Профиль</span></a></li>
            <? if ($user && $user->hasAccess(\app\models\User::RULE_ADMIN_PANEL)) { ?>
                <li><a href="/admin/categories"><i class="glyphicon glyphicon-th-list"></i>  <span>Категории</span></a></li>
            <? } ?>
            <!--<li><a href="/debug"><i class="fa fa-dashboard"></i>  <span>Categories</span></a></li>
            <li class="active"><a href="#"><i class="fa fa-share"></i>  <span>Same tools</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                <ul class="treeview-menu menu-open" style="display: block;">
                    <li><a href="/gii"><i class="fa fa-file-code-o"></i>  <span>Gii</span></a></li>
                    <li><a href="/debug"><i class="fa fa-dashboard"></i>  <span>Debug</span></a></li>
                    <li class="active"><a href="#"><i class="fa fa-circle-o"></i>  <span>Level One</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                        <ul class="treeview-menu menu-open" style="display: block;">
                            <li><a href="#"><i class="fa fa-circle-o"></i>  <span>Level Two</span></a></li>
                            <li class="active"><a href="#"><i class="fa fa-circle-o"></i>  <span>Level Two</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                                <ul class="treeview-menu menu-open" style="display: block;">
                                    <li><a href="#"><i class="fa fa-circle-o"></i>  <span>Level Three</span></a></li>
                                    <li><a href="#"><i class="fa fa-circle-o"></i>  <span>Level Three</span></a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>-->
        </ul>



    </section>

</aside>
