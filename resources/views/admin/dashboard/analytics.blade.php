@if(UserSettings::hasNode(auth()->user(), UserSettings::VIEW_ANALYTICS))
    <h3>Google Analytics <a href="{{ action('AdminController@getAnalytics') }}"><i class="icon external"></i></a></h3>
    <ul class="stats">
        <li class="has-small {{ LaravelAnalytics::setSiteId("ga:106550685")->getVisitorsAndPageViewsForPeriod(new Carbon('first day of this month'), new Carbon('last day of this month'), 'yearMonth')[0]['visitors'] > 0 ? 'green' : 'yellow'}}">
            {{ LaravelAnalytics::setSiteId("ga:106550685")->getVisitorsAndPageViewsForPeriod(new Carbon('first day of this month'), new Carbon('last day of this month'), 'yearMonth')[0]['visitors'] }}
            <div class="small">Visitors</div>
        </li>
        <li class="has-small {{ LaravelAnalytics::setSiteId("ga:106550685")->getVisitorsAndPageViewsForPeriod(new Carbon('first day of this month'), new Carbon('last day of this month'), 'yearMonth')[0]['pageViews'] > 0 ? 'green' : 'yellow'}}">
            {{ LaravelAnalytics::setSiteId("ga:106550685")->getVisitorsAndPageViewsForPeriod(new Carbon('first day of this month'), new Carbon('last day of this month'), 'yearMonth')[0]['pageViews'] }}
            <div class="small">Page Views</div>
        </li>
    </ul>
@endif