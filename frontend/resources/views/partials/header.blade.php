<div class="navbar-header border-b border-neutral-200 dark:border-neutral-600">
  <div class="flex items-center justify-between">
    <div class="col-auto">
      <div class="flex flex-wrap items-center gap-[16px]">
        <button type="button" class="sidebar-toggle">
          <iconify-icon icon="heroicons:bars-3-solid" class="icon non-active"></iconify-icon>
          <iconify-icon icon="iconoir:arrow-right" class="icon active"></iconify-icon>
        </button>
        <button type="button" class="sidebar-mobile-toggle d-flex !leading-[0]">
          <iconify-icon icon="heroicons:bars-3-solid" class="icon !text-[30px]"></iconify-icon>
        </button>
      </div>
    </div>
    <div class="col-auto">
      <div class="flex flex-wrap items-center gap-3">
        {{-- Theme Toggle --}}
        <button type="button" id="theme-toggle" class="w-10 h-10 bg-neutral-200 dark:bg-neutral-700 dark:text-white rounded-full flex justify-center items-center">
          <span id="theme-toggle-dark-icon" class="hidden">
            <i class="ri-sun-line"></i>
          </span>
          <span id="theme-toggle-light-icon" class="hidden">
            <i class="ri-moon-line"></i>
          </span>
        </button>

        {{-- Profile Dropdown --}}
        <button data-dropdown-toggle="dropdownProfile" class="flex items-center gap-2" type="button">
          <div class="w-10 h-10 bg-primary-200 dark:bg-primary-600/25 text-primary-600 rounded-full flex justify-center items-center font-bold">
            {{ strtoupper(substr(session('user.name', 'U'), 0, 1)) }}
          </div>
          <span class="hidden md:block text-sm font-medium">{{ session('user.name', 'User') }}</span>
        </button>
        <div id="dropdownProfile" class="z-10 hidden bg-white dark:bg-neutral-700 rounded-lg shadow-lg w-48">
          <div class="py-2 px-4 border-b dark:border-neutral-600">
            <p class="text-sm font-medium truncate">{{ session('user.email', '') }}</p>
          </div>
          <ul class="py-2">
            <li>
              <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-start px-4 py-2 text-sm text-danger-600 hover:bg-gray-100 dark:hover:bg-gray-600 flex items-center gap-2">
                  <iconify-icon icon="lucide:log-out"></iconify-icon>
                  Logout
                </button>
              </form>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
