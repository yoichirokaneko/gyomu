@extends('layouts.app')

@section('content')
<div class="container">
 	<h1>活動履歴画面</h1>
	 <div class="col text-right">
		<a href="{{ action('SearchController@index') }}"  class="btn btn-danger">メニューに戻る</a>
	</div>
	@if (Session::has('flash_message'))
    	<p class="bg-info">{!! Session::get('flash_message') !!}</p>
	@endif
	<h4>{{ $client->name }}</h4>
	<table class="table table-bordered">
		<thead>
			<tr class="bg-success text-center">
				<th scope="col">年月日</th>
				<th scope="col">担当者</th>
				<th scope="col">動機</th>
				<th scope="col">営業担当</th>
				<th scope="col">内容</th>
				<th scope="col">修理</th>
				<th scope="col">登録</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><input type="text" style="width:90px" name="date_new" id="date_new" form="upsert"></td>
				<td>
					<select name="pic_new" id="pic_new" form="upsert">
						<option value="" selected></option>
						@foreach($this_client_pics as $this_client_pic)
							<option value="{{ $this_client_pic->id }}">{{ $this_client_pic->name }}</option>
						@endforeach
					</select>
				</td>
				<td>
					<select name="reason_new" id="reason_new" form="upsert">
						<option value="" selected></option>
						<option value="1">引合</option>
						<option value="2">問合せ</option>
						<option value="3">メンテ</option>
						<option value="4">クレーム</option>
						<option value="5">他</option>
					</select>
				</td>
				<td>
					<select name="sales_staff_new" id="sales_staff_new" form="upsert">
						<option value="" selected></option>
						@foreach($all_sales_staff as $sales_staff)
							<option value="{{ $sales_staff->id }}">{{ $sales_staff->name }}</option>
						@endforeach
					</select>
				</td>
				<td>
					<textarea style="width:350px"name="detail_new" id="detail_new" form="upsert"></textarea>
				</td>
				<td>
				</td>
				<td>
				</td>
			</tr>
			@foreach($this_client_activity_histories as  $this_client_activity_history)
				<tr>
					<td>
						<input type="text" style="width:90px" name="date{{ $this_client_activity_history->id }}" id="date{{ $this_client_activity_history->id }}" value="{{ $this_client_activity_history->date }}" form="upsert">
					</td>
					<td>
						<select name="pic{{ $this_client_activity_history->id }}" id="pic{{ $this_client_activity_history->id }}" form="upsert">
							<option value=""  {{ '' == $this_client_activity_history->pic_id ? 'selected' : ''}}></option>
							@foreach($this_client_pics as $this_client_pic)
								<option value="{{ $this_client_pic->id }}" {{ $this_client_pic->id == $this_client_activity_history->pic_id ? 'selected' : ''}}>{{ $this_client_pic->name }}</option>
							@endforeach
						</select>
					</td>
					<td>
						<select name="reason{{ $this_client_activity_history->id }}" id="reason_new{{ $this_client_activity_history->id }}" form="upsert">
							<option value="" {{ '' == $this_client_activity_history->reason ? 'selected' : ''}}></option>
							<option value="1" {{ '1' == $this_client_activity_history->reason ? 'selected' : ''}}>引合</option>
							<option value="2" {{ '2' == $this_client_activity_history->reason ? 'selected' : ''}}>問合せ</option>
							<option value="3" {{ '3' == $this_client_activity_history->reason ? 'selected' : ''}}>メンテ</option>
							<option value="4" {{ '4' == $this_client_activity_history->reason ? 'selected' : ''}}>クレーム</option>
							<option value="5" {{ '5' == $this_client_activity_history->reason ? 'selected' : ''}}>他</option>
						</select>
					</td>
					<td>
						<select name="sales_staff{{ $this_client_activity_history->id }}" id="sales_staff{{ $this_client_activity_history->id }}" form="upsert">
							<option value="" {{ '' == $this_client_activity_history->sales_staff_id ? 'selected' : ''}}></option>
							@foreach($all_sales_staff as $sales_staff)
								<option value="{{ $sales_staff->id }}" {{ $sales_staff->id == $this_client_activity_history->sales_staff_id ? 'selected' : ''}}>{{ $sales_staff->name }}</option>
							@endforeach
						</select>
					</td>
					<td>
						<textarea style="width:350px"name="detail{{ $this_client_activity_history->id }}" id="detail{{ $this_client_activity_history->id }}" form="upsert">{{ $this_client_activity_history->detail }}</textarea>
					</td>
					<td>
						<form method="POST" action="{{ action('RepairFileUploadController@store',[
							'activity_history_id' => $this_client_activity_history->id,
							'client_id' => $client->id,
							])}}" enctype="multipart/form-data">
							{{ csrf_field() }}	
							<input type="file" id="repair_file{{ $this_client_activity_history->id }}" name="repair_file{{ $this_client_activity_history->id }}" class="form-control">
							<button type="submit">アップロード</button>
						</form>
						@foreach($repair_files as $repair_file)
							@if($this_client_activity_history->id == $repair_file->activity_history_id)
								<div class="row">
									<div class="col">
										<a href="{{ action('RepairFileDownloadController@index', [
											'client_id' => $client->id,
											'activity_history_id' => $this_client_activity_history->id,
											'repair_file_id' => $repair_file->id,
											]) }}">{{ $repair_file->path }}</a>
									</div>
									<div class="col">
										<form method="POST" action="{{ action('RepairFileDownloadController@delete', [
											'client_id' => $client->id,
											'activity_history_id' => $this_client_activity_history->id,
											'repair_file_id' => $repair_file->id,
											])}}">
											@csrf
											@method('DELETE')
											<input type="submit" value="削除" class="btn btn-danger btn-sm">
										</form>
									</div>
								</div>
							@endif
						@endforeach
					</td>
					<td>
						<a href="{{ action('PropertyController@create', [
							'activity_history_id' => $this_client_activity_history->id,
							'client_id' => $client->id,
						])}}"  class="btn btn-primary">登録</a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	<div>
		<form id="upsert" method="POST" action="{{ action('ActivityHistoryController@upsert',$client->id) }}">
			@csrf
			<button type="submit" class="btn btn-primary mb-3">保存</button>
		</form>
	</div>
	<div>
		<a href="{{ action('ClientController@edit',$client->id) }}"  class="btn btn-danger">顧客情報画面に戻る</a>
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