@extends('layouts.app')

@section('content')
<div class="container">
 	<h1>協会一覧画面</h1>
	 <div class="col text-right">
		<a href="{{ action('SearchController@index') }}"  class="btn btn-danger">メニューに戻る</a>
	</div>
	@if (Session::has('flash_message'))
    	<p class="bg-info">{!! Session::get('flash_message') !!}</p>
	@endif
	<table class="table table-bordered">
		<thead>
			<tr class="bg-success text-center">
				<th scope="col">協会名</th>
				<th scope="col">担当者</th>
				<th scope="col">〒</th>
				<th scope="col">住所</th>
				<th scope="col">TEL</th>
				<th scope="col">FAX</th>
			</tr>
		</thead>
		<tbody>
			@foreach($associations as  $association)
				<tr>
					<td>
						<a href="{{ action('AssociationController@edit', $association->id)}}">{{ $association->name }}</a>
					</td>
					<td>{{ $association->pic_name }}</td>
					<td>{{ $association->address_code }}</td>
					<td>{{ $association->address }}</td>
					<td>{{ $association->tel }}</td>
					<td>{{ $association->fax }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection