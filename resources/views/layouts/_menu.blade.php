<div class="vertical-menu">

            <div data-simplebar class="h-100">

                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="metismenu list-unstyled" id="side-menu">
                        <li class="menu-title">Menu</li>

                        <li>
                            <a href="{{route('dashboard.index')}}" class="waves-effect">
                                <i class="dripicons-home"></i>
                                <span>Műszerfal</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{route('worksheet.index')}}" class=" waves-effect">
                                <i class="dripicons-calendar"></i>
                                <span>Munkalapok</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{route('client.index')}}" class="waves-effect">
                                <i class="dripicons-user-group"></i>
                                <span>Úgyfelek</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{route('vehicle.index')}}" class=" waves-effect">
                                <i class="dripicons-rocket"></i>
                                <span>Gépjárművek</span>
                            </a>
                        </li>

                        @role('admin|manager')
                        <li class="menu-title">Admin</li>
                        <li>
                            <a href="{{route('users.index')}}" class=" waves-effect">
                                <i class="dripicons-user"></i>
                                <span>Felhasználók</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('company.index')}}" class=" waves-effect">
                                <i class="dripicons-scale"></i>
                                <span>Cégbeállítások</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('garage.index')}}" class=" waves-effect">
                                <i class="dripicons-store"></i>
                                <span>Garázsok</span>
                            </a>
                        </li>
                        @endrole
                    </ul>
                </div>
                <!-- Sidebar -->
            </div>
        </div>