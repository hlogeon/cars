@extends('layouts.main')

@section('body')
	
	<div class="catalog">
		
		<div class="wide-image"></div>

		<div class="container">

			<div class="catalog_left">
				
				@include('inc.specs')

			</div>
			
			<div class="catalog_middle">
				
				{{-- bread crumps --}}

				<h3 class="catalog_type">Разборки (б/у)</h3>

				@include('inc.type')

				@include('inc.makes')

			</div>

			<div class="catalog_right">
				
				@include('inc.search')

				@include('inc.feedback')

			</div>

		</div>

	</div>

@stop