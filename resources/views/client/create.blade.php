@extends('layouts.app')

@section('content')
<div class="container">
 	<h1>新規顧客情報登録画面</h1>
	 <div class="col text-right">
		<a href="{{ action('SearchController@index') }}"  class="btn btn-danger">メニューに戻る</a>
	</div>
	<div class="d-flex justify-content-start">
		<div class="left">
			<div>
				<label for="rank" class="form-label">会社ランク</label>
				<select name="rank" id="rank" form="store">
						<option value="" selected></option>
						<option value="1">A</option>
						<option value="2">B</option>
						<option value="3">C</option>
						<option value="4">D</option>
						<option value="5">E</option>
				</select>
			</div>
			<div>
				<label for="name_kana" class="form-label">フリガナ</label>
				<input style="width:450px" type="text" name="name_kana" id="name_kana" form="store">
			</div>
			<div>
				<label for="client_name" class="form-label">会社名</label>
				<input style="width:450px" type="text" name="client_name" id="client_name" form="store">
			</div>
			<div>
				<p>特記事項</p>
				<table class="table table-bordered">
					<thead>
						<tr class="bg-success text-center">
							<th scope="col">商流</th>
							<th scope="col">会社名</th>
							<th scope="col">備考</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<select name="sales_channel" id="sales_channel" form="store">
									<option value="" selected></option>
									<option value="1">直取</option>
									<option value="2">商社経由</option>
									<option value="3">本社経由</option>
									<option value="4">取付工場経由</option>
								</select>
							</td>
							<td><input type="text" name="sales_channel_company_name" id="sales_channel_company_name" form="store"></td>
							<td rowspan="3">
								<textarea rows="5" name="note" id="note" form="store"></textarea>
							</td>
						</tr>
						<tr>
							<th colspan="2" scope="col" class="text-center bg-success">客先資料</th>
						</tr>
						<tr>
							<th colspan="2">
								<input type="file" id="client_file" name="client_file" class="form-control" form="store">
							</th>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="right">
			<div>
				<form method="POST" action="{{ action('SearchController@client_name') }}">
					@csrf
					<div class="form-group">
						<label for="client_name_search">会社名検索</label>
						<input type="text" name="client_name_search" id="client_name_search" list="client_name_search_list">
						<datalist id="client_name_search_list">
						</datalist>
						<button type="submit" class="btn btn-primary">検索</button>
					</div>
				</form>
			</div>
			<div>
				<label for="office_address_code" class="form-label">〒</label>
				<input type="text" name="zip11" onKeyUp="AjaxZip3.zip2addr(this,'','addr11','addr11');" id="office_address_code" form="store">
			</div>
			<div>
				<label for="office_address" class="form-label">事務所</label>
				<input type="text" style="width:400px" name="addr11" id="office_address" form="store">
			</div>
			<div>
				<label for="office_tel" class="form-label">TEL</label>
				<input type="text" name="office_tel" id="office_tel" form="store">
			</div>
			<div>
				<label for="office_fax" class="form-label">FAX</label>
				<input type="text" name="office_fax" id="office_fax" form="store">
			</div>
			<div>
				<label for="place_address_code" class="form-label">〒</label>
				<input type="text" name="zip12" onKeyUp="AjaxZip3.zip2addr(this,'','addr12','addr12');" id="place_address_code" form="store">
			</div>
			<div>
				<label for="place_address" class="form-label">事務所</label>
				<input type="text" style="width:400px" name="addr12" id="place_address" form="store">
			</div>
			<div>
				<label for="place_tel" class="form-label">TEL</label>
				<input type="text" name="place_tel" id="place_tel" form="store">
			</div>
			<div>
				<label for="place_fax" class="form-label">FAX</label>
				<input type="text" name="place_fax" id="place_fax" form="store">
			</div>
			<div>
				@for($i = 0; $i < 5; $i++)
					<div>
						<label for="association{{ $i+1 }}" class="form-label{{ $i+1 }}">協会名{{ $i+1 }}</label>
						<select name="association{{ $i+1 }}" id="association{{ $i+1 }}" form="store">
							<option selected></option>
							@foreach($associations as $association)
								<option value="{{ $association->id }}">{{ $association->name }}</option>
							@endforeach
						</select>
					</div>
				@endfor
			</div>
		</div>
	</div>
	<table class="table table-bordered">
		<thead>
			<tr class="bg-success text-center">
				<th scope="col">部署名</th>
				<th scope="col">名前</th>
				<th scope="col">※</th>
				<th scope="col">役職</th>
				<th scope="col">携帯番号</th>
				<th scope="col">E-mail</th>
				<th scope="col">新規作成</th>
			</tr>
		</thead>
		<tbody>
			@for($i = 0; $i < 6; $i++)
				<tr>
					<td>
						<input type="text" style="width:240px" name="department_name{{ $i+1 }}" id="department_name{{ $i+1 }}" form="store">
					</td>
					<td>
						<input type="text" style="width:120px" name="pic_name{{ $i+1 }}" id="pic_name{{ $i+1 }}" form="store">
					</td>
					<td>
						<select name="supplement{{ $i+1 }}" id="supplement{{ $i+1 }}" form="store">
							<option value=""></option>
							<option value="1">キーマン</option>
							<option value="2">要注意</option>
						</select>
					</td>
					<td>
						<select name="position{{ $i+1 }}" id="position{{ $i+1 }}" form="store">
							<option value="" selected></option>
							<option value="1">社長</option>
							<option value="2">常務</option>
							<option value="3">専務</option>
							<option value="4">部長</option>
							<option value="5">次長</option>
							<option value="6">課長</option>
							<option value="7">係長</option>
							<option value="8">主任</option>
							<option value="9">所長</option>
							<option value="10">支店長</option>
							<option value="11">その他</option>
						</select>
					</td>
					<td>
						<input type="text" style="width:120px" name="cellphone_number{{ $i+1 }}" id="cellphone_number{{ $i+1 }}" form="store">
					</td>
					<td>
						<input type="text" style="width:120px" name="email{{ $i+1 }}" id="email{{ $i+1 }}" form="store">
					</td>
					<td>
					</td>
				</tr>
			@endfor
		</tbody>
	</table>
	<div class="mx-auto">
		<table class="table table-bordered">
			<thead>
				<tr class="bg-success text-center">
					<th scope="col">実績型式</th>
					<th scope="col">年月</th>
					<th scope="col">金額</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><input style="width:800px" type="text" name="actual_model" id="actual_model" form="store"></td>
					<td><input type="text" style="width:100px" name="date" id="date" form="store"></td>
					<td><input type="text" style="width:100px" name="amount" id="amount" form="store"></td>
				</tr>	
			</tbody>
		</table>
	</div>
	<div>
		<form id="store" method="POST" action="{{ action('ClientController@store') }}"　enctype="multipart/form-data">
			@csrf
			<button type="submit" class="btn btn-primary">新規登録してメニューへ</button>
		</form>
	</div>
</div>

<script type="application/javascript">
$(document).ready(function(){
	$(function() {
    $.fn.autoKana('#client_name', '#name_kana', {
        katakana : true  //true：カタカナ、false：ひらがな（デフォルト）
    	});
	});

	$('#client_name_search').on('keyup', function(){
		$value = $(this).val();
		$.ajax({
			type : 'get',
			url : '../../ajax/client_name_search',
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