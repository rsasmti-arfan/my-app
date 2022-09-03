<header class="header">
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container">
            <a href="/home">
                <img src="{{ URL::to('/images') }}/indosatooredoohutchison_logo.png" width="85">
            </a>
            &nbsp;&nbsp;
            <a class="navbar-brand mb-0 h1">D'BEST</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @can('manage-developer')
                        <li class="nav-item">
                            <a class="bb nav-link {{ 'opportunity-dashboard' == request()->segment(1) ? 'active' : '' }}"
                                aria-current="page" href="/opportunity-dashboard">Home</a>
                        </li>
                    @endcan
                    <!-- <li class="nav-item">
                        <a class="bb nav-link" href="#">Link</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="bb nav-link" href="{{ route('customers.index') }}">Customer</a>
                    </li>
                    <li class="nav-item">
                        <a class="bb nav-link" href="{{ route('messages.index') }}">Messages</a>
                    </li>
                    <li class="nav-item">
                        <a class="bb nav-link" href="{{ route('devices.index') }}">Device</a>
                    </li>

                    <li class="bb nav-item dropdown">
                        <a class="bb nav-link dropdown-toggle {{ 'my-opportunity' == request()->segment(2) ? 'active' : '' }}"
                            class="nav-link {{ 'dataanalysis' == request()->segment(2) ? 'active' : '' }}"
                            href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Opportunity
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @can('manage-developer')
                                <li><a class="bb dropdown-item   {{ 'opportunity' == request()->segment(1) ? 'active' : '' }}"
                                        href="/opportunity">My Opportunity</a></li>
                                <li><a class="bb dropdown-item" href="#">All Opportunity</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                            @endcan
                            <li><a class="bb dropdown-item" href="/price-calculator">Pricing Calculator</a></li>
                        </ul>
                    </li>


                    <!-- <li class="nav-item">
                        <a class="nav-link disabled">Disabled</a>
                    </li> -->
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a href="#" class="d-block link-dark text-decoration-none" style="color:red"
                            id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                            &nbsp;&nbsp;
                            <img src="{{ Auth::user()->profile_photo_url }}" alt="mdo" width="32"
                                height="32" class="rounded-circle">
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li>
                                <a class="dropdown-item" href="/user/profile">
                                    Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
