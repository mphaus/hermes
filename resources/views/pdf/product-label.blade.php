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
        <div
            class="border-2 border-black size-58 p-2 absolute left-0 bottom-0 bg-white z-10 border-l-0 border-b-0 before:absolute before:w-2 before:h-0.5 before:bg-white before:-top-0.5 before:left-0 before:z-10 after:absolute after:w-0.5 after:h-2 after:bg-white after:z-10 after:-right-0.5 after:bottom-0">
            <div
                class="border-2 border-black h-full relative after:absolute after:w-0.5 after:h-2 after:bg-white after:z-10 after:-right-3 after:top-18">
            </div>
        </div>
    </main>
</body>

</html>