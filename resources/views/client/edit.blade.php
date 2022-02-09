@extends('layouts.app')

@section('content')
<div class="container">
 	<h1>顧客情報画面</h1>
	 <div class="col text-right">
		<a href="{{ action('SearchController@index') }}"  class="btn btn-danger">メニューに戻る</a>
	</div>
	@if (Session::has('flash_message'))
    	<p class="bg-info">{!! Session::get('flash_message') !!}</p>
	@endif
	<div class="d-flex justify-content-start">
		<div class="left">
			<div>
				<label for="rank" class="form-label">会社ランク</label>
				<select name="rank" id="rank" form="upsert">
						<option value="" {{ '' == $client->rank ? 'selected' : ''}}></option>
						<option value="1" {{ '1' == $client->rank ? 'selected' : ''}}>A</option>
						<option value="2" {{ '2' == $client->rank ? 'selected' : ''}}>B</option>
						<option value="3" {{ '3' == $client->rank ? 'selected' : ''}}>C</option>
						<option value="4" {{ '4' == $client->rank ? 'selected' : ''}}>D</option>
						<option value="5" {{ '5' == $client->rank ? 'selected' : ''}}>E</option>
				</select>
			</div>
			<div>
				<label for="name_kana" class="form-label">フリガナ</label>
				<input style="width:450px" type="text" name="name_kana" id="name_kana" value="{{ $client->name_kana }}" form="upsert">
			</div>
			<div>
				<label for="client_name" class="form-label">会社名</label>
				<input style="width:450px" type="text" name="client_name" id="client_name"  value="{{ $client->name}}" form="upsert">
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
							<select name="sales_channel" id="sales_channel" form="upsert">
								<option value="" {{ '' == $client->sales_channel ? 'selected' : ''}}></option>
								<option value="1" {{ '1' == $client->sales_channel ? 'selected' : ''}}>直取</option>
								<option value="2" {{ '2' == $client->sales_channel ? 'selected' : ''}}>商社経由</option>
								<option value="3" {{ '3' == $client->sales_channel ? 'selected' : ''}}>本社経由</option>
								<option value="4" {{ '4' == $client->sales_channel ? 'selected' : ''}}>取付工場経由</option>
							</select>
						</td>
						<td><input type="text" name="sales_channel_company_name" id="sales_channel_company_name"  value="{{ $client->sales_channel_company_name}}" form="upsert"></td>
						<td rowspan="3">
							<textarea rows="5" name="note" id="note" form="upsert">{{ $client->note }}</textarea>
						</td>
					</tr>
					<tr>
						<th colspan="2" scope="col" class="text-center bg-success">客先資料</th>
					</tr>
					<tr>
						<th colspan="2">
							<form method="POST" action="{{ action('ClientFileUploadController@store', $client->id)}}" enctype="multipart/form-data">
								{{ csrf_field() }}	
								<input type="file" id="client_file" name="client_file" class="form-control">
								<button type="submit">アップロード</button>
							</form>
							@foreach($this_client_files as $this_client_file)
								<div class="row">
									<div class="col">
										<a href="{{ action('ClientFileDownloadController@index', [
											'client_id' => $client->id,
											'client_file_id' => $this_client_file->id,
											]) }}">{{ $this_client_file->path }}</a>
									</div>
									<div class="col">
										<form method="POST" action="{{ action('ClientFileDownloadController@delete', [
											'client_id' => $client->id,
											'client_file_id' => $this_client_file->id,
											])}}">
											@csrf
											@method('DELETE')
											<input type="submit" value="削除" class="btn btn-danger btn-sm">
										</form>
									</div>
								</div>
							@endforeach
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
				<input type="text" name="zip11" onKeyUp="AjaxZip3.zip2addr(this,'','addr11','addr11');" id="office_address_code" value="{{ $client->office_address_code }}" form="upsert">
			</div>
			<div>
				<label for="office_address" class="form-label">事務所</label>
				<input type="text" style="width:400px" name="addr11" id="office_address"  value="{{ $client->office_address }}" form="upsert">
			</div>
			<div>
				<label for="office_tel" class="form-label">TEL</label>
				<input type="text" name="office_tel" id="office_tel"  value="{{ $client->office_tel }}" form="upsert">
			</div>
			<div>
				<label for="office_fax" class="form-label">FAX</label>
				<input type="text" name="office_fax" id="office_fax"  value="{{ $client->office_fax }}" form="upsert">
			</div>
			<div>
				<label for="place_address_code" class="form-label">〒</label>
				<input type="text" name="zip12" onKeyUp="AjaxZip3.zip2addr(this,'','addr12','addr12');" id="place_address_code" value="{{ $client->place_address_code }}" form="upsert">
			</div>
			<div>
				<label for="place_address" class="form-label">事務所</label>
				<input type="text" style="width:400px" name="addr12" id="place_address"  value="{{ $client->place_address }}" form="upsert">
			</div>
			<div>
				<label for="place_tel" class="form-label">TEL</label>
				<input type="text" name="place_tel" id="place_tel"  value="{{ $client->place_tel }}" form="upsert">
			</div>
			<div>
				<label for="place_fax" class="form-label">FAX</label>
				<input type="text" name="place_fax" id="place_fax"  value="{{ $client->place_fax }}" form="upsert">
			</div>
			<div>
				@for($i = 0; $i < 5; $i++)
					<div>
						<label for="association{{ $i+1 }}" class="form-label{{ $i+1 }}">協会名{{ $i+1 }}</label>
						<select name="association{{ $i+1 }}" id="association{{ $i+1 }}" form="upsert">
							@isset($this_client_associations[$i])
								<option></option>
								@foreach($associations as $association)
									<option value="{{ $association->id }}" {{ $association->id == $this_client_associations[$i]->id ? 'selected' : ''}}>{{ $association->name }}</option>
								@endforeach
							@else
								<option selected></option>
								@foreach($associations as $association)
										<option value="{{ $association->id }}">{{ $association->name }}</option>
								@endforeach
							@endisset
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
					@isset($this_client_pics[$i])
						<input type="hidden" name="pic_id{{ $i+1 }}" id=pic_id{{ $i+1 }} value="{{ $this_client_pics[$i]->id }}" form="upsert"> 
						<td>
							<input type="text" style="width:240px" name="department_name{{ $i+1 }}" id="department_name{{ $i+1 }}" value="{{ $this_client_pics[$i]->department_name }}" form="upsert">
						</td>
						<td>
							<input type="text" style="width:120px" name="pic_name{{ $i+1 }}" id="pic_name{{ $i+1 }}" value="{{ $this_client_pics[$i]->name }}" form="upsert">
						</td>
						<td>
							<select name="supplement{{ $i+1 }}" id="supplement{{ $i+1 }}" form="upsert">
								<option value="" {{ '' == $this_client_pics[$i]->supplement ? 'selected' : ''}}></option>
								<option value="1" {{ '1' == $this_client_pics[$i]->supplement ? 'selected' : ''}}>キーマン</option>
								<option value="2" {{ '2' == $this_client_pics[$i]->supplement ? 'selected' : ''}}>要注意</option>
							</select>
						</td>
						<td>
							<select name="position{{ $i+1 }}" id="position{{ $i+1 }}" form="upsert">
								<option value="" {{ '' == $this_client_pics[$i]->position ? 'selected' : ''}}></option>
								<option value="1" {{ '1' == $this_client_pics[$i]->position ? 'selected' : ''}}>社長</option>
								<option value="2" {{ '2' == $this_client_pics[$i]->position ? 'selected' : ''}}>常務</option>
								<option value="3" {{ '3' == $this_client_pics[$i]->position ? 'selected' : ''}}>専務</option>
								<option value="4" {{ '4' == $this_client_pics[$i]->position ? 'selected' : ''}}>部長</option>
								<option value="5" {{ '5' == $this_client_pics[$i]->position ? 'selected' : ''}}>次長</option>
								<option value="6" {{ '6' == $this_client_pics[$i]->position ? 'selected' : ''}}>課長</option>
								<option value="7" {{ '7' == $this_client_pics[$i]->position ? 'selected' : ''}}>係長</option>
								<option value="8" {{ '8' == $this_client_pics[$i]->position ? 'selected' : ''}}>主任</option>
								<option value="9" {{ '9' == $this_client_pics[$i]->position ? 'selected' : ''}}>所長</option>
								<option value="10" {{ '10' == $this_client_pics[$i]->position ? 'selected' : ''}}>支店長</option>
								<option value="11" {{ '11' == $this_client_pics[$i]->position ? 'selected' : ''}}>その他</option>
							</select>
						</td>
						<td>
							<input type="text" style="width:120px" name="cellphone_number{{ $i+1 }}" id="cellphone_number{{ $i+1 }}" value="{{ $this_client_pics[$i]->cellphone_number }}" form="upsert">
						</td>
						<td>
							<input type="text" style="width:120px" name="email{{ $i+1 }}" id="email{{ $i+1 }}" value="{{ $this_client_pics[$i]->email }}" form="upsert">
						</td>
						<td>
							<a href="mailto:{{ $this_client_pics[$i]->email }}?body={{ $client->name}}%0D%0A{{ $this_client_pics[$i]->department_name}}%0D%0A{{ $this_client_pics[$i]->name}}　様">メール</a>					
						</td>
					@else
						<td>
							<input type="text" style="width:240px" name="department_name{{ $i+1 }}" id="department_name{{ $i+1 }}" form="upsert">
						</td>
						<td>
							<input type="text" style="width:120px" name="pic_name{{ $i+1 }}" id="pic_name{{ $i+1 }}" form="upsert">
						</td>
						<td>
							<select name="supplement{{ $i+1 }}" id="supplement{{ $i+1 }}" form="upsert">
								<option value=""></option>
								<option value="1">キーマン</option>
								<option value="2">要注意</option>
							</select>
						</td>
						<td>
							<select name="position{{ $i+1 }}" id="position{{ $i+1 }}" form="upsert">
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
							<input type="text" style="width:120px" name="cellphone_number{{ $i+1 }}" id="cellphone_number{{ $i+1 }}" form="upsert">
						</td>
						<td>
							<input type="text" style="width:120px" name="email{{ $i+1 }}" id="email{{ $i+1 }}" form="upsert">
						</td>
						<td>
						</td>
					@endisset
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
				@isset($this_client_actual_models)
					<tr>
						<td><input style="width:800px" type="text" name="actual_model_new" id="actual_model_new" form="upsert"></td>
						<td><input type="text" style="width:100px" name="date_new" id="date_new" form="upsert"></td>
						<td><input type="text" style="width:100px" name="amount_new" id="amount_new" form="upsert"></td>
					</tr>
					<?php $num = 1?>
					@foreach ($this_client_actual_models as $this_client_actual_model)
						<tr>
							<td><input style="width:800px" type="text" name="actual_model{{ $num }}" id="actual_model{{ $num }}" value="{{ $this_client_actual_model->actual_model }}" form="upsert"></td>
							<td><input type="text" style="width:100px" name="date{{ $num }}" id="date{{ $num }}" value="{{ $this_client_actual_model->date }}" form="upsert"></td>
							<td><input type="text" style="width:100px" name="amount{{ $num }}" id="amount{{ $num }}" value="{{ number_format($this_client_actual_model->amount) }}" form="upsert"></td>
						</tr>
					<?php $num =  $num + 1?>
					@endforeach
				@else
					<tr>
						<td><input style="width:800px" type="text" name="actual_model_new" id="actual_model_new" form="upsert"></td>
						<td><input type="text" style="width:100px" name="date_new" id="date_new" form="upsert"></td>
						<td><input type="text" style="width:100px" name="amount_new" id="amount_new" form="upsert"></td>
					</tr>
				@endisset	
			</tbody>
		</table>
	</div>
	<div>
		<form id="upsert" method="POST" action="{{ action('ClientController@upsert',$client->id) }}">
			@csrf
			<button type="submit" class="btn btn-primary">保存</button>
		</form>
	</div>
	<div>
		<a href="{{ action('ActivityHistoryController@edit', $client->id) }}"  class="btn btn-primary">活動履歴</a>
	</div>
	<div>
		<a href="{{ action('PropertyController@edit', $client->id) }}"  class="btn btn-primary">商談状況表</a>
	</div>
	<form method="POST" action="{{ action('ClientController@delete', $client->id)}}">
		@csrf
		@method('DELETE')
		<div>
			<button type="submit" class="btn btn-danger mb-3">削除</button>
		</div>
	</form>
</div>

<script type="application/javascript">
$(function() {
    $.fn.autoKana('#client_name', '#name_kana', {
        katakana : true  //true：カタカナ、false：ひらがな（デフォルト）
    });
});
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
				$('#client_name_search_list').append('<option value="' + name +'">');
			});
		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log("エラーが発生しました。ステータス：" + jqXHR.status);
		});
	});
});
</script>

@endsection