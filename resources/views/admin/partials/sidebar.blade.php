<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <span class="menu-title">Dashboard</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('roles.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('roles.index') }}">
            <span class="menu-title">Role</span>
        </a>
    </li>
    @can(['create-users', 'edit-users', 'delete-users'])
    <li class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('users.index') }}">
        <span class="menu-title">User</span>
      </a>
    </li>
    @endcan
    <li class="nav-item {{ request()->routeIs('products.*') ? 'active' : '' }}">
        <a class="nav-link" href="#">
            <span class="menu-title">Product</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('categories.*') ? 'active' : '' }}">
        <a class="nav-link" href="#">
            <span class="menu-title">Category</span>
        </a>
    </li>
  </ul>
</nav>
