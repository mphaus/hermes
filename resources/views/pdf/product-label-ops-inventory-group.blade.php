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
    @php
        $range = range(0, 13);
    @endphp

    <div class="grid grid-cols-2 gap-y-[5mm] gap-x-[10mm]">
        @foreach ($range as $chunk)
            <div class="flex gap-2 p-3 w-[80mm] h-[35mm] border border-black">
                <div class="aspect-square border border-black shrink-0"></div>
                <div class="flex flex-col justify-between text-sm">
                    <p>Product really long title</p>
                    <p class="font-black">Product really long subtitle</p>
                    <div class="flex items-baseline gap-2">
                        <p class="uppercase">Stock unit:</p>
                        <p>Box of 100</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</body>

</html>