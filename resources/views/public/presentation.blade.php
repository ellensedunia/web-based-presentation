<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $tutorial->title }} - Presentation</title>
    @vite('resources/css/app.css')
    <meta http-equiv="refresh" content="10">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github-dark.min.css">
</head>
<body class="p-6 bg-gray-100">
    <h1 class="text-2xl font-bold mb-4">{{ $tutorial->title }}</h1>

    @foreach ($details as $detail)
        <div class="mb-6 bg-white p-4 rounded shadow">
            @if ($detail->text)
                <p class="mb-2">{{ $detail->text }}</p>
            @endif

            @if ($detail->image)
                <img src="{{ asset('storage/' . $detail->image) }}" class="w-full max-w-md mb-2">
            @endif

            @if ($detail->code)
                <div class="relative group bg-gray-800 rounded-md p-2">
                    <div class="flex items-center justify-between">
                       <span class="text-white text-xs  px-2 py-1 "></span>
                        <button class="copy-button  text-white text-xs  px-2 py-1  transition-opacity"
                                data-clipboard-text="{{ $detail->code }}">
                            Copy
                        </button>
                    </div>
                    <pre class=" text-white  text-sm overflow-x-auto">
                        <code class="language-php">{{ $detail->code }}</code>
                    </pre>
                </div>
            @endif

            @if ($detail->url)
                <a href="{{ $detail->url }}" target="_blank" class="text-blue-600 underline">Lihat Link Tambahan</a>
            @endif
        </div>
    @endforeach

    <script src="https://cdn.jsdelivr.net/npm/clipboard@2/dist/clipboard.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', (event) => {
        // Initialize Clipboard.js
        const clipboard = new ClipboardJS('.copy-button');

        clipboard.on('success', function(e) {
            e.trigger.textContent = 'Copied!';
            setTimeout(function() {
                e.trigger.textContent = 'Copy';
            }, 2000);
        });

        clipboard.on('error', function(e) {
            e.trigger.textContent = 'Error!';
            setTimeout(function() {
                e.trigger.textContent = 'Copy';
            }, 2000);
        });

        // Initialize Highlight.js
        document.querySelectorAll('pre code').forEach((el) => {
            hljs.highlightElement(el);
        });
    });
    </script>
</body>
</html>
