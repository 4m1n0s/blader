@extends('_layouts/master')

@section('content')
	<div class="min-h-screen flex flex-col items-center justify-center bg-gray-50 text-gray-800">
		<x-logo />
		<div class="mt-4 text-sm text-gray-500">
			{{ 'HTML Generator using Laravel Blade templating engine' }}
		</div>
	</div>
@endsection