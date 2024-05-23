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
    class="z-10 p-5 fixed top-0 lg:w-[180px] text-center justify-normal left-0 right-0 lg:text-left grid grid-cols-4 lg:grid-cols-1 rounded-lg">

        <x-nav-link href="/Namen">Mitarbeiter</x-nav-link>

        <x-nav-link href="/">Generator</x-nav-link>

        <x-nav-link href="/Verlauf">Verlauf</x-nav-link>

        <x-nav-link href="/gewinnspiel">Gewinnspiel</x-nav-link>

        <x-nav-link href="/gewinner">Gewinner</x-nav-link>

        <x-nav-link href="/recipes">Recipes</x-nav-link>

        <x-nav-link href="/logout">Logout</x-nav-link>

    </div>
    {{ $slot }}

</body>

</html>
