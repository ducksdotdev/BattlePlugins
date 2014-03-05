@extends('layouts.master')
@section('content')
<div class="content-section-a">
	<div class="container">
		<div class="row">
			<div class="col-lg-5">
				<h2>Statistics</h2>
				<p>This page contains statistics for many of the actions taken on the website. If you feel there should be logs for other things, please contact <a href="/profile/lDucks">lDucks</a>.</p>
			</div>
			<div class="col-lg-5 col-lg-offset-1">
				<h2>Tools</h2>
				<a href="/administrator/statistics/clear/apiRequests" class="btn btn-danger">Clear API Requests</a>
			</div>
		</div>
	</div>
</div>
<div class="content-section-b">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h3>API Requests</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<table class="table">
					<thead>
					<tr>
						<th width="20%">Username</th>
						<th width="30%">IP</th>
						<th width="40%">Route</th>
						<th width="10%">Count</th>
					</tr>
					</thead>
					<tbody>
					@foreach($apiRequests as $request)
					<tr>
						<td><a href="/profile/{{ $usernames[$request->user_id] }}">{{ $usernames[$request->user_id] }}</a></td>
						<td>{{ $request->ip }}</td>
						<td>{{ $request->route }}</td>
						<td>{{ $request->total }}</td>
					</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="content-section-a">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<p>Last update took {{ $lastUpdate }} seconds to completed.</p>
				{{ var_dump($newStatistics) }}
			</div>
		</div>
	</div>
</div>
@stop
