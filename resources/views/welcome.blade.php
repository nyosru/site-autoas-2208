<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Детали Авто (Магазин автозапчастей в Тюмени!)</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/app.css') }}?s=260528" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('css/ionicons.min.css') }}"/>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}?s=260528"/>
    <link rel="icon" type="image/png" href="/img/logo1.png"/>

    <meta property="og:title" content="Детали Авто запчасти">
    <meta property="og:site_name" content="детали-авто.рф">
    <meta property="og:url" content="https://детали-авто.рф">

    <meta property="og:description" content="Запчасти для автомобилей">
    <meta property="og:image" content="https://детали-авто.рф/img/logo1.png">
    <meta property="og:image:width" content="300">
    <meta property="og:image:height" content="121">
</head>

<body>

<div id="app"></div>

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (m, e, t, r, i, k, a) {
        m[i] = m[i] || function () {
            (m[i].a = m[i].a || []).push(arguments)
        };
        m[i].l = 1 * new Date();
        k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(
            k, a)
    })
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    ym(89950536, "init", {
        clickmap: true,
        trackLinks: true,
        accurateTrackBounce: true
    });
</script>
<noscript>
    <div><img src="https://mc.yandex.ru/watch/89950536" style="position:absolute; left:-9999px;" alt=""/>
    </div>
</noscript>
<!-- /Yandex.Metrika counter -->

</body>

<script src="{{ asset('js/app.js') }}?s=2401280125"></script>

</html>
