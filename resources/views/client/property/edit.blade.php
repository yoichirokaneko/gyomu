@extends('layouts.app')

@section('content')
<div class="container">
 	<h1>商談状況表</h1>
	 <div class="col text-right">
		<a href="{{ action('SearchController@index') }}"  class="btn btn-danger">メニューに戻る</a>
	</div>
	@if (Session::has('flash_message'))
    	<p class="bg-info">{!! Session::get('flash_message') !!}</p>
	@endif
	<h4>{{ $client->name }}</h4>
	<table class="table table-bordered small">
		<thead>
			<tr class="bg-success text-center">
				<th scope="col">物件名</th>
				<th scope="col">話・商・受注・発注</th>
				<th scope="col">発生年月日</th>
				<th scope="col">担当者</th>
				<th scope="col">動機</th>
				<th scope="col">営業担当</th>
				<th scope="col">型式</th>
				<th scope="col">導入時期</th>
				<th scope="col">備考他</th>
				<th scope="col">見積ファイル</th>
				<th scope="col">回答時期</th>
			</tr>
		</thead>
		<tbody>
			@foreach($this_client_properties as  $this_client_property)
			@isset($this_client_property->answer_date)
				@if($this_client_property->answer_date < $now_time) 
				<tr class='table-danger'>
				@else
				<tr>
				@endif
			@else
				@if($now_time->diffInDays($this_client_property->activity_history->date) >14)
				<tr class='table-danger'>
				@else
				<tr>
				@endif
			@endisset
					<td><input type="text" style="width:80px" name="name{{ $this_client_property->id }}" id="name{{ $this_client_property->id }}" value="{{  $this_client_property->name }}" form="upsert"></td>
					<td>
						<select name="status{{ $this_client_property->id }}" id="status{{ $this_client_property->id }}" form="upsert">
							<option value="" {{ '' == $this_client_property->status ? 'selected' : ''}}></option>
							<option value="1" {{ '1' == $this_client_property->status ? 'selected' : ''}}>話</option>
							<option value="2" {{ '2' == $this_client_property->status ? 'selected' : ''}}>商</option>
							<option value="3" {{ '3' == $this_client_property->status ? 'selected' : ''}}>受注</option>
							<option value="4" {{ '4' == $this_client_property->status ? 'selected' : ''}}>失注</option>
						</select>
					</td>
					<td>{{ $this_client_property->activity_history->date }}</td>
					<td>
						<select name="pic{{ $this_client_property->id }}" id="pic{{ $this_client_property->id }}" form="upsert">
							<option value=""  {{ '' == $this_client_property->pic_id ? 'selected' : ''}}></option>
							@foreach($this_client_pics as $this_client_pic)
								<option value="{{ $this_client_pic->id }}" {{ $this_client_pic->id == $this_client_property->pic_id ? 'selected' : ''}}>{{ $this_client_pic->name }}</option>
							@endforeach
						</select>
					</td>
					<td>
						<select name="reason{{ $this_client_property->id }}" id="reason{{ $this_client_property->id }}" form="upsert">
							<option value="" {{ '' == $this_client_property->reason ? 'selected' : ''}}></option>
							<option value="1" {{ '1' == $this_client_property->reason ? 'selected' : ''}}>引合</option>
							<option value="2" {{ '2' == $this_client_property->reason ? 'selected' : ''}}>問合せ</option>
							<option value="3" {{ '3' == $this_client_property->reason ? 'selected' : ''}}>メンテ</option>
							<option value="4" {{ '4' == $this_client_property->reason ? 'selected' : ''}}>クレーム</option>
							<option value="5" {{ '5' == $this_client_property->reason ? 'selected' : ''}}>他</option>
						</select>
					</td>
					<td>
						<select name="sales_staff{{ $this_client_property->id }}" id="sales_staff{{ $this_client_property->id }}" form="upsert">
							<option value="" {{ '' == $this_client_property->sales_staff_id ? 'selected' : ''}}></option>
							@foreach($all_sales_staff as $sales_staff)
								<option value="{{ $sales_staff->id }}" {{ $sales_staff->id == $this_client_property->sales_staff_id ? 'selected' : ''}}>{{ $sales_staff->name }}</option>
							@endforeach
						</select>
					</td>
					<td>
						<input type="text" style="width:80px" name="model{{ $this_client_property->id }}" id="model{{ $this_client_property->id }}"  value="{{  $this_client_property->model }}" form="upsert">
					</td>
					<td>
						<input type="text" style="width:80px" name="introduction_date{{ $this_client_property->id }}" id="introduction_date{{ $this_client_property->id }}" value="{{ $this_client_property->introduction_date }}" form="upsert">
					</td>
					<td>
						<textarea style="width:100px" name="note{{ $this_client_property->id }}" id="detail{{ $this_client_property->id }}" form="upsert">{{ $this_client_property->note }}</textarea>
					</td>
					<td>
						<form method="POST" action="{{ action('EstimateFileUploadController@store',[
								'property_id' => $this_client_property->id,
								'activity_history_id' => $this_client_property->activity_history->id,
								'client_id' => $client->id,
								])}}" enctype="multipart/form-data">
								{{ csrf_field() }}	
							<input  font-size="10px" type="file" id="estimate_file{{ $this_client_property->id }}" name="estimate_file{{ $this_client_property->id }}" class="form-control">
							<button type="submit">アップ</button>
						</form>
						@foreach($estimate_files as $estimate_file)
							@if($this_client_property->id == $estimate_file->property_id)
								<div class="row">
									<div class="col">
										<a href="{{ action('EstimateFileDownloadController@index', [
											'client_id' => $client->id,
											'activity_history_id' => $this_client_property->activity_history->id,
											'property_id' => $this_client_property->id,
											'estimate_file_id' => $estimate_file->id,
											]) }}">{{ $estimate_file->path }}</a>
									</div>
									<div class="col">
										<form method="POST" action="{{ action('EstimateFileDownloadController@delete', [
											'client_id' => $client->id,
											'activity_history_id' => $this_client_property->activity_history->id,
											'property_id' => $this_client_property->id,
											'estimate_file_id' => $estimate_file->id,
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
						<input type="text" style="width:80px" name="answer_date{{ $this_client_property->id }}" id="answer_date{{ $this_client_property->id }}" value="{{ $this_client_property->answer_date }}" form="upsert">
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	<div>
		<form id="upsert" method="POST" action="{{ action('PropertyController@upsert',$client->id) }}">
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