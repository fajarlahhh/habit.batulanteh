<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <title>HABIT | @yield('title')</title>

    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />

    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link href="/assets/css/material/app.min.css" rel="stylesheet" />
    <!-- ================== END BASE CSS STYLE ================== -->

    <link href="/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" />
    <link href="/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css" rel="stylesheet" />
    <link href="/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css" rel="stylesheet" />
    @stack('css')

    @livewireStyles
</head>

<body>
    <!-- begin #page-loader -->
    <div id="page-loader" class="fade show">
        <div class="material-loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2"
                    stroke-miterlimit="10"></circle>
            </svg>
            <div class="message">Loading...</div>
        </div>
    </div>
    <!-- end #page-loader -->

    <!-- begin #page-container -->
    <div id="page-container" class="fade page-sidebar-fixed page-header-fixed page-with-wide-sidebar">
        <!-- begin #header -->
        <div id="header" class="header navbar-default">
            <!-- begin navbar-header -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed navbar-toggle-left" data-click="sidebar-minify">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="/" class="navbar-brand">
                    <b>HABIT</b> {{ config('constant.perusahaan') }}
                </a>
            </div>
            <ul class="navbar-nav navbar-right">
                <li class="dropdown navbar-user">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="/assets/img/user/user.png" alt="" />
                        <span class="d-none d-md-inline">{{ auth()->user()->nama }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#modal-password" class="dropdown-item" data-toggle="modal">Ganti Kata Sandi</a>
                        <div class="dropdown-divider"></div>
                        <a href="javascript:;" class="dropdown-item btn-logout"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log
                            Out</a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        </form>
                    </div>
                </li>
            </ul>
        </div>
        <div id="sidebar" class="sidebar" data-disable-slide-animation="true">
            <div data-scrollbar="true" data-height="100%">
                <ul class="nav">
                    <li class="nav-profile">
                        <a href="javascript:;" data-toggle="nav-profile">
                            <div class="cover with-shadow"></div>
                            <div class="image">
                                <img src="/assets/img/user/user.png" alt="" />
                            </div>
                            <div class="info">
                                <b class="caret pull-right"></b>{{ auth()->user()->nama }}
                                <small>{{ auth()->user()->getRoleNames()->first() }}</small>
                            </div>
                        </a>
                    </li>
                    <li>
                        <ul class="nav nav-profile">
                            <li><a href="javascript:;"><i class="fa fa-question-circle"></i> Help</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav">
                    <li class="nav-header">Navigation</li>
                    @php
                        $currentUrl = '/' . Request::path();
                        
                        function renderSubMenu($value, $currentUrl)
                        {
                            $subMenu = '';
                            $GLOBALS['sub_level'] += 1;
                            foreach ($value as $key => $menu) {
                                $GLOBALS['active'][$GLOBALS['sub_level']] = '';
                                $currentLevel = $GLOBALS['sub_level'];
                                if (
                                    auth()
                                        ->user()
                                        ->can($menu['id'])
                                ) {
                                    $GLOBALS['subparent_level'] = '';
                        
                                    $subSubMenu = '';
                                    $hasSub = !empty($menu['sub_menu']) ? 'has-sub' : '';
                                    $hasCaret = !empty($menu['sub_menu']) ? '<b class="caret pull-right"></b>' : '';
                                    $hasTitle = !empty($menu['title']) ? $menu['title'] : '';
                                    $hasHighlight = !empty($menu['highlight']) ? '<i class="fa fa-paper-plane text-theme m-l-5"></i>' : '';
                        
                                    if (!empty($menu['sub_menu'])) {
                                        $subSubMenu .= '<ul class="sub-menu">';
                                        $subSubMenu .= renderSubMenu($menu['sub_menu'], $currentUrl);
                                        $subSubMenu .= '</ul>';
                                    }
                        
                                    $active = strpos($currentUrl, $menu['url']) === 0 ? 'active' : '';
                        
                                    if ($active) {
                                        $GLOBALS['parent_active'] = true;
                                        $GLOBALS['active'][$GLOBALS['sub_level'] - 1] = true;
                                    }
                                    if (!empty($GLOBALS['active'][$currentLevel])) {
                                        $active = 'active';
                                    }
                                    $subMenu .=
                                        '
                    <li class="' .
                                        $hasSub .
                                        ' ' .
                                        $active .
                                        '">
                     <a href="' .
                                        $menu['url'] .
                                        '" id="menu-' .
                                        $menu['id'] .
                                        '">' .
                                        $hasCaret .
                                        $hasTitle .
                                        $hasHighlight .
                                        '</a>
                     ' .
                                        $subSubMenu .
                                        '
                    </li>
                   ';
                                }
                            }
                            return $subMenu;
                        }
                        
                        foreach (config('sidebar.menu') as $key => $menu) {
                            if (
                                auth()
                                    ->user()
                                    ->can($menu['id'])
                            ) {
                                $GLOBALS['parent_active'] = '';
                        
                                $hasSub = !empty($menu['sub_menu']) ? 'has-sub' : '';
                                $hasCaret = !empty($menu['caret']) ? '<b class="caret"></b>' : '';
                                $hasIcon = !empty($menu['icon']) ? '<i class="' . $menu['icon'] . '"></i>' : '';
                                $hasImg = !empty($menu['img']) ? '<div class="icon-img"><img src="' . $menu['img'] . '" /></div>' : '';
                                $hasLabel = !empty($menu['label']) ? '<span class="label label-theme m-l-5">' . $menu['label'] . '</span>' : '';
                                $hasTitle = !empty($menu['title']) ? '<span>' . $menu['title'] . $hasLabel . '</span>' : '';
                                $hasBadge = !empty($menu['badge']) ? '<span class="badge pull-right">' . $menu['badge'] . '</span>' : '';
                        
                                $subMenu = '';
                        
                                if (!empty($menu['sub_menu'])) {
                                    $GLOBALS['sub_level'] = 0;
                                    $subMenu .= '<ul class="sub-menu">';
                                    $subMenu .= renderSubMenu($menu['sub_menu'], $currentUrl);
                                    $subMenu .= '</ul>';
                                }
                                $active = strpos($currentUrl, $menu['url']) === 0 ? 'active' : '';
                                $active = empty($active) && !empty($GLOBALS['parent_active']) ? 'active' : $active;
                                echo '
                   <li class="' .
                                    $hasSub .
                                    ' ' .
                                    $active .
                                    '">
                    <a href="' .
                                    ($menu['url'] == 'javascript:;' ? 'javascript:;' : url($menu['url'])) .
                                    '">
                     ' .
                                    $hasImg .
                                    '
                     ' .
                                    $hasBadge .
                                    '
                     ' .
                                    $hasCaret .
                                    '
                     ' .
                                    $hasIcon .
                                    '
                                                ' .
                                    $hasTitle .
                                    '
                    </a>
                    ' .
                                    $subMenu .
                                    '
                   </li>
                  ';
                            }
                        }
                    @endphp
                </ul>
            </div>
        </div>
        <div class="sidebar-bg"></div>

        <div id="content" class="content">
            @yield('content')
        </div>

        <div id="footer" class="footer">
            &copy; 2023 Perumdam Batu Lanteh, Kab. Sumbawa
        </div>
        <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade"
            data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    </form>
    @livewireScripts

    <script src="/assets/js/app.min.js"></script>
    <script src="/assets/js/theme/material.min.js"></script>
    <script src="/assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>
    @stack('scripts')
</body>

</html>
