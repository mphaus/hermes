<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product Label</title>
    @vite(['resources/css/pdf.css'])
</head>

<body class="flex flex-col p-2 min-h-dvh">
    <main class="flex-1 p-2 border-black border-2 flex flex-col gap-2 relative">
        <header class="flex gap-2 items-center">
            <div class="border-2 border-black h-24 p-4 flex items-center justify-center w-56">
                <h1 class="text-4xl uppercase font-extrabold">Location</h1>
            </div>
            <div class="border-2 border-black h-24 flex-1"></div>
        </header>
        <section class="border-2 border-black flex-1"></section>
        <footer class="border-2 border-black flex items-center justify-end gap-4 p-6">
            <p class="uppercase font-extrabold text-2xl">Tub / Nally</p>
            <span class="border-2 border-black size-20"></span>
            <p class="uppercase font-extrabold text-2xl">of</p>
            <span class="border-2 border-black size-20"></span>
        </footer>
        <div class="border-2 border-black size-58 p-2 absolute left-0 bottom-0 bg-white z-10 border-l-0 border-b-0">
            <div class="border-2 border-black h-full"></div>
            <div class="absolute h-1 bg-white w-2 -top-1 left-0 z-20"></div>
            <div class="absolute bg-white w-1 z-20 -right-1 h-2 top-20.5"></div>
            <div class="absolute bg-white w-1 z-20 bottom-0 -right-1 h-2"></div>
        </div>
    </main>
</body>

</html>