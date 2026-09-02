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
    @foreach ($products->chunk(14) as $product_chunk)
        <div class="grid grid-cols-2 gap-y-[5mm] gap-x-[10mm]">
            @foreach ($product_chunk as $product)
            @php
                $qr = Quar::size(106)->generate("https://mphaustralia.current-rms.com/products/{$product['id']}");
            @endphp
                <div class="flex gap-2 p-3 w-[80mm] h-[35mm]">
                    <div class="aspect-square shrink-0">
                        {{ $qr }}
                    </div>
                    <div class="flex flex-col justify-between text-xs">
                        <p>{{ $product['title'] }}</p>
                        <p class="font-black">{{ $product['subtitle'] }}</p>
                        <div class="flex items-baseline gap-2">
                            <p class="uppercase">Stock unit:</p>
                            <p>{{ $product['stock_unit'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @unless($loop->last)
            @pageBreak
        @endunless
    @endforeach
</body>

</html>