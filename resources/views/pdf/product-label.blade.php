<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product Label</title>
    @vite(['resources/css/pdf.css'])
</head>

<body class="flex flex-col h-full p-2 min-h-dvh">
    <div class="flex flex-row flex-1 w-full h-full min-h-0 gap-4">
        @for ($i = 0; $i < 1; $i++)
            <div class="p-10 relative">
                <div class="grid grid-cols-3 absolute bottom-10 left-10 right-4 z-10">
                    <div class="border-2 border-black w-full aspect-square bg-white p-2 relative before:absolute before:bg-white before:w-2 before:h-0.5 before:-top-0.5 before:left-0 after:absolute after:bg-white after:w-0.5 after:h-2 after:bottom-0 after:-right-0.5">
                        <div class="border-2 border-black w-full aspect-square"></div>
                    </div>
                    <div class="col-span-2 invisible"></div>
                </div>
                <div class="flex flex-col flex-1 h-full min-h-0 gap-2 p-2 border-2 border-black">
                    <header class="grid items-center grid-cols-3 gap-2">
                        <div class="flex items-center justify-center h-24 p-4 border-2 border-black">
                            <h1 class="text-4xl font-extrabold uppercase">Location</h1>
                        </div>
                        <div class="h-24 col-span-2 border-2 border-black"></div>
                    </header>
                    <section class="flex-1 min-h-0 border-2 border-black"></section>
                    <footer class="grid grid-cols-3 gap-2">
                        <div class="invisible w-full"></div>
                        <div class="box-content flex flex-col justify-end col-span-2 border-2 border-black p-6 relative before:absolute before:bg-white before:w-0.5 before:h-2 before:-top-2.5 before:-left-0.5 before:z-20">
                            <div class="flex items-center justify-end gap-2">
                                <p class="text-2xl font-extrabold uppercase">Tub / Nally</p>
                                <span class="border-2 border-black w-14 aspect-square"></span>
                                <p class="text-2xl font-extrabold uppercase">of</p>
                                <span class="border-2 border-black w-14 aspect-square"></span>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
        @endfor
    </div>
</body>

</html>