<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product Label</title>
    @vite(['resources/css/pdf.css'])
</head>

<body class="p-2">
    @foreach ($products->chunk(2) as $products_chunk)
        <div class="grid grid-cols-2 gap-4 h-[190mm] break-inside-avoid">
            @foreach ($products_chunk as $product)
                @php
                    $icon_url = $product !== null && ($product['icon_url'] ?? '') !== ''
                        ? $product['icon_url']
                        : 'https://placehold.co/600x600?text=No+image';
                @endphp
                <div class="p-10 relative w-full h-full">
                    <div class="grid grid-cols-3 absolute bottom-10 left-10 right-4 z-10">
                        <div class="border-2 border-black w-full aspect-square bg-white p-2 relative before:absolute before:bg-white before:w-2 before:h-0.5 before:-top-0.5 before:left-0 after:absolute after:bg-white after:w-0.5 after:h-2 after:bottom-0 after:-right-0.5">
                            <div class="border-2 border-black w-full aspect-square"></div>
                        </div>
                        <div class="col-span-2 invisible"></div>
                    </div>
                    <div class="grid h-full min-h-0 gap-2 p-2 border-2 border-black grid-rows-[auto_1fr_auto]">
                        <header class="grid items-center grid-cols-3 gap-2">
                            <div class="flex items-center justify-center h-24 p-4 border-2 border-black">
                                <h1 class="text-2xl font-extrabold uppercase">Location</h1>
                            </div>
                            <div class="h-24 col-span-2 border-2 border-black"></div>
                        </header>
                        <section class="min-h-0 border-2 border-black p-2">
                            @if ($product !== null)
                                <div class="grid h-full content-start justify-items-center">
                                    <figure class="size-60 block mx-auto border border-black">
                                        <img
                                            class="w-full h-full object-contain"
                                            src="{{ $icon_url }}"
                                            alt="{{ $product['title'] !== '' ? $product['title'] : 'Product image' }}"
                                        >
                                    </figure>
                                    <p class="text-2xl font-extrabold leading-none text-center mt-4">{{ $product['title'] }}</p>
                                    @if (($product['subtitle'] ?? '') !== '')
                                        <p class="text-xl leading-none text-center mt-2">{{ $product['subtitle'] }}</p>
                                    @endif
                                </div>
                            @endif
                        </section>
                        <footer class="grid grid-cols-3 gap-2">
                            <div class="invisible w-full"></div>
                            <div class="box-content flex flex-col justify-end col-span-2 border-2 border-black p-4 relative before:absolute before:bg-white before:w-0.5 before:h-2 before:-top-2.5 before:-left-0.5 before:z-20">
                                <div class="flex items-center justify-end gap-2">
                                    <p class="font-extrabold uppercase">Tub / Nally</p>
                                    <span class="border-2 border-black w-14 aspect-square"></span>
                                    <p class="font-extrabold uppercase">of</p>
                                    <span class="border-2 border-black w-14 aspect-square"></span>
                                </div>
                            </div>
                        </footer>
                    </div>
                </div>
            @endforeach
        </div>
        @unless ($loop->last)
            @pageBreak
        @endunless
    @endforeach
</body>

</html>