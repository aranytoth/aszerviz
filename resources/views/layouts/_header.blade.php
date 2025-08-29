<header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">

                       <!-- LOGO -->
                 <div class="navbar-brand-box">
                    <a href="{{route('dashboard.index')}}" class="logo logo-dark">
                        <span class="logo-sm">
                            @if (isset(auth()->user()->garageOwner->company))
                               <img src="{{auth()->user()->garageOwner->company->company_logo}}" width="35"/>
                           @elseif (isset(auth()->user()->garage->company))
                               <img src="{{auth()->user()->garage->company->company_logo}}" width="35"/>
                           @endif
                        </span>
                        <span class="logo-lg">
                            @if (isset(auth()->user()->garageOwner->company))
                               <img src="{{auth()->user()->garageOwner->company->company_logo}}" width="45"/><span>{{auth()->user()->garageOwner->company->company_name}}</span> 
                           @elseif (isset(auth()->user()->garage->company))
                               <img src="{{auth()->user()->garage->company->company_logo}}" width="45"/>
                           @endif
                        </span>
                    </a>
                </div>

                    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                        <i class="mdi mdi-menu"></i>
                    </button>
                </div>
                <div class="d-flex">
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            
                            <span class="d-none d-xl-inline-block ms-1">{{auth()->user()->name}}</span>
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a class="dropdown-item" href="{{route('user.profil')}}"><i class="mdi mdi-account-circle-outline font-size-16 align-middle me-1"></i> Profil</a>
                            <a class="dropdown-item d-block" href="#"><span class="badge badge-success float-end">11</span><i class="mdi mdi-cog-outline font-size-16 align-middle me-1"></i> Beállítások</a>
                            <div class="dropdown-divider"></div>
                            <form action="{{route('logout')}}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger"><i class="mdi mdi-power font-size-16 align-middle me-1 text-danger"></i> Kijelentkezés</button>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </header>