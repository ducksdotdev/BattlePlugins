<!-- Scripts -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/moment.min.js"></script>
<script src="/assets/js/datetimepicker.js"></script>
@if($dev && !Config::get('deploy.minify-develop'))
<script src="/assets/js/scripts.js"></script>
@if($admin)
<script src="/assets/js/admin.js"></script>
@endif
@else
<script src="/assets/js/scripts.min.js"></script>
@if($admin)
<script src="/assets/js/admin.min.js"></script>
@endif
@endif
@yield('extraScripts')
