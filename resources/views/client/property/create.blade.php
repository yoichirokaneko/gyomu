@extends('layouts.app')

@section('content')
<div class="container">
 	<h1>物件登録画面</h1>
	 <div class="col text-right">
		<a href="{{ action('SearchController@index') }}"  class="btn btn-danger">メニューに戻る</a>
	</div>
	<h4>{{ $client->name }}</h4>
	<form  method="POST" action="{{ action('PropertyController@store',[
		'client_id' => $client->id,
		'activity_history_id' => $this_activity_history->id,
		])}}" enctype="multipart/form-data">
		@csrf
		<div>
			<label for="name" class="form-label col-md-2">物件名</label>
			<input type="text" name="name" id="name">
		</div>
		<div>
			<label for="status" class="form-label col-md-2">話・商・受注・失注</label>
			<select name="status" id="status">
					<option value=""></option>
					<option value="1">話</option>
					<option value="2">商</option>
					<option value="3">受注</option>
					<option value="4">失注</option>
			</select>
		</div>
		<div>
			<label for="pic" class="form-label col-md-2">担当者</label>
			<select name="pic" id="pic">
				<option value="" selected></option>
				@foreach($this_client_pics as $this_client_pic)
					<option value="{{ $this_client_pic->id }}">{{ $this_client_pic->name }}</option>
				@endforeach
			</select>
		</div>
		<div>
			<label for="reason" class="form-label col-md-2">動機</label>
			<select name="reason" id="reason">
					<option value=""></option>
					<option value="1">引合</option>
					<option value="2">問合せ</option>
					<option value="3">メンテ</option>
					<option value="4">クレーム</option>
					<option value="4">他</option>
			</select>
		</div>
		<div>
			<label for="sales_staff" class="form-label col-md-2">営業担当</label>
			<select name="sales_staff" id="sales_staff">
				<option value="" selected></option>
				@foreach($all_sales_staff as $sales_staff)
					<option value="{{ $sales_staff->id }}">{{ $sales_staff->name }}</option>
				@endforeach
			</select>
		</div>
		<div>
			<label for="model" class="form-label col-md-2">型式</label>
			<input type="text" name="model" id="model">
		</div>
		<div>
			<label for="introduction_date" class="form-label col-md-2">導入時期</label>
			<input type="text" name="introduction_date" id="introduction_date">
		</div>
		<div>
			<label for="note" class="form-label col-md-2">備考他</label>
			<textarea style="width:250px"name="note" id="note"></textarea>
		</div>
		<div>
			<label for="estimate_file" class="form-label col-md-2">見積ファイル</label>
			<input type="file" id="estimate_file" name="estimate_file">
		</div>
		<div>
			<label for="answer_date" class="form-label col-md-2">回答時期</label>
			<input type="text" name="answer_date" id="answer_date">
		</div>
		<div>
			<button type="submit" class="btn btn-primary  mt-3 mb-3">保存して商談状況表へ</button>
		</div>	
	</form>
	<div>
		<a href="{{ action('ActivityHistoryController@edit',$client->id) }}"  class="btn btn-danger">活動履歴に戻る</a>
	</div>
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