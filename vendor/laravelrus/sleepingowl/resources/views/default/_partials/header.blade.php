<a href="{{ url(config('sleeping_owl.url_prefix')) }}" class="logo">
	<span class="logo-lg"> <img src="{{asset('images/site/logo_spbkk.png')}}" style="width: 19%;height: auto;margin: 2px;"></span>
	<span class="logo-mini"><img src="{{asset('images/site/logo_spbkk.png')}}" style="width: 80%;height: auto;"></span>
</a>

<nav class="navbar navbar-static-top" role="navigation">
	<!-- Sidebar toggle button-->
	<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
		<span class="sr-only">Toggle navigation</span>
	</a>
	<div class="navbar-custom-menu">	
		<ul class="nav navbar-nav">
			@stack('navbar')
		</ul>

		<ul class="nav navbar-nav navbar-right">
			@stack('navbar.right')
		</ul>
	</div>
<div class="navbar-custom-menu">	
		<ul class="nav navbar-nav">
					</ul>

		<ul class="nav navbar-nav navbar-right">  
@if (Auth::check())
    <li class="dropdown user user-menu" style="margin-right: 20px;">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
            
            <span class="hidden-xs"><i class="fa fa-user"></i> {{ Auth::user()->LastName }} {{ Auth::user()->FirstName }}</span>
        </a>
        <ul class="dropdown-menu">
            <!-- Menu Footer-->
            <li class="user-footer">
                <a href="/">вернуться на сайт</a>
            </li>
            <li class="user-footer">
                <a href="{{ route('logout') }}"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-btn fa-sign-out"></i> @lang('sleeping_owl::lang.auth.logout')
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>

        </ul>
    </li>
@endif
</ul>
</div>
        
</nav>
