<p class="text-right">
    @if(\App\Tools\Models\ServerSettings::whereKey('registration')->pluck('value'))
        <a href="#">Register</a> |
    @endif
    <a href="#">Forgot Password</a>
</p>