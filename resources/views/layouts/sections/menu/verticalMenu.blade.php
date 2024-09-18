@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\DB;

    // Kullanıcının rolünü al
    $roleId = Auth::user()->role_id;
    // role_id'ye göre tüm permission_id'leri al
    $permissionRoles = DB::table('permission_role')
    ->where('role_id', $roleId)
    ->get();

    // Tüm permission_id'leri ve karşılık gelen name değerlerini toplayacağız
    $names = collect();

    foreach ($permissionRoles as $permissionRole) {
      // Her permission_role için ilgili permission_id'yi al
      $name = DB::table('permission')
      ->where('permission_id', $permissionRole->permission_id)
      ->value('name');

      if ($name) {
        $names->push($name);
      }
    }




    // Menü verilerini JSON dosyasından al
    $menuData = json_decode(file_get_contents(resource_path('menu/verticalMenu.json')), true);

    // Menülerin izinlerle karşılaştırılması
    $menuItems = collect($menuData['menu']);


    $allowedMenus = $menuItems->filter(function ($menu) use ($names) {


      // dd($names);
      // dd($menu['name']);
      // Ana menü öğelerini kontrol et
      if (isset($menu['name']) && $names->contains($menu['name'])) {
        return true;

      }

      // Alt menü öğelerini kontrol et
      if (isset($menu['submenu'])) {
        foreach ($menu['submenu'] as $submenu) {
          if (isset($submenu['name']) && $names->contains($submenu['name'])) {
            dd($menu);
            return true;
          }
        }
      }

      return false;
    });


    // Debug: Elde edilen verileri kontrol edin
    // dd($permissionRoles, $names, $menuData, $allowedMenus);
@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <!-- ! Hide app brand if navbar-full -->
    @if (!isset($navbarFull))
        <div class="app-brand demo">
            <a href="{{ url('/') }}" class="app-brand-link">
                <span class="app-brand-logo demo">@include('_partials.macros', ['height' => 20])</span>
                <span class="app-brand-text demo menu-text fw-bold">{{ config('variables.templateName') }}</span>
            </a>
            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                <i class="ti menu-toggle-icon d-none d-xl-block align-middle"></i>
                <i class="ti ti-x d-block d-xl-none ti-md align-middle"></i>
            </a>
        </div>
    @endif

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        @forelse ($allowedMenus as $menu)
            @php
                $currentRouteName = Route::currentRouteName();
                $activeClass = '';

                // Check if the current route name matches the menu slug
                if (isset($menu['slug']) && $menu['slug'] === $currentRouteName) {
                    $activeClass = 'active';
                } elseif (isset($menu['submenu'])) {
                    foreach ($menu['submenu'] as $submenu) {
                        if (str_contains($currentRouteName, $submenu['slug']) && strpos($currentRouteName, $submenu['slug']) === 0) {
                            $activeClass = 'active open';
                            break;
                        }
                    }
                }
            @endphp

            {{-- menu headers --}}
            @if (isset($menu['menuHeader']))
                <li class="menu-header small">
                    <span class="menu-header-text">{{ __($menu['menuHeader']) }}</span>
                </li>
            @else
                {{-- main menu --}}
                <li class="menu-item {{ $activeClass }}">
                    <a href="{{ isset($menu['url']) ? url($menu['url']) : 'javascript:void(0);' }}"
                        class="{{ isset($menu['submenu']) ? 'menu-link menu-toggle' : 'menu-link' }}"
                        @if (isset($menu['target']) && !empty($menu['target'])) target="_blank" @endif>
                        @isset($menu['icon'])
                            <i class="{{ $menu['icon'] }}"></i>
                        @endisset
                        <div>{{ isset($menu['name']) ? __($menu['name']) : '' }}</div>
                        @isset($menu['badge'])
                            <div class="badge bg-{{ $menu['badge'][0] }} rounded-pill ms-auto">{{ $menu['badge'][1] }}</div>
                        @endisset
                    </a>

                    {{-- submenu --}}
                    @if (isset($menu['submenu']))
                        <ul class="menu-sub {{ $activeClass === 'active open' ? 'show' : '' }}">
                            @foreach ($menu['submenu'] as $submenu)
                                <li class="menu-item">
                                    <a href="{{ url($submenu['url']) }}" class="menu-link">
                                        <div>{{ __($submenu['name']) }}</div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endif
        @empty
            <li class="menu-item">
                <span>No menu items available.</span>
            </li>
        @endforelse
    </ul>
</aside>
