@extends('layouts.app')

@section('content')
<div class="container">
	<h1>CSVインポート／エクスポート</h1>
	<div class="col text-right">
		<a href="{{ action('SearchController@index') }}"  class="btn btn-danger mb-3">メニューに戻る</a>
	</div>
	@if (Session::has('flash_message'))
    	<p class="bg-info">{!! Session::get('flash_message') !!}</p>
	@endif
	@if ($errors->any())
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif
	<div>
		<form method="POST" action="{{ action('CSVController@client_import') }}"enctype="multipart/form-data">
			@csrf
			<div class="form-group">
				<input type="file" id="client_import" name="client_import" class="form-control">
				<button type="submit">顧客リストCSVインポート</button>
			</div>
		</form>
	</div>
	<div>
		<form method="POST" action="{{ action('CSVController@association_import') }}"enctype="multipart/form-data">
			@csrf
			<div class="form-group">
				<input type="file" id="asociation_import" name="association_import" class="form-control">
				<button type="submit">協会リストCSVインポート</button>
			</div>
		</form>
	</div>
	<div>
		<form method="GET" action="{{ action('CSVController@client_export') }}">
			@csrf
			<button type="submit" class="btn btn-primary mb-3">顧客リストCSVエクスポート</button>
		</form>
	</div>
	<div>
		<form method="GET" action="{{ action('CSVController@association_export') }}">
			@csrf
			<button type="submit" class="btn btn-primary">協会リストCSVエクスポート</button>
		</form>
	</div>
</div>
@endsection