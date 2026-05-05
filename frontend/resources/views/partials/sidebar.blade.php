<aside class="sidebar">
  <button type="button" class="sidebar-close-btn !mt-4">
    <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
  </button>
  <div>
    <a href="{{ route('dashboard') }}" class="sidebar-logo">
      <img src="{{ asset('assets/images/logo.png') }}" alt="site logo" class="light-logo">
      <img src="{{ asset('assets/images/logo-light.png') }}" alt="site logo" class="dark-logo">
      <img src="{{ asset('assets/images/logo-icon.png') }}" alt="site logo" class="logo-icon">
    </a>
  </div>
  <div class="sidebar-menu-area">
    <ul class="sidebar-menu" id="sidebar-menu">
      <li class="sidebar-menu-group-title">Main</li>
      <li>
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active-page' : '' }}">
          <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
          <span>Dashboard</span>
        </a>
      </li>

      <li class="sidebar-menu-group-title">Catalog Management</li>
      <li>
        <a href="{{ route('authors.index') }}" class="{{ request()->routeIs('authors.*') ? 'active-page' : '' }}">
          <iconify-icon icon="mdi:account-edit-outline" class="menu-icon"></iconify-icon>
          <span>Authors</span>
        </a>
      </li>
      <li>
        <a href="{{ route('books.index') }}" class="{{ request()->routeIs('books.*') ? 'active-page' : '' }}">
          <iconify-icon icon="mdi:book-open-page-variant-outline" class="menu-icon"></iconify-icon>
          <span>Books</span>
        </a>
      </li>
      <li>
        <a href="{{ route('publishers.index') }}" class="{{ request()->routeIs('publishers.*') ? 'active-page' : '' }}">
          <iconify-icon icon="mdi:office-building-outline" class="menu-icon"></iconify-icon>
          <span>Publishers</span>
        </a>
      </li>
    </ul>
  </div>
</aside>
