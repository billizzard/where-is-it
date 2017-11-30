<nav id="w0" class="navbar-inverse navbar-fixed-top navbar" role="navigation">
    <div class="container">
<!--            <div class="navbar-header" style="float:left">
            <a class="navbar-brand" href="/">My Company</a>
        </div>-->
        <div >
            <ul id="w1" class="navbar-nav navbar-left nav" >
                <li><a href="/" class="glyphicon glyphicon-home" title="Главная"></a></li>
                <li><a class="menu-butt nav-toggle1" style="margin-top:8px;" title="Меню"><span></span></a></li>
                <li><a href="/add/" class="add" title="Добавить точку">+</a></li>
                <? if ($user) { ?>
                    <li><a href="/logout/" class="glyphicon glyphicon-log-out" title="Выйти"></a></li>
                <? } else {?>
                    <li><a href="/login/" class="glyphicon glyphicon-log-in" title="Войти"></a></li>
                <? } ?>
                <!--<li style="float:left"><a href="#" onclick="return false;" data-modal="accept-city" class="modal-trigger glyphicon glyphicon-map-marker" style="font-size:22px;"></a></li>-->
            </ul>
        </div>
    </div>
</nav>
