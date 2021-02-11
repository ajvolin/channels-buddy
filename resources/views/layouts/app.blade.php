<html lang="en">
    <head>
        <meta charset="utf-8">
		<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,initial-scale=1.0,user-scalable=no,shrink-to-fit=no" />
        <title>{{ env('APP_NAME', 'Channels Buddy') }}</title>
        {{-- Styles section --}}
        <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
        {{-- Scripts section --}}
    </head>
    <body>
        @inertia
    </body>
    <script>
        let app_name = "{{ env('APP_NAME', 'Channels Buddy') }}";
    </script>
    @routes
    <script src="{{ asset(mix('js/manifest.js')) }}" defer></script>
    <script src="{{ asset(mix('js/vendor.js')) }}" defer></script>
    <script src="{{ asset(mix('js/app.js')) }}" defer></script>
</html>