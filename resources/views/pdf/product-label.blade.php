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
        @for ($i = 0; $i < 2; $i++)
            <div class="relative flex flex-col flex-1 h-full min-h-0 gap-2 p-2 border-2 border-black">
                <div class="absolute aspect-square w-[calc((1/3*100%)+0.438rem)] border-2 border-black bottom-0 left-0 z-10 bg-white border-l-0 border-b-0 p-2 before:absolute before:h-0.5 before:w-2 before:bg-white before:-top-0.5 before:left-0 before:z-10 after:absolute after:h-2 after:w-0.5 after:bg-white after:-right-0.5 after:bottom-0 after:z-10">
                    <div class="h-full border-2 border-black"></div>
                </div>
                <header class="grid items-center grid-cols-3 gap-2">
                    <div class="flex items-center justify-center h-24 p-4 border-2 border-black">
                        <h1 class="text-4xl font-extrabold uppercase">Location</h1>
                    </div>
                    <div class="h-24 col-span-2 border-2 border-black"></div>
                </header>
                <section class="flex-1 min-h-0 border-2 border-black"></section>
                <footer class="grid items-center grid-cols-3 gap-2">
                    <div></div>
                    <div class="box-content flex flex-col justify-center col-span-2 p-6 border-2 border-black relative before:absolute before:h-2 before:w-0.5 before:bg-white before:-top-2.5 before:-left-0.5 before:z-20">
                        <div class="flex items-center justify-end gap-2">
                            <p class="text-2xl font-extrabold uppercase">Tub / Nally</p>
                            <span class="border-2 border-black size-14"></span> 
                            <p class="text-2xl font-extrabold uppercase">of</p>
                            <span class="border-2 border-black size-14"></span>
                        </div>
                    </div>
                </footer>
            </div>
        @endfor
    </div>
</body>

</html>