<?php
	$soviet = [];

	$notsoviet = [];

	foreach ($makes as $make) {
		if($make->soviet)
			$soviet[] = $make;
		else
			$notsoviet[] = $make;
	}

?>

<div class="makes">
	
	@include('parts.media-header', ['title' => 'Выберите производителя'])

	@if($id == 'catalog-makes')	
		<div id="{{ $id }}">
	@else
		<div id="{{ $id }}" data-current="{{ $spec->id }}">
	@endif

		<ul>
			@foreach($soviet as $make)

                <li data-id="{{ $make->id }}">

						<span>
							<span class="makes_icon" style="background-image:url({{ route('home') . '/' . $make->icon }})"></span>

                            @if($id == 'catalog-makes')
                                @if(isset($no_type))
                                    <a href="{{ route('catalog-nospecs', ['make' => $make->name, 'type' => $bread['type']->name]) }}">{{ $make->title }}</a>
                                @else
                                    <a href="{{ route('catalog-nospecs', $make->name) }}">{{ $make->title }}</a>
                                @endif
                            @else
                                @if(isset($no_type))
                                    <a href="{{ route('make', ['spec' => $spec->name, 'make' => $make->name, 'type' => $bread['type']->name]) }}">
                                        {{ $make->title }}
                                    </a>
                                @else
                                    <a href="{{ route('make', ['spec' => $spec->name, 'make' => $make->name]) }}">
                                        {{ $make->title }}
                                    </a>
                                @endif
                            @endif
						</span>
                </li>
			
			@endforeach
		</ul>

		<ul>
			@foreach($notsoviet as $make)
				
					<li data-id="{{ $make->id }}">
			
						<span>
							<span class="makes_icon" style="background-image:url({{ route('home') . '/' . $make->icon }})"></span>
								
							@if($id == 'catalog-makes')
								<a href="{{ route('catalog-nospecs', $make->name) }}">{{ $make->title }}</a>
							@else
                                @if(isset($no_type))
                                    {{dd(route('make', ['spec' => $spec->name, 'make' => $make->name, 'type' => $bread['type']->name]))}}
                                    <a href="{{ route('make', ['spec' => $spec->name, 'make' => $make->name, 'type' => $bread['type']->name]) }}">
                                        {{ $make->title }}
                                    </a>
                                @else
                                    <a href="{{ route('make', ['spec' => $spec->name, 'make' => $make->name]) }}">
                                        {{ $make->title }}
                                    </a>
                                @endif
							@endif
						</span>
					</li>
			
			@endforeach
		</ul>

	</div>


	<div class="makes_empty">По данному запросу организаций не найдено</div>

</div>