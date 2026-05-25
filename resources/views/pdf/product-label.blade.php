@use('tbQuar\Facades\Quar')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product Label</title>
    @vite(['resources/css/pdf.css'])
</head>

<body class="font-aptos">
    @foreach ($products->chunk(2) as $products_chunk)
        <div class="grid grid-cols-2 h-198 break-inside-avoid">
            @foreach ($products_chunk as $product)
                @php
                    $icon_url = $product !== null && ($product['icon_url'] ?? '') !== ''
                        ? $product['icon_url']
                        : 'https://placehold.co/600x600?text=No+image';
                    $label_type = $product['label_type'] ?? '';
                    $highlight_classes = $product['highlight_classes'] ?? '';
                    $qr = Quar::size(138)->generate("https://mphaustralia.current-rms.com/products/{$product['id']}");
                @endphp
                <div class="relative w-full h-full p-10">
                    @php
                        $pdf_highlight_class_tokens = [
                            'bg-purple-600 text-white p-2',
                            'bg-red-600 text-white p-2',
                            'bg-blue-600 text-white p-2',
                            'bg-green-600 text-white p-2',
                            'bg-yellow-400 text-black p-2',
                            'bg-orange-500 text-white p-2',
                            'bg-amber-800 text-white p-2',
                            'bg-gray-400 text-black p-2',
                        ];
                    @endphp
                    <img 
                        src="{{ Vite::asset('resources/images/pdf/mph-rings.jpg') }}"
                        class="absolute bottom-0 left-0 -z-1"
                    >
                    <div class="grid grid-cols-3 absolute bottom-10 left-10 right-4 z-10">
                        <div class="border-2 border-black w-full aspect-square bg-white p-2 relative before:absolute before:bg-white before:w-2 before:h-0.5 before:-top-0.5 before:left-0 after:absolute after:bg-white after:w-0.5 after:h-2 after:bottom-0 after:-right-0.5">
                            <div class="border-2 border-black w-full aspect-square flex flex-col items-center justify-center">
                                {{ $qr }}
                            </div>
                        </div>
                        <div class="col-span-2 invisible"></div>
                    </div>
                    <div class="grid h-full min-h-0 gap-2 p-2 border-2 border-black grid-rows-[auto_1fr_auto]">
                        <header class="grid items-center grid-cols-3 gap-2">
                            <div class="flex items-center justify-center h-20 p-4 border-2 border-black">
                                <h1 class="uppercase text-[26px]">Location</h1>
                            </div>
                            <div class="h-20 col-span-2 border-2 border-black"></div>
                        </header>
                        <section class="min-h-0 border-2 border-black p-4">
                            @if ($product !== null)
                                <div @class([
                                    'grid h-full justify-items-center',
                                    'content-start' => $label_type === 'color' || $label_type === 'tub_or_nally_bin',
                                    'place-content-center' => $label_type === 'stored_at_height' || $label_type === 'color_stored_at_height'
                                ])>
                                    <p @class([
                                        'leading-none text-center ' . $highlight_classes,
                                        'text-5xl' => $label_type === 'color' || $label_type === 'tub_or_nally_bin',
                                        'text-6xl' => $label_type === 'stored_at_height' || $label_type === 'color_stored_at_height',
                                    ])>
                                        {{ $product['title'] }}
                                    </p>
                                    @if (($product['subtitle'] ?? '') !== '')
                                        <p @class([
                                            'leading-none text-center mt-2 ' .  $highlight_classes,
                                            'text-3xl' => $label_type === 'tub_or_nally_bin',
                                            'text-4xl' => $label_type === 'stored_at_height',
                                            'text-5xl' => $label_type === 'color',
                                            'text-6xl' => $label_type === 'color_stored_at_height',
                                        ])>
                                            {{ $product['subtitle'] }}
                                        </p>
                                    @endif
                                    @if ($label_type === 'color' || $label_type === 'tub_or_nally_bin')
                                        <figure class="size-70 block mx-auto mt-4">
                                            <img
                                                class="w-full h-full object-contain"
                                                src="{{ $icon_url }}"
                                                alt="{{ $product['title'] !== '' ? $product['title'] : 'Product image' }}"
                                            >
                                        </figure>
                                    @endif
                                </div>
                            @endif
                        </section>
                        <footer class="grid grid-cols-3 gap-2">
                            <div class="invisible w-full"></div>
                            <div class="box-content flex flex-col justify-end col-span-2 border-2 border-black p-4 relative before:absolute before:bg-white before:w-0.5 before:h-2 before:-top-2.5 before:-left-0.5 before:z-20">
                                <div class="flex items-center justify-end gap-2">
                                    <p class="uppercase text-[18px]">Tub / Nally</p>
                                    <span class="border-2 border-black w-14 aspect-square"></span>
                                    <p class="uppercase text-[18px]">of</p>
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