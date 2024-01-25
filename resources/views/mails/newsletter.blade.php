<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Roboto:wght@400;500;700&display=swap"
        rel="stylesheet">

    <script src="https://kit.fontawesome.com/18c274e5f3.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- @vite(['resources/css/app.css']) --}}
</head>

<body class="font-sans antialiased">

    <div class="bg-gray-50 min-h-screen flex items-center justify-center px-3">
        <div class="lg:w-[900px] border bg-white shadow">
            <div class="py-5">
                <h3 class="font-bold w-full text-center my-10 text-slate-800 text-2xl uppercase">
                    Restaurant Food Ordering
                </h3>


                <div class="px-10 space-y-5">
                    <h2 class="font-bold text-lg">{{ $subject }}</h2>
                    <p class="text-sm text-gray-700 font-medium">
                        {!! $content !!}
                    </p>
                </div>
                <hr class="mt-5">
            </div>

            <p class="text-center text-sm font-bold text-gray-600 mb-5">
                This is an automatically generated e-mail.Please do not reply to this e-mail.
            </p>

        </div>
    </div>
</body>

</html>
