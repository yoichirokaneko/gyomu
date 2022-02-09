@extends('layouts.app')

@section('content')
<div class="container">
 	<h1>協会情報画面</h1>
	 <div class="col text-right">
		<a href="{{ action('SearchController@index') }}"  class="btn btn-danger">メニューに戻る</a>
	</div>
	@if (Session::has('flash_message'))
    	<p class="bg-info">{!! Session::get('flash_message') !!}</p>
	@endif
	<form  method="POST" action="{{ action('AssociationController@update', $association->id)}}">
		@csrf
		<div class="d-flex">
			<div>
				<label for="name" class="form-label">協会名</label>
				<input type="text" name="name" id="name" value="{{ $association->name }}">
			</div>
			<div>
				<label for="address_code" class="form-label">〒</label>
				<input type="text" name="zip11" onKeyUp="AjaxZip3.zip2addr(this,'','addr11','addr11');" id="address_code" value="{{ $association->address_code }}">
			</div>
			<div>
				<label for="address" class="form-label">住所</label>
				<input type="text" style="width:300px" name="addr11" id="address" value="{{ $association->address }}">
			</div>
		</div>
		<div class="d-flex">
			<div>
				<label for="pic_name" class="form-label">担当名</label>
				<input type="text" name="pic_name" id="pic_name" value="{{ $association->pic_name }}">
			</div>
			<div>
				<label for="email" class="form-label">email</label>
				<input type="text" name="email" id="email" value="{{ $association->email }}">
			</div>
			<div>
				<label for="tel" class="form-label">TEL</label>
				<input type="text" name="tel" id="tel" value="{{ $association->tel }}">
			</div>
			<div>
				<label for="fax" class="form-label">FAX</label>
				<input type="text" name="fax" id="fax" value="{{ $association->fax }}">
			</div>
		</div>
		<div style="width: 100%">
			<label for="note" class="form-label">備考</label>
			<textarea  name="note" id="note" style="width: 100%">{{ $association->note }}</textarea>
		</div>
		<div>
			<button type="submit" class="btn btn-primary mb-3">保存</button>
		</div>
	</form>
	<form method="POST" action="{{ action('AssociationController@delete', $association->id)}}">
		@csrf
		@method('DELETE')
		<div>
			<button type="submit" class="btn btn-danger mb-3">削除</button>
		</div>
	</form>
	<div>
		<a href="{{ action('AssociationController@show') }}"  class="btn btn-danger">協会一覧画面に戻る</a>
	</div>
	<table class="table table-bordered">
		<thead>
			<tr class="bg-success text-center">
				<th scope="col">会社名</th>
				<th scope="col">代表者名</th>
				<th scope="col">〒</th>
				<th scope="col">住所</th>
				<th scope="col">TEL</th>
				<th scope="col">FAX</th>
			</tr>
		</thead>
		<tbody>
			@foreach($this_association_clients as  $this_association_client)
				<tr>
					<td>
						<a href="{{ action('ClientController@edit', $this_association_client->id)}}">{{ $this_association_client->name }}</a>
					</td>
					<td>
						@foreach($presidents as $president)
							@if($this_association_client->id == $president->client_id)
								{{ $president->name }}
							@endif
						@endforeach
					</td>
					<td>{{ $this_association_client->office_address_code }}</td>
					<td>{{ $association->office_address }}</td>
					<td>{{ $association->office_tel }}</td>
					<td>{{ $association->office_fax }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
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