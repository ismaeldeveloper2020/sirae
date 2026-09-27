<aside class="app-sidebar bg-body-secondary shadow"
       data-bs-theme="dark">

    <div class="sidebar-brand">

        <a href="{{ route('dashboard') }}"
           class="brand-link text-decoration-none">

            <span class="brand-text fw-bold">
                SISEACT
            </span>

        </a>

    </div>

    <div class="sidebar-wrapper">

        <nav class="mt-2">

            <ul class="nav sidebar-menu flex-column"
                data-lte-toggle="treeview"
                role="menu">

                <li class="nav-item">

                    <a href="{{ route('dashboard') }}"
                       class="nav-link">

                        <i class="nav-icon fas fa-home"></i>

                        <p>
                            Dashboard
                        </p>

                    </a>

                </li>

                @role('SuperAdmin')

                <li class="nav-header">
                    ADMINISTRACIÓN
                </li>

                <li class="nav-item">

                    <a href="{{ route('admin.users') }}"
                       class="nav-link">

                        <i class="nav-icon fas fa-users"></i>

                        <p>
                            Usuarios
                        </p>

                    </a>

                </li>

                <li class="nav-item">

                    <a href="{{ route('admin.roles') }}"
                       class="nav-link">

                        <i class="nav-icon fas fa-user-shield"></i>

                        <p>
                            Roles
                        </p>

                    </a>

                </li>

                <li class="nav-item">

                    <a href="{{ route('admin.organizaciones') }}"
                       class="nav-link">

                        <i class="nav-icon fas fa-building"></i>

                        <p>
                            Organizaciones
                        </p>

                    </a>

                </li>

                @endrole

            </ul>

        </nav>

    </div>

</aside>