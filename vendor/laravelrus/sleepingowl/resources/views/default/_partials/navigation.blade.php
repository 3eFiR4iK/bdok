<section class="sidebar">

	@stack('sidebar.top')

	<ul class="sidebar-menu">
		@stack('sidebar.ul.top')

		{!! $template->renderNavigation() !!}

		@stack('sidebar.ul.bottom')
	</ul>

	@stack('sidebar.bottom')
</section>