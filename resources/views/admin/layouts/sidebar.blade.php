<div id="kt_aside" class="aside aside-dark aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_mobile_toggle">
    <div class="aside-logo flex-column-auto" id="kt_aside_logo">
        <a href="{{ route('admin.dashboard') }}">
            <img alt="Logo" src="{{ asset('assets/media/logos/somnathenterprise-logo.svg') }}" class="h-30px logo" />
        </a>
        <div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-toggle" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="aside-minimize">
            <span class="svg-icon svg-icon-1 rotate-180">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path opacity="0.5" d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z" fill="currentColor" />
                    <path d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z" fill="currentColor" />
                </svg>
            </span>
        </div>
    </div>
    <div class="aside-menu flex-column-fluid">
        <div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="{}" >
            <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500" id="#kt_aside_menu" data-kt-menu="true" data-kt-menu-expand="false">
                <!-- Manage Staff -->
                @if(auth()->check() &&  auth()->user()->hasPermission('staff.index') )
                <div data-kt-menu-trigger="click" class="menu-item {{ request()->routeIs(['staff.*', 'users.*', 'attendance.*', 'daily-expense.*']) ? 'here show' : '' }} menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M6.28548 15.0861C7.34369 13.1814 9.35142 12 11.5304 12H12.4696C14.6486 12 16.6563 13.1814 17.7145 15.0861L19.3493 18.0287C20.0899 19.3618 19.1259 21 17.601 21H6.39903C4.87406 21 3.91012 19.3618 4.65071 18.0287L6.28548 15.0861Z" fill="currentColor" />
                                    <rect opacity="0.3" x="8" y="3" width="8" height="8" rx="4" fill="currentColor" />
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">Manage Staff</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        @if(auth()->check() && auth()->user()->hasPermission('staff.index'))
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('staff.*') ? 'active' : '' }}" href="{{ route('staff.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Staff</span>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Roles & Permissions (separate from Manage Staff) -->
                @if(auth()->check() && (auth()->user()->hasPermission('roles.index') || auth()->user()->hasPermission('permissions.index')))
                <div data-kt-menu-trigger="click" class="menu-item {{ request()->routeIs(['roles.*', 'permissions.*']) ? 'here show' : '' }} menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.3" d="M20.5543 4.37873C20.8318 4.14405 21.1515 3.97398 21.496 3.88555C21.8406 3.79712 22.2014 3.79284 22.5485 3.87423C22.8956 3.95563 23.2191 4.11973 23.5019 4.34793C23.7847 4.57613 24.0176 4.86234 24.1836 5.19034C24.3496 5.51834 24.4443 5.87848 24.4607 6.24627C24.4771 6.61407 24.4147 6.98056 24.2779 7.32109C24.1412 7.66162 23.9335 7.96782 23.6699 8.21876L13.6699 18.2188C13.4063 18.4697 13.0884 18.6593 12.7391 18.7725C12.3898 18.8857 12.0191 18.9194 11.6547 18.8708C11.2904 18.8222 10.9428 18.6932 10.6396 18.4954C10.3364 18.2976 10.0864 18.0371 9.91083 17.7358L4.91083 8.73584C4.73412 8.43263 4.63676 8.09159 4.6277 7.74228C4.61864 7.39296 4.69822 7.0472 4.85885 6.73584C5.01948 6.42448 5.25566 6.15784 5.54605 5.96059C5.83644 5.76334 6.17115 5.64235 6.52049 5.60896C6.86983 5.57558 7.22237 5.63114 7.54472 5.77045L11.5447 7.52045L20.5543 4.37873Z" fill="currentColor" />
                                    <path d="M12.8314 21.2599L12.2574 20.3719C12.0966 20.136 11.9694 19.8778 11.8809 19.6048L11.6134 18.7328C11.5253 18.4584 11.4757 18.1725 11.4664 17.8838L11.4238 16.5878C11.4164 16.2967 11.4444 16.0056 11.5071 15.7208L11.7251 14.7398C11.7878 14.455 11.8846 14.1795 12.0134 13.9198L12.5009 12.9198C12.6297 12.6601 12.789 12.4184 12.9759 12.2008L13.6599 11.3928C13.8468 11.1752 14.0594 10.9834 14.2929 10.8228L15.0829 10.2878C15.3164 10.1272 15.5684 9.99981 15.8329 9.90881L16.6479 9.62281C16.9124 9.53181 17.1864 9.47781 17.4639 9.46281L18.8979 9.38781C19.1754 9.37281 19.4524 9.39681 19.7229 9.45981L20.8929 9.72981C21.1634 9.79281 21.4244 9.89481 21.6699 10.0328L22.4979 10.4798C22.7434 10.6178 22.9704 10.7898 23.1729 10.9918L23.6499 11.4688C23.8524 11.6708 24.0274 11.8988 24.1699 12.1468L24.6479 12.9598C24.7904 13.2078 24.8979 13.4738 24.9679 13.7508L25.1729 14.5538C25.2429 14.8308 25.2749 15.1168 25.2679 15.4028L25.2479 16.4028C25.2409 16.6888 25.1949 16.9728 25.1129 17.2468L24.9129 17.9398C24.8309 18.2138 24.7129 18.4768 24.5629 18.7218L24.1129 19.4718C23.9629 19.7168 23.7829 19.9418 23.5779 20.1418L22.8279 20.8918C22.6229 21.0918 22.3929 21.2648 22.1429 21.4048L21.3929 21.8548C21.1429 21.9948 20.8779 22.0998 20.6029 22.1668L19.8529 22.3668C19.5779 22.4338 19.2929 22.4618 19.0079 22.4548L18.0079 22.4348C17.7229 22.4278 17.4389 22.3848 17.1629 22.3068L16.1629 22.0468C15.8869 21.9688 15.6229 21.8548 15.3779 21.7098L14.6279 21.2599C14.3829 21.1149 14.1579 20.9349 13.9579 20.7299L13.2079 19.9799C13.0079 19.7749 12.8349 19.5449 12.6949 19.2949L12.2449 18.5449C12.1049 18.2949 11.9999 18.0299 11.9329 17.7549L11.7329 17.0049C11.6659 16.7299 11.6379 16.4449 11.6449 16.1599L11.6649 15.1599C11.6719 14.8749 11.7149 14.5909 11.7929 14.3149L12.0529 13.3149C12.1309 13.0389 12.2449 12.7749 12.3899 12.5299L12.8314 21.2599Z" fill="currentColor" />
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">Roles &amp; Permissions</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        @if(auth()->check() && auth()->user()->hasPermission('roles.index'))
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('roles.*') ? 'active' : '' }}" href="{{ route('roles.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Roles</span>
                            </a>
                        </div>
                        @endif
                        @if(auth()->check() && auth()->user()->hasPermission('permissions.index'))
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('permissions.*') ? 'active' : '' }}" href="{{ route('permissions.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Permissions</span>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
                <!-- MANAGE WORK -->
                @if(auth()->check() && (
                    auth()->user()->hasPermission('firms.index')
                    || auth()->user()->hasPermission('departments.index')
                    || auth()->user()->hasPermission('sub-departments.index')
                    || auth()->user()->hasPermission('division.index')
                    || auth()->user()->hasPermission('sub-division.index')
                    || auth()->user()->hasPermission('locations.index')
                    || auth()->user()->hasPermission('works.index')
                ))
                <div data-kt-menu-trigger="click" class="menu-item {{ request()->routeIs(['departments.*', 'sub-departments.*', 'division.*', 'sub-division.*', 'locations.*', 'firms.*', 'works.*']) ? 'here show' : '' }} menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect x="2" y="2" width="9" height="9" rx="2" fill="currentColor" />
                                    <rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="currentColor" />
                                    <rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="currentColor" />
                                    <rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="currentColor" />
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">Manage Work</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        @if(auth()->check() && auth()->user()->hasPermission('firms.index'))
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('firms.*') ? 'active' : '' }}" href="{{ route('firms.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Firm</span>
                            </a>
                        </div>
                        @endif
                    </div>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        @if(auth()->check() && auth()->user()->hasPermission('departments.index'))
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('departments.*') ? 'active' : '' }}" href="{{ route('departments.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Department</span>
                            </a>
                        </div>
                        @endif
                    </div>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        @if(auth()->check() && auth()->user()->hasPermission('sub-departments.index'))
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('sub-departments.*') ? 'active' : '' }}" href="{{ route('sub-departments.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Sub Department</span>
                            </a>
                        </div>
                        @endif
                    </div>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        @if(auth()->check() && auth()->user()->hasPermission('division.index'))
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('division.*') ? 'active' : '' }}" href="{{ route('division.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Division</span>
                            </a>
                        </div>
                        @endif
                    </div>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        @if(auth()->check() && auth()->user()->hasPermission('sub-division.index'))
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('sub-division.*') ? 'active' : '' }}" href="{{ route('sub-division.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Sub Division</span>
                            </a>
                        </div>
                        @endif
                    </div>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        @if(auth()->check() && auth()->user()->hasPermission('locations.index'))
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('locations.*') ? 'active' : '' }}" href="{{ route('locations.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Location</span>
                            </a>
                        </div>
                        @endif
                    </div>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        @if(auth()->check() && auth()->user()->hasPermission('works.index'))
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('works.*') ? 'active' : '' }}" href="{{ route('works.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Work</span>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Manage Party/Vendor -->
                @if(auth()->check() && (
                    auth()->user()->hasPermission('material-categories.index')
                    || auth()->user()->hasPermission('material-lists.index')
                    || auth()->user()->hasPermission('parties.index')
                    || auth()->user()->hasPermission('contractors.index')
                ))
                <div data-kt-menu-trigger="click" class="menu-item {{ request()->routeIs(['material-categories.*', 'material-lists.*', 'parties.*', 'contractors.*']) ? 'here show' : '' }} menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.3" d="M3 13V11C3 10.4 3.4 10 4 10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14H4C3.4 14 3 13.6 3 13Z" fill="currentColor"/>
                                    <path d="M13 21H11C10.4 21 10 20.6 10 20V4C10 3.4 10.4 3 11 3H13C13.6 3 14 3.4 14 4V20C14 20.6 13.6 21 13 21ZM22 8V6C22 5.4 21.6 5 21 5H19C18.4 5 18 5.4 18 6V8C18 8.6 18.4 9 19 9H21C21.6 9 22 8.6 22 8ZM22 18V16C22 15.4 21.6 15 21 15H19C18.4 15 18 15.4 18 16V18C18 18.6 18.4 19 19 19H21C21.6 19 22 18.6 22 18ZM6 8V6C6 5.4 5.6 5 5 5H3C2.4 5 2 5.4 2 6V8C2 8.6 2.4 9 3 9H5C5.6 9 6 8.6 6 8ZM6 18V16C6 15.4 5.6 15 5 15H3C2.4 15 2 15.4 2 16V18C2 18.6 2.4 19 3 19H5C5.6 19 6 18.6 6 18Z" fill="currentColor"/>
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">Manage Party/Vendor</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        @if(auth()->check() && auth()->user()->hasPermission('material-categories.index'))
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('material-categories.*') ? 'active' : '' }}" href="{{ route('material-categories.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Material Category</span>
                            </a>
                        </div>
                        @endif
                    </div>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        @if(auth()->check() && auth()->user()->hasPermission('material-lists.index'))
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('material-lists.*') ? 'active' : '' }}" href="{{ route('material-lists.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Material List</span>
                            </a>
                        </div>
                        @endif
                    </div>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        @if(auth()->check() && auth()->user()->hasPermission('parties.index'))
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('parties.*') ? 'active' : '' }}" href="{{ route('parties.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Party</span>
                            </a>
                        </div>
                        @endif
                    </div>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        @if(auth()->check() && auth()->user()->hasPermission('contractors.index'))
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('contractors.*') ? 'active' : '' }}" href="{{ route('contractors.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Manage Vendor/Contractor</span>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Manage Site -->
                @if(auth()->check() && (
                    auth()->user()->hasPermission('site-material-requirements.index')
                    || auth()->user()->hasPermission('material-inwards.index')
                    || auth()->user()->hasPermission('site-progress.index')
                    || auth()->user()->hasPermission('tool-lists.index')
                    || auth()->user()->hasPermission('stages.index')
                ))
                <div data-kt-menu-trigger="click" class="menu-item {{ request()->routeIs(['site-material-requirements.*', 'material-inwards.*', 'site-progress.*', 'tool-lists.*', 'stages.*']) ? 'here show' : '' }} menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.3" d="M4.05424 15.1982C8.34524 7.76818 13.5782 3.26318 20.9282 2.01418C21.0729 1.98837 21.2216 1.99789 21.3618 2.04193C21.502 2.08597 21.6294 2.16323 21.7333 2.26712C21.8372 2.37101 21.9144 2.49846 21.9585 2.63863C22.0025 2.7788 22.012 2.92754 21.9862 3.07218C20.7372 10.4222 16.2322 15.6552 8.80224 19.9462L4.05424 15.1982ZM3.81924 17.3372L2.63324 20.4482C2.58427 20.5765 2.5735 20.7163 2.6022 20.8507C2.63091 20.9851 2.69788 21.1082 2.79503 21.2054C2.89218 21.3025 3.01536 21.3695 3.14972 21.3982C3.28408 21.4269 3.42387 21.4161 3.55224 21.3672L6.66524 20.1802L3.81924 17.3372ZM16.5002 5.99818C16.2036 5.99818 15.9136 6.08615 15.6669 6.25097C15.4202 6.41579 15.228 6.65006 15.1144 6.92415C15.0009 7.19824 14.9712 7.49984 15.0291 7.79081C15.0869 8.08178 15.2298 8.34906 15.4396 8.55884C15.6494 8.76862 15.9166 8.91148 16.2076 8.96935C16.4986 9.02723 16.8002 8.99753 17.0743 8.884C17.3484 8.77046 17.5826 8.5782 17.7474 8.33153C17.9123 8.08486 18.0002 7.79485 18.0002 7.49818C18.0002 7.10035 17.8422 6.71882 17.5609 6.43752C17.2796 6.15621 16.8981 5.99818 16.5002 5.99818Z" fill="currentColor" />
                                    <path d="M4.05423 15.1982L2.24723 13.3912C2.15505 13.299 2.08547 13.1867 2.04395 13.0632C2.00243 12.9396 1.9901 12.8081 2.00793 12.679C2.02575 12.5498 2.07325 12.4266 2.14669 12.3189C2.22013 12.2112 2.31752 12.1219 2.43123 12.0582L9.15323 8.28918C7.17353 10.3717 5.4607 12.6926 4.05423 15.1982ZM8.80023 19.9442L10.6072 21.7512C10.6994 21.8434 10.8117 21.9129 10.9352 21.9545C11.0588 21.996 11.1903 22.0083 11.3195 21.9905C11.4486 21.9727 11.5718 21.9252 11.6795 21.8517C11.7872 21.7783 11.8765 21.6809 11.9402 21.5672L15.7092 14.8442C13.6269 16.8245 11.3061 18.5377 8.80023 19.9442ZM7.04023 18.1832L12.5832 12.6402C12.7381 12.4759 12.8228 12.2577 12.8195 12.032C12.8161 11.8063 12.725 11.5907 12.5653 11.4311C12.4057 11.2714 12.1901 11.1803 11.9644 11.1769C11.7387 11.1736 11.5205 11.2583 11.3562 11.4132L5.81323 16.9562L7.04023 18.1832Z" fill="currentColor" />
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">Manage Site</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        @if(auth()->check() && auth()->user()->hasPermission('site-material-requirements.index'))
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('site-material-requirements.*') ? 'active' : '' }}" href="{{ route('site-material-requirements.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Material Requirement</span>
                            </a>
                        </div>
                        @endif
                    </div>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        @if(auth()->check() && auth()->user()->hasPermission('material-inwards.index'))
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('material-inwards.*') ? 'active' : '' }}" href="{{ route('material-inwards.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Material Inward Details</span>
                            </a>
                        </div>
                        @endif
                    </div>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        @if(auth()->check() && auth()->user()->hasPermission('site-progress.index'))
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('site-progress.*') ? 'active' : '' }}" href="{{ route('site-progress.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Site Progress</span>
                            </a>
                        </div>
                        @endif
                    </div>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        @if(auth()->check() && auth()->user()->hasPermission('tool-lists.index'))
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('tool-lists.*') ? 'active' : '' }}" href="{{ route('tool-lists.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Tools</span>
                            </a>
                        </div>
                        @endif
                    </div>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        @if(auth()->check() && auth()->user()->hasPermission('stages.index'))
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('stages.*') ? 'active' : '' }}" href="{{ route('stages.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Stage</span>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Manage GST Bill -->
                @if(auth()->check() && (
                    auth()->user()->hasPermission('bill-inwards.index')
                    || auth()->user()->hasPermission('bill-outwards.index')
                ))
                <div data-kt-menu-trigger="click" class="menu-item {{ request()->routeIs(['bill-inwards.*', 'bill-outwards.*']) ? 'here show' : '' }} menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.3" d="M3 13V11C3 10.4 3.4 10 4 10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14H4C3.4 14 3 13.6 3 13Z" fill="currentColor"/>
                                    <path d="M13 21H11C10.4 21 10 20.6 10 20V4C10 3.4 10.4 3 11 3H13C13.6 3 14 3.4 14 4V20C14 20.6 13.6 21 13 21ZM22 8V6C22 5.4 21.6 5 21 5H19C18.4 5 18 5.4 18 6V8C18 8.6 18.4 9 19 9H21C21.6 9 22 8.6 22 8ZM22 18V16C22 15.4 21.6 15 21 15H19C18.4 15 18 15.4 18 16V18C18 18.6 18.4 19 19 19H21C21.6 19 22 18.6 22 18ZM6 8V6C6 5.4 5.6 5 5 5H3C2.4 5 2 5.4 2 6V8C2 8.6 2.4 9 3 9H5C5.6 9 6 8.6 6 8ZM6 18V16C6 15.4 5.6 15 5 15H3C2.4 15 2 15.4 2 16V18C2 18.6 2.4 19 3 19H5C5.6 19 6 18.6 6 18Z" fill="currentColor"/>
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">Manage GST Bill</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        @if(auth()->check() && auth()->user()->hasPermission('bill-inwards.index'))
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('bill-inwards.*') ? 'active' : '' }}" href="{{ route('bill-inwards.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Bill Inward</span>
                            </a>
                        </div>
                        @endif
                    </div>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        @if(auth()->check() && auth()->user()->hasPermission('bill-outwards.index'))
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('bill-outwards.*') ? 'active' : '' }}" href="{{ route('bill-outwards.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Bill Outward</span>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Manage Order -->
                @if(auth()->check() && auth()->user()->hasPermission('work-orders.index'))
                <div data-kt-menu-trigger="click" class="menu-item {{ request()->routeIs('work-orders.*') ? 'here show' : '' }} menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.3" d="M3 13V11C3 10.4 3.4 10 4 10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14H4C3.4 14 3 13.6 3 13Z" fill="currentColor"/>
                                    <path d="M13 21V7C13 6.4 12.6 6 12 6H4C3.4 6 3 6.4 3 7V21C3 21.6 3.4 22 4 22H12C12.6 22 13 21.6 13 21Z" fill="currentColor"/>
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">Manage Order</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        @if(auth()->check() && auth()->user()->hasPermission('work-orders.index'))
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('work-orders.*') ? 'active' : '' }}" href="{{ route('work-orders.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Work Order</span>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Manage Payment -->
                @if(auth()->check() && auth()->user()->hasPermission('payments.index'))
                <div data-kt-menu-trigger="click" class="menu-item {{ request()->routeIs('payments.*') ? 'here show' : '' }} menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.3" d="M3 13V11C3 10.4 3.4 10 4 10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14H4C3.4 14 3 13.6 3 13ZM16 17V15C16 14.4 16.4 14 17 14H20C20.6 14 21 14.4 21 15V17C21 17.6 20.6 18 20 18H17C16.4 18 16 17.6 16 17Z" fill="currentColor"/>
                                    <path d="M13 21V7C13 6.4 12.6 6 12 6H4C3.4 6 3 6.4 3 7V21C3 21.6 3.4 22 4 22H12C12.6 22 13 21.6 13 21Z" fill="currentColor"/>
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">Manage Payment</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        @if(auth()->check() && auth()->user()->hasPermission('payments.index'))
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('payments.*') ? 'active' : '' }}" href="{{ route('payments.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Payment</span>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Manage Scrap -->
                @if(auth()->check() && (
                    auth()->user()->hasPermission('scrap-materials.index')
                    || auth()->user()->hasPermission('scrap-lists.index')
                ))
                <!-- <div data-kt-menu-trigger="click" class="menu-item {{ request()->routeIs(['scrap-materials.*', 'scrap-lists.*']) ? 'here show' : '' }} menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.3" d="M4.05424 15.1982C8.34524 7.76818 13.5782 3.26318 20.9282 2.01418C21.0729 1.98837 21.2216 1.99789 21.3618 2.04193C21.502 2.08597 21.6294 2.16323 21.7333 2.26712C21.8372 2.37101 21.9144 2.49846 21.9585 2.63863C22.0025 2.7788 22.012 2.92754 21.9862 3.07218C20.7372 10.4222 16.2322 15.6552 8.80224 19.9462L4.05424 15.1982ZM3.81924 17.3372L2.63324 20.4482C2.58427 20.5765 2.5735 20.7163 2.6022 20.8507C2.63091 20.9851 2.69788 21.1082 2.79503 21.2054C2.89218 21.3025 3.01536 21.3695 3.14972 21.3982C3.28408 21.4269 3.42387 21.4161 3.55224 21.3672L6.66524 20.1802L3.81924 17.3372ZM16.5002 5.99818C16.2036 5.99818 15.9136 6.08615 15.6669 6.25097C15.4202 6.41579 15.228 6.65006 15.1144 6.92415C15.0009 7.19824 14.9712 7.49984 15.0291 7.79081C15.0869 8.08178 15.2298 8.34906 15.4396 8.55884C15.6494 8.76862 15.9166 8.91148 16.2076 8.96935C16.4986 9.02723 16.8002 8.99753 17.0743 8.884C17.3484 8.77046 17.5826 8.5782 17.7474 8.33153C17.9123 8.08486 18.0002 7.79485 18.0002 7.49818C18.0002 7.10035 17.8422 6.71882 17.5609 6.43752C17.2796 6.15621 16.8981 5.99818 16.5002 5.99818Z" fill="currentColor" />
                                    <path d="M4.05423 15.1982L2.24723 13.3912C2.15505 13.299 2.08547 13.1867 2.04395 13.0632C2.00243 12.9396 1.9901 12.8081 2.00793 12.679C2.02575 12.5498 2.07325 12.4266 2.14669 12.3189C2.22013 12.2112 2.31752 12.1219 2.43123 12.0582L9.15323 8.28918C7.17353 10.3717 5.4607 12.6926 4.05423 15.1982ZM8.80023 19.9442L10.6072 21.7512C10.6994 21.8434 10.8117 21.9129 10.9352 21.9545C11.0588 21.996 11.1903 22.0083 11.3195 21.9905C11.4486 21.9727 11.5718 21.9252 11.6795 21.8517C11.7872 21.7783 11.8765 21.6809 11.9402 21.5672L15.7092 14.8442C13.6269 16.8245 11.3061 18.5377 8.80023 19.9442ZM7.04023 18.1832L12.5832 12.6402C12.7381 12.4759 12.8228 12.2577 12.8195 12.032C12.8161 11.8063 12.725 11.5907 12.5653 11.4311C12.4057 11.2714 12.1901 11.1803 11.9644 11.1769C11.7387 11.1736 11.5205 11.2583 11.3562 11.4132L5.81323 16.9562L7.04023 18.1832Z" fill="currentColor" />
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">Manage Scrap</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('scrap-materials.*') ? 'active' : '' }}" href="{{ route('scrap-materials.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Scrap Material</span>
                            </a>
                        </div>
                    </div>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('scrap-lists.*') ? 'active' : '' }}" href="{{ route('scrap-lists.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Scrap List</span>
                            </a>
                        </div>
                    </div>
                </div> -->
                @endif
            </div>
        </div>
    </div>
</div>
