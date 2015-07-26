<?php
$url = urlencode('http://bplug.in/' . Domain::shorten($build->getDownloadUrl()));
$urlTitle = urlencode($build->getJob()->getName() . ' ' . $build->getVersion());
?>

<a class="item" href="https://www.facebook.com/sharer/sharer.php?u={{ $url }}&t={{ $urlTitle }}" target="_blank" title="Share on Facebook">
    <i class="icon facebook"></i> Facebook
</a>
<a class="item" href="https://twitter.com/intent/tweet?source={{ $url }}&text={{ $urlTitle }}:%20{{ $url }}" target="_blank" title="Tweet">
    <i class="icon twitter"></i> Twitter
</a>
<a class="item" href="https://plus.google.com/share?url={{ $url }}" target="_blank" title="Share on Google+">
    <i class="icon google plus"></i> Google+
</a>
<a class="item" href="http://www.reddit.com/submit?url={{ $url }}&title={{ $urlTitle }}" target="_blank" title="Submit to Reddit">
    <i class="icon reddit"></i> Reddit
</a>
<a class="item" href="mailto:?subject={{ $urlTitle }}&body=Download%20{{ $urlTitle }}:%20{{ $url }}" title="Email">
    <i class="icon mail"></i> Email
</a>