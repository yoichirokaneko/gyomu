@extends('layouts.app')

@section('content')
<div class="container">
 	<h1>新規協会情報登録画面</h1>
	 <div class="col text-right">
		<a href="{{ action('SearchController@index') }}"  class="btn btn-danger">メニューに戻る</a>
	</div>
	<form  method="POST" action="{{ action('AssociationController@store')}}">
		@csrf
		<div class="d-flex">
			<div>
				<label for="name" class="form-label">協会名</label>
				<input type="text" name="name" id="name">
			</div>
			<div>
				<label for="address_code" class="form-label">〒</label>
				<input type="text" name="zip11" onKeyUp="AjaxZip3.zip2addr(this,'','addr11','addr11');" id="address_code">
			</div>
			<div>
				<label for="address" class="form-label">住所</label>
				<input type="text" style="width:300px" name="addr11" id="address">
			</div>
		</div>
		<div class="d-flex">
			<div>
				<label for="pic_name" class="form-label">担当名</label>
				<input type="text" name="pic_name" id="pic_name">
			</div>
			<div>
				<label for="email" class="form-label">email</label>
				<input type="text" name="email" id="email">
			</div>
			<div>
				<label for="tel" class="form-label">TEL</label>
				<input type="text" name="tel" id="tel">
			</div>
			<div>
				<label for="fax" class="form-label">FAX</label>
				<input type="text" name="fax" id="fax">
			</div>
		</div>
		<div style="width: 100%">
			<label for="note" class="form-label">備考</label>
			<textarea  name="note" id="note" style="width: 100%"></textarea>
		</div>
		<div>
			<button type="submit" class="btn btn-primary">保存してメニューへ戻る</button>
		</div>
	</form>
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