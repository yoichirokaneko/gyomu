@extends('layouts.app')

@section('content')
<div class="container">
 	<h1>営業担当登録画面</h1>
	@if (Session::has('flash_message'))
		<p class="bg-info">{!! Session::get('flash_message') !!}</p>
	@endif
	<div class="col text-right">
		<a href="{{ action('SearchController@index') }}"  class="btn btn-danger">メニューに戻る</a>
	</div>
	<form  method="POST" action="{{ action('SalesStaffController@store') }}">
		@csrf
		<div>
			<label for="name" class="form-label col-md-2">営業担当登録</label>
			<input type="text" name="name" id="name">
		</div>
		<div>
			<button type="submit" class="btn btn-primary  mt-3 mb-3">保存</button>
		</div>	
	</form>
	@foreach($all_sales_staff as $sales_staff)
		<div class="row justify-content-start">
			<p class="col-2">{{ $sales_staff->name }}</p>
			<form method="POST" action="{{ action('SalesStaffController@delete', $sales_staff->id)}}">
				@csrf
				@method('DELETE')
				<div class="col">
					<button type="submit" class="btn btn-danger mb-3">削除</button>
				</div>
			</form>
		</div>
	@endforeach
</div>

<script type="application/javascript">
$(function() {
    $.fn.autoKana('#name', '#name_kana', {
        katakana : true  //true：カタカナ、false：ひらがな（デフォルト）
    });
});
$(document).ready(function(){
	$('#client_name_search').on('keyup', function(){
		$value = $(this).val();
		$.ajax({
			type : 'get',
			url : '/ajax',
			data : {'client_name_search' : $value},
			dataType : 'json'
		}).done(function(data){
			$('#client_name_search_list').html("");
			$.each(data, function(index, val){
				var name = val.name;
				console.log(name);
				$('#client_name_search_list').append('<option value="' + name +'">');
			});
		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log("エラーが発生しました。ステータス：" + jqXHR.status);
		});
	});
});
</script>

@endsection