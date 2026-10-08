<header class="app-header navbar navbar-expand bg-body">

    <div class="container-fluid">

        <a class="nav-link"
           data-lte-toggle="sidebar"
           href="#">

            <i class="fa-solid fa-bars"></i>

        </a>

        <ul class="navbar-nav ms-auto">

            <li class="nav-item dropdown">

                <a class="nav-link"
                   href="#"
                   data-bs-toggle="dropdown">

                    <i class="fa-solid fa-bell"></i>

                    <span class="navbar-badge badge text-bg-danger">
                        0
                    </span>

                </a>

            </li>

            <li class="nav-item dropdown">

                <a class="nav-link d-flex align-items-center gap-2"
                   href="#"
                   data-bs-toggle="dropdown">

                    <img
                         src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->nombre." ". auth()->user()->apaterno." ". auth()->user()->amaterno) }}&background=22C55E&color=fff&size=128"
                        alt="Usuario"
                        class="rounded-circle"
                        width="35"
                        height="35">

                    <span>
                        {{ auth()->user()->nombre." ". auth()->user()->apaterno." ". auth()->user()->amaterno }}
                    </span>

                </a>

                <div class="dropdown-menu dropdown-menu-end">

                    <a href="{{ route('profile.show') }}"
                       class="dropdown-item">

                        <i class="fa-solid fa-user me-2"></i>
                        Mi Perfil

                    </a>

                    <div class="dropdown-divider"></div>

                    <form method="POST"
                          action="{{ route('logout') }}">

                        @csrf

                        <button type="submit"
                                class="dropdown-item text-danger">

                            <i class="fa-solid fa-right-from-bracket me-2"></i>
                            Salir

                        </button>

                    </form>

                </div>

            </li>

        </ul>

    </div>

</header>