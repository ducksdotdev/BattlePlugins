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
				<a href="/administrator/statistics/clear/statisticRequests" class="btn btn-danger">Clear Statistic Requests</a>
			</div>
		</div>
	</div>
</div>
<div class="content-section-b">
	<div class="container">
		<div class="row">
			<div class="col-lg-6">
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
			<div class="col-lg-6">
				<div class="row">
					<div class="col-lg-12">
						<h3>Statistic Requests</h3>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<table class="table">
							<thead>
							<tr>
								<th width="30%">Server</th>
								<th width="40%">Route</th>
								<th width="20%">Count</th>
							</tr>
							</thead>
							<tbody>
							@foreach($statisticRequests as $request)
							<tr>
								<td>{{ $request->server }}</td>
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
	</div>
</div>
<div class="content-section-a">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<small title="{{ $now }}">Last successful update was {{ $lastUpdate }}. Next update will be in {{ $diff }}. <a href="/administrator/statistics/forceStatisticsUpdate">Force update?</a></small>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<pre>{{ var_dump($statisticsCache) }}</pre>
			</div>
		</div>
	</div>
</div>
@stop
