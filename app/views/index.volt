<!DOCTYPE html>
<html lang="zh-cn" class="h-100" data-bs-theme="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>欢迎来到 Vökuró</title>
        {{ assets.outputCss('css') }}
    </head>
    <body class="d-flex flex-column h-100">
        {{ content() }}
        {{ assets.outputJs('js') }}
    </body>
</html>
