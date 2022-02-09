@extends('layouts.app')

@section('content')
<div class="container">
 	<h1>商談状況表（検索）</h1>
	 <div class="col">
		<a href="{{ action('SearchController@index') }}"  class="btn btn-danger">メニューに戻る</a>
	</div>
	@if (Session::has('flash_message'))
    	<p class="bg-info">{!! Session::get('flash_message') !!}</p>
	@endif
	<table class="table table-bordered small">
		<thead>
			<tr class="bg-success text-center">
				<th scope="col">物件名</th>
				<th scope="col">会社名</th>
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
			@foreach($properties as  $property)
				@isset($property->answer_date)
					@if($property->answer_date < $now_time) 
					<tr class='table-danger'>
					@else
					<tr>
					@endif
				@else
					@if($now_time->diffInDays($property->activity_history->date) >14)
					<tr class='table-danger'>
					@else
					<tr>
					@endif
				@endisset
					<input type="hidden" name="hidden_id[]" id="{{ $property->id }}" value="{{ $property->id }}" form="upsert">
					<td><input type="text" style="width:80px" name="name[]" id="name{{ $property->id }}" value="{{  $property->name }}" form="upsert"></td>
					<td>
						<a href="{{ action('ClientController@edit', $property->client_id)}}">{{ $property->client->name }}</a>
					</td>
					<td>
						<select name="status[]" id="status{{ $property->id }}" form="upsert">
							<option value="" {{ '' == $property->status ? 'selected' : ''}}></option>
							<option value="1" {{ '1' == $property->status ? 'selected' : ''}}>話</option>
							<option value="2" {{ '2' == $property->status ? 'selected' : ''}}>商</option>
							<option value="3" {{ '3' == $property->status ? 'selected' : ''}}>受注</option>
							<option value="4" {{ '4' == $property->status ? 'selected' : ''}}>失注</option>
						</select>
					</td>
					<td>{{ $property->activity_history->date }}</td>
					<td>
						<select name="pic[]" id="pic{{ $property->id }}" form="upsert">
							<option value=""  {{ '' == $property->pic_id ? 'selected' : ''}}></option>
							@foreach($pics as $pic)
								@if($pic->client_id == $property->client_id)
									<option value="{{ $pic->id }}" {{ $pic->id == $property->pic_id ? 'selected' : ''}}>{{ $pic->name }}</option>
								@endif
							@endforeach
						</select>
					</td>
					<td>
						<select name="reason[]" id="reason{{ $property->id }}" form="upsert">
							<option value="" {{ '' == $property->reason ? 'selected' : ''}}></option>
							<option value="1" {{ '1' == $property->reason ? 'selected' : ''}}>引合</option>
							<option value="2" {{ '2' == $property->reason ? 'selected' : ''}}>問合せ</option>
							<option value="3" {{ '3' == $property->reason ? 'selected' : ''}}>メンテ</option>
							<option value="4" {{ '4' == $property->reason ? 'selected' : ''}}>クレーム</option>
							<option value="5" {{ '5' == $property->reason ? 'selected' : ''}}>他</option>
						</select>
					</td>
					<td>
						<select name="sales_staff[]" id="sales_staff{{ $property->id }}" form="upsert">
							<option value="" {{ '' == $property->sales_staff_id ? 'selected' : ''}}></option>
							@foreach($all_sales_staff as $sales_staff)
								<option value="{{ $sales_staff->id }}" {{ $sales_staff->id == $property->sales_staff_id ? 'selected' : ''}}>{{ $sales_staff->name }}</option>
							@endforeach
						</select>
					</td>
					<td>
						<input type="text" style="width:80px" name="model[]" id="model{{ $property->id }}"  value="{{  $property->model }}" form="upsert">
					</td>
					<td>
						<input type="text" style="width:80px" name="introduction_date[]" id="introduction_date{{ $property->id }}" value="{{ $property->introduction_date }}" form="upsert">
					</td>
					<td>
						<textarea style="width:100px" name="note[]" id="detail{{ $property->id }}" form="upsert">{{ $property->note }}</textarea>
					</td>
					<td>
						<form method="POST" action="{{ action('EstimateFileUploadController@store',[
								'property_id' => $property->id,
								'activity_history_id' => $property->activity_history->id,
								'client_id' => $property->client_id,
								])}}" enctype="multipart/form-data">
								{{ csrf_field() }}	
							<input  font-size="10px" type="file" id="estimate_file{{ $property->id }}" name="estimate_file{{ $property->id }}" class="form-control">
							<button type="submit">アップ</button>
						</form>
						@foreach($estimate_files as $estimate_file)
							@if($property->id == $estimate_file->property_id)
								<div class="row">
									<div class="col">
										<a href="{{ action('EstimateFileDownloadController@index', [
											'client_id' => $property->client_id,
											'activity_history_id' => $property->activity_history->id,
											'property_id' => $property->id,
											'estimate_file_id' => $estimate_file->id,
											]) }}">{{ $estimate_file->path }}</a>
									</div>
									<div class="col">
										<form method="POST" action="{{ action('EstimateFileDownloadController@delete', [
											'client_id' => $property->client_id,
											'activity_history_id' => $property->activity_history->id,
											'property_id' => $property->id,
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
						<input type="text" style="width:80px" name="answer_date[]" id="answer_date{{ $property->id }}" value="{{ $property->answer_date }}" form="upsert">
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	<div>
		<form id="upsert" method="POST" action="{{ action('AllPropertyController@upsert') }}">
			@csrf
			<button type="submit" class="btn btn-primary">保存</button>
		</form>
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