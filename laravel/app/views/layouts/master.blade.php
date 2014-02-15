<!--                .syooyhdddds
                  `ohssoyhdhddhd+
                `+so++++oshdhhhhd+
         `.:oyhdhhyyyyysoooshdhhds
              .::/sysyyyhhysoshdy`
        -+:--:::/+Nm+//oshdddhsy+
        :yyys+++/++++//////oyhmdy
        `odmdhyso++syso+o+++++osyy.
         :+ssyyhhhhdhssssssssss+``:
            `-osyyyssssssssssoo- `.--.`
              `ossoooooooooo+/.`.-:::::`
              `osssssssssss/.``...---:/-
             .+yyyyyyyyyyyyssso/-....-::`
           ./oyyhyysosyhhhyyyyys-------:.
         ./ooosso/:::::://++++/:-::----:-
        ./ooo+/ STOP LOOKING --::::::-::-
       `://////// AT SOURCE CODE ///////:`
       `//++//////// AND /////+////+///+:
       `/+++++++++ QUACK OFF +++++++++++-
        -/++oooooooooooooooooooooo+oooo:`
         ./++++oooooooooooooooooooooo/.
          `-/+++++++oooooo+++ooooo/:.
             `.-:/++++oooooo++/-.`
                      ````
                                                         -->

<!DOCTYPE html>
<html class="no-js">
<head>
    @include('partials.head')
</head>
<body data-grid-framework="b3" data-grid-opacity="0.3" data-grid-zindex="10" data-grid-gutterwidth="30px" data-grid-nbcols="16">
@yield('modals')
<div class="wrapper">
    @include('partials.nav')
    @yield('content')
    <div class="push"></div>
</div>
@include('partials.footer')
</body>
@include('partials.scripts')
</html>
