@if ( ! empty($title))
	<div class="row">
		<div class="col-lg-12">
			{!! $title !!}
		</div>
	</div>
	<br />
@endif

@yield('before.panel')

<div class="panel panel-default">
     @if (request()->getPathInfo()=='/admin/kadets')
        

              @if(request()->input('import') == 'true')
                          <div class="alert alert-success alert-message">
             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                 <span aria-hidden="true">×</span>
             </button>
             <i class="fa fa-check fa-lg"></i> импорт успешно завершен
             @endif
             @if(request()->input('up') == 'true')
                          <div class="alert alert-success alert-message">
             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                 <span aria-hidden="true">×</span>
             </button>
             <i class="fa fa-check fa-lg"></i> Перевод успешен
             @endif
             @if(request()->input('import') == 'false')
                         <div class="alert alert-danger alert-message">
             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                 <span aria-hidden="true">×</span>
             </button>
             <i class="fa fa-bag fa-lg"></i> ошибка
             @endif
             
           </div> 
      
     @endif
	<div class="panel-heading">
           
		@if ($creatable)
			<a href="{{ url($createUrl) }}" class="btn btn-primary">
				<i class="fa fa-plus"></i> {{ $newEntryButtonText }}
			</a>
		@endif

		@yield('panel.buttons')

		<div class="pull-right">
			@yield('panel.heading.actions')
                        
                        @if (request()->getPathInfo()=='/admin/kadets')
                        <a href="/upkadet" class="btn btn-info">
                                    <i class="fa fa-sort-up"></i> Перевести на класс выше
                                </a>   
                        <form enctype="multipart/form-data" method="post" id="upload" action="/import">
                                {{ csrf_field() }}
                                <input type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" name="f" id="f" onchange="document.getElementById('upload').submit()" style="display: none;">
                                <label for="f" class="btn btn-primary">Импорт из файла</label>
                           </form> 
                               
                        @endif
		</div>
	</div>

	@yield('panel.heading')

	@foreach($extensions as $ext)
		{!! $ext->render() !!}
	@endforeach

	@yield('panel.footer')
</div>

@yield('after.panel')
