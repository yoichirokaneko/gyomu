@extends('layouts.app')

@section('content')
<div class="container">
	<h1>Menu</h1>
	@if (Session::has('flash_message'))
    	<p class="bg-info">{!! Session::get('flash_message') !!}</p>
	@endif
	<div>
		<form method="POST" action="{{ action('SearchController@client_name') }}">
			@csrf
			<div class="form-group">
				<label class="col-md-2" for="client_name_search">会社検索</label>
				<input type="text" name="client_name_search" id="client_name_search" list="client_name_search_list">
				<datalist id="client_name_search_list">
				</datalist>
				<button type="submit" class="btn btn-primary">検索</button>
			</div>
		</form>
	</div>
	<div>
		<form method="POST" action="{{ action('SearchController@client_pic') }}">
			@csrf
			<div class="form-group">
				<label class="col-md-2" for="client_pic_search">担当名検索</label>
				<input type="text" name="client_pic_search" id="client_pic_search">
				<select name="client_pic_search_list" id="client_pic_search_list">
				</select>
				<button type="submit" class="btn btn-primary">検索</button>
			</div>
		</form>
	</div>
	<div>
		<form method="POST" action="{{ action('SearchController@client_tel') }}">
			@csrf
			<div class="form-group">
				<label  class="col-md-2"  for="client_tel_search">TEL番号検索</label>
				<input type="text" name="client_tel_search" id="client_tel_search">
				<select name="client_tel_search_list" id="client_tel_search_list">
				</select>
				<button type="submit" class="btn btn-primary">検索</button>
			</div>
		</form>
	</div>
	<div>
		<form method="POST" action="{{ action('SearchController@client_activity') }}">
			@csrf
			<div class="form-group">
				<label  class="col-md-2"  for="client_activity_search">履歴検索</label>
				<input type="text" name="client_activity_search" id="client_activity_search">
				<select name="client_activity_search_list" id="client_activity_search_list">
				</select>
				<button type="submit" class="btn btn-primary">検索</button>
			</div>
		</form>
	</div>
	<div>
		<form method="GET" action="{{ action('SearchController@property') }}">
			@csrf
			<div class="form-group">
				<label  class="col-md-2"  for="property_search">商談検索</label>
				<input type="text" name="property_search" id="property_search">
				<button type="submit" class="btn btn-primary">検索</button>
			</div>
		</form>
	</div>
	<div>
		<a href="{{ action('ClientController@create') }}" class="btn btn-primary mb-3">新規顧客登録</a>
	</div>
	<div>
		<a href="{{ action('AssociationController@create') }}"  class="btn btn-primary  mb-3">新規協会登録</a>
	</div>
	<div>
		<a href="{{ action('AssociationController@show') }}"  class="btn btn-primary  mb-3">協会一覧</a>
	</div>
	<div>
		<a href="{{ action('CSVController@index') }}"  class="btn btn-primary  mb-3">CSVインポート／エクスポート</a>
	</div>
	<div>
		<a href="{{ action('SalesStaffController@create') }}"  class="btn btn-primary  mb-3">営業担当登録</a>
	</div>
</div>
<script type="application/javascript">
$(document).ready(function(){
	$('#client_name_search').on('keyup', function(){
		$value = $(this).val();
		$.ajax({
			type : 'get',
			url : '/ajax/client_name_search',
			data : {'client_name_search' : $value},
			dataType : 'json'
		}).done(function(data){
			$('#client_name_search_list').html("");
			$.each(data, function(index, val){
				var name = val.name;
				console.log(name);
				$('#client_name_search_list').append('<option value="' + name + '"/></option>');
			});
		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log("エラーが発生しました。ステータス：" + jqXHR.status);
		});
	});

	$('#client_pic_search').on('keyup', function(){
		$value = $(this).val();
		$.ajax({
			type : 'get',
			url : '/ajax/client_pic_search',
			data : {'client_pic_search' : $value},
			dataType : 'json'
		}).done(function(data){
			$('#client_pic_search_list').html("");
			$.each(data, function(index, val){
				var name = val.name;
				console.log(name);
				$('#client_pic_search_list').append('<option value="' + name  + '"/>' + name + '</option>');
			});
		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log("エラーが発生しました。ステータス：" + jqXHR.status);
		});
	});

	$('#client_tel_search').on('keyup', function(){
		$value = $(this).val();
		$.ajax({
			type : 'get',
			url : '/ajax/client_tel_search',
			data : {'client_tel_search' : $value},
			dataType : 'json'
		}).done(function(data){
			$('#client_tel_search_list').html("");
			$.each(data, function(index, val){
				var name = val;
				console.log(name);
				$('#client_tel_search_list').append('<option value="' + name  + '"/>' + name + '</option>');
			});
		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log("エラーが発生しました。ステータス：" + jqXHR.status);
		});
	});

	$('#client_activity_search').on('keyup', function(){
		$value = $(this).val();
		$.ajax({
			type : 'get',
			url : '/ajax/client_activity_search',
			data : {'client_activity_search' : $value},
			dataType : 'json'
		}).done(function(data){
			$('#client_activity_search_list').html("");
			$.each(data, function(index, val){
				var name = val.name;
				console.log(name);
				$('#client_activity_search_list').append('<option value="' + name  + '"/>' + name + '</option>');
			});
		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log("エラーが発生しました。ステータス：" + jqXHR.status);
		});
	});
});
	
</script>

@endsection