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
</head>

<body class="font-sans antialiased">

    <div class="bg-gray-50 min-h-screen flex items-center justify-center px-3">
        <div class="lg:w-[900px] border bg-white shadow">
            <div class="py-5">
                <h3 class="font-bold w-full text-center my-10 text-slate-800 text-2xl uppercase"> Restaurant Food
                    Ordering
                </h3>


                <div class="px-10 space-y-5">
                    <h2 class="font-bold text-lg ">New Contact Us Form Submission</h2>
                    <p class="text-md text-gray-700 font-medium ">A user has submitted a new message through the
                        "Contact
                        Us" form on the e-commerce website.
                        Details are as
                        follows:
                    </p>


                    <div class="space-y-3 flex flex-col items-start font-bold text-sm text-gray-800">
                        <div>
                            <span class="text-orange-600">
                                Name
                            </span>
                            : {!! $name !!}
                        </div>
                        <div>
                            <span class="text-orange-600">
                                Email
                            </span> : {!! $email !!}
                        </div>
                        <div>
                            <span class="text-orange-600">
                                Phone
                            </span> : {!! $phone !!}
                        </div>
                        <div>
                            <span class="text-orange-600">
                                Message
                            </span>
                            : {!! $messageDetail !!}
                        </div>
                    </div>

                    <p class="text-md text-gray-700 font-medium ">Please take appropriate action and respond to the
                        user promptly.
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