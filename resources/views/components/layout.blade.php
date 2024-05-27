<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gemeinsames Mittagessen Tool</title>

    @vite('resources/css/app.css')
    <link rel="stylesheet" type="text/css" href="{{ asset('style.css?v=') . time() }}" />
</head>

<body class="overflow-y-auto">
    <div
        class="p-3 fixed z-10 md:w-[160px] text-center justify-normal left-0 right-0 md:text-left  grid grid-cols-4 md:grid-cols-1 rounded-lg">
        <div class="mb-2"><img src="{{ asset('LOGO_WHITE.png') }}" alt="Logo"></div>
        <div><img src="{{ asset('CLAIM_NEGATIVE_RGB.png') }}" alt="Claim"></div>

        <x-nav-link href="/Namen">Mitarbeiter</x-nav-link>

        <x-nav-link href="/">Generator</x-nav-link>

        <x-nav-link href="/Verlauf">Verlauf</x-nav-link>

        <x-nav-link href="/gewinnspiel">Gewinnspiel</x-nav-link>

        <x-nav-link href="/gewinner">Gewinner</x-nav-link>

        <x-nav-link href="/recipes">Rezepte</x-nav-link>

        <x-nav-link href="/logout">Logout</x-nav-link>

    </div>
    {{ $slot }}

</body>

</html>
