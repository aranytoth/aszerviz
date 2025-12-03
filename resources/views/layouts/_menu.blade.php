<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>



                <li class="menu-title">CMS</li>
                <li>
                    <a href="{{route('admin.mainpage')}}" class="waves-effect">
                        <i class="dripicons-document"></i>
                        <span>{{ trans_db('menu.mainpage') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('pages.index')}}" class="waves-effect">
                        <i class="dripicons-document"></i>
                        <span>{{ trans_db('menu.pages') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('categories.index')}}" class="waves-effect">
                        <i class="dripicons-list"></i>
                        <span>{{ trans_db('menu.categories') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('tags.index')}}" class="waves-effect">
                        <i class="dripicons-document"></i>
                        <span>{{ trans_db('menu.tags') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('post.index')}}" class="waves-effect">
                        <i class="dripicons-document"></i>
                        <span>{{ trans_db('menu.posts') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('media.index')}}" class="waves-effect">
                        <i class="dripicons-list"></i>
                        <span>{{ trans_db('menu.gallery') }}</span>
                    </a>
                </li>


                @role('admin|manager')
                <li class="menu-title">Admin</li>
                <li>
                    <a href="{{route('admin.settings')}}" class="waves-effect">
                        <i class="dripicons-conversation"></i>
                        <span>{{ trans_db('menu.settings') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('users.index')}}" class=" waves-effect">
                        <i class="dripicons-user"></i>
                        <span>{{ trans_db('menu.users') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('translations.index')}}" class="waves-effect">
                        <i class="dripicons-conversation"></i>
                        <span>{{ trans_db('menu.translations') }}</span>
                    </a>
                </li>
                @endrole
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>