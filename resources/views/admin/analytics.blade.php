@extends('layouts.admin')
@section('content')
    <div class="grid-container">
        <div class="grid-100">
            <div class="ui message info">All data is collected from {{ Carbon::now()->formatLocalized('%B') }} 1
                until {{ Carbon::now()->formatLocalized('%B %e') }}. Updated every half hour.
            </div>
        </div>
        @foreach(config('laravel-analytics.siteIds') as $name => $gaid)
            <div class="grid-33 text-center">
                <h2>{{ $name }}</h2>
                <ul class="stats">
                    <li class="has-small {{ LaravelAnalytics::setSiteId("ga:$gaid")->getVisitorsAndPageViewsForPeriod(new Carbon('first day of this month'), new Carbon('last day of this month'), 'yearMonth')[0]['visitors'] > 0 ? 'green' : 'yellow'}}">
                        {{ LaravelAnalytics::setSiteId("ga:$gaid")->getVisitorsAndPageViewsForPeriod(new Carbon('first day of this month'), new Carbon('last day of this month'), 'yearMonth')[0]['visitors'] }}
                        <div class="small">Visitors</div>
                    </li>
                    <li class="has-small {{ LaravelAnalytics::setSiteId("ga:$gaid")->getVisitorsAndPageViewsForPeriod(new Carbon('first day of this month'), new Carbon('last day of this month'), 'yearMonth')[0]['pageViews'] > 0 ? 'green' : 'yellow'}}">
                        {{ LaravelAnalytics::setSiteId("ga:$gaid")->getVisitorsAndPageViewsForPeriod(new Carbon('first day of this month'), new Carbon('last day of this month'), 'yearMonth')[0]['pageViews'] }}
                        <div class="small">Page Views</div>
                    </li>
                </ul>
            </div>
        @endforeach
    </div>
@stop
