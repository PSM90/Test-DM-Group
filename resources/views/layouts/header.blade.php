<header>
    <div class="header-container">
        <div class="left-menu">
            <a href="/" alt="Unbranded" title="Unbranded" class="logo-url">
                <img src="{{ asset('images/logo-white.svg') }}" class="logo-white"/>
                <img src="{{ asset('images/logo.svg') }}" class="logo"/>
            </a>
            <div class="search-container">
                <img src="{{ asset('images/search-icon.svg') }}" class="search-icon"/>
                <input type="text" placeholder="Cerca su Unbranded">
            </div>
        </div>
        <div class="right-menu">
            <div class="nav-container">
                <ul class="menu">
                    <li class="has-child">
                        <a href="javascript:;">Viaggi <img src="{{ asset('images/chevron-down.svg') }}" class="arrow"/></a>
                        <ul class="submenu">
                            <li><a href="javascript:;">Lorem</a></li>
                            <li><a href="javascript:;">Ipsum</a></li>
                            <li><a href="javascript:;">Dolor sit amet</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;">Come funziona</a>
                    </li>
                    <li>
                        <a href="javascript:;">Fasce d'età</a>
                    </li>
                    <li>
                        <a href="javascript:;">Offerte</a>
                    </li>
                    <li>
                        <a href="javascript:;" class="cs-button-red">Turni confermati</a>
                    </li>
                    <li>
                        <a href="javascript:;">FAQ</a>
                    </li>
                    <li class="user-menu-container">
                        <div class="user-menu">
                            <img src="{{ asset('images/user-icon.svg') }}" class="user-icon"/>
                            <img src="{{ asset('images/chevron-down.svg') }}" class="arrow"/>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
