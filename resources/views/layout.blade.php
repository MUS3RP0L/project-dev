<!DOCTYPE html><html lang="es">	<head>		<meta charset="utf-8">		<meta http-equiv="X-UA-Compatible" content="IE=edge">		<meta name="viewport" content="width=device-width, initial-scale=1">		<title>Plataforma Virtual - MUSERPOL</title>		    {!! Html::style('bower_components/bootstrap/dist/css/bootstrap.min.css') !!}        {!! Html::style('bower_components/bootstrap-material-design/dist/css/bootstrap-material-design.min.css') !!}        {!! Html::style('bower_components/bootstrap-material-design/dist/css/ripples.min.css') !!}        {!! Html::style('bower_components/data-tables/media/css/dataTables.bootstrap.min.css') !!}        {!! Html::style('bower_components/bootstrap-combobox/css/bootstrap-combobox.css') !!}         {!! Html::style('bower_components/datePicker/css/bootstrap-datepicker3.css') !!} 	</head>	<body style = "padding-top: 70px;">		<nav class="navbar navbar-default navbar-fixed-top">			<div class="container-fluid">				<div class="navbar-header">					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">						<span class="sr-only">Toggle Navigation</span>						<span class="icon-bar"></span>						<span class="icon-bar"></span>						<span class="icon-bar"></span>					</button>					<img src="{{URL::asset('/assets/images/logo_muserpol.png')}}" style="width: 30px;margin: 5px;">					<a class="navbar-brand" href="#" style="float: right;">MUSERPOL</a>				</div>				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">					<ul class="nav navbar-nav">						<li><a href="{!! url('/') !!}">Inicio</a></li>						<li><a href="{!! url('afiliado') !!}">Afiliados</a></li>						<li><a href="{!! url('aportepago') !!}">Aporte Voluntario</a></li>						<!-- <li><a href="#">Fondo de Retiro</a></li> -->						<!-- <li><a href="#">Seguro de Vida</a></li> -->					</ul>					<ul class="nav navbar-nav navbar-right">						<form class="navbar-form navbar-left" action="{{url('ir_afiliado')}}">	            			<div class="form-group">	            				<div class="col-md-12" data-toggle="tooltip" data-placement="bottom" data-original-title="INGRESE NÚMERO DE CARNET DE IDENTIDAD">	              					<input type="text" class="form-control" name="search" size="10" style="font-size:20px" onkeyup = "this.value=this.value.toUpperCase()">	              				</div>	            			</div>	          			</form>	          			<li class="dropdown">							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span></a>							<ul class="dropdown-menu" role="menu">									@can('manage')								<li><a href="{!! url('user') !!}">Usuarios</a></li>								<li role="separator" class="divider"></li>								@endcan								<li><a href="{!! url('contribution_rate') !!}">Tasa Aporte</a></li>								<li role="separator" class="divider"></li>								<li><a href="{!! url('ipc') !!}">Tasa IPC</a></li>								<li role="separator" class="divider"></li>								<li><a href="{!! url('sueldo') !!}">Sueldos</a></li>								<li role="separator" class="divider"></li>								<li><a href="{!! url('total_month') !!}">Reporte</a></li>								</ul>						</li>	      				<li class="dropdown">							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></a>							<ul class="dropdown-menu" role="menu">								<li class="dropdown-header">{{ Auth::user()->role->name }}</li>								<li role="separator" class="divider"></li>								<li><a href="{!! url('user/' . Auth::user()->id . '/edit') !!}">{{ Util::ucw(Auth::user()->first_name) }}</a></li>								<li role="separator" class="divider"></li>								<li><a href="{!! url('logout') !!}">Salir</a></li>							</ul>						</li>					</ul>				</div>			</div>		</nav>		@yield('content')		<div id="myModal-message" class="modal fade">		    <div class="modal-dialog">		    	<div class="alert alert-dismissible alert-success">		        	<div class="modal-header">		                <h3 class="modal-title">Mensaje</h3>		            </div>	                <div class="modal-body">	                    <p>			          		<div><h4>{{ Session::get('message') }}</h4></div>	                    </p>	                </div>	                <div class="modal-footer">		            	<div class="row text-center">		            		<button type="button" class="btn btn-raised btn-default" data-dismiss="modal">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-ok"></span>&nbsp;&nbsp;&nbsp;</button>		            	</div>		            </div>		        </div>		    </div>		</div>		<div id="myModal-error" class="modal fade">		    <div class="modal-dialog">		        <div class="alert alert-dismissible alert-danger">		        	<div class="modal-header">		                <h3 class="modal-title">Mensaje</h3>		            </div>	                <div class="modal-body">	                    <p>	                        @foreach ($errors->all() as $error)			          			<div><h4>{{ $error }}</h4></div>			      			@endforeach	                    </p>	                </div>	                <div class="modal-footer">		            	<div class="row text-center">		            		<button type="button" class="btn btn-raised btn-default" data-dismiss="modal">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-ok"></span>&nbsp;&nbsp;&nbsp;</button>		            	</div>		            </div>		        </div>		    </div>		</div>	</body></html><!-- Scripts -->			{!! Html::script('bower_components/jquery/dist/jquery.min.js') !!}	{!! Html::script('bower_components/data-tables/media/js/jquery.dataTables.min.js') !!}	{!! Html::script('bower_components/data-tables/media/js/dataTables.bootstrap.min.js') !!}	{!! Html::script('bower_components/bootstrap/dist/js/bootstrap.min.js') !!}    {!! Html::script('bower_components/bootstrap-material-design/dist/js/ripples.min.js') !!}     {!! Html::script('bower_components/bootstrap-material-design/dist/js/material.min.js') !!}    {!! Html::script('bower_components/knockout/dist/knockout.js') !!}    {!! Html::script('bower_components/bootstrap-combobox/js/bootstrap-combobox.js') !!}    {!! Html::script('bower_components/datePicker/js/bootstrap-datepicker.js') !!}    {!! Html::script('bower_components/Chart.js/Chart.js') !!}	    	@stack('scripts')    <script type="text/javascript">        $(document).on('ready', function(){            $.material.init();        });	    $(document).ready(function(){		    $('[data-toggle="tooltip"]').tooltip(); 		});    </script>	@if($errors->has())		<script type="text/javascript">	    	$(document).ready(function(){				$("#myModal-error").modal('show');			});       </script>    @endif    @if (Session::has('message'))		<script type="text/javascript">	    	$(document).ready(function(){				$("#myModal-message").modal('show');			});       </script>	@endif	