<!DOCTYPE html>
<html>
<head>
    <title>{{ $tutorial->title }} - PDF</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-family: DejaVu, sans-serif; /* Font yang lebih kompatibel */
            font-size: 12pt;
            line-height: 1.5; /* Spasi baris yang lebih baik */
        }

        .section {
            margin-bottom: 20px;
            padding: 10px;
            border-bottom: 1px solid #eee; /* Garis pemisah untuk kejelasan */
        }

        .code {
            background-color: #f4f4f4;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: monospace;
            white-space: pre-wrap;
            word-break: break-all;
            margin-bottom: 10px;
            font-size: 10pt;
            line-height: 1.2;
        }

        p {
            margin-bottom: 10px;
            text-align: justify; /* Rata kiri-kanan untuk kerapian */
            white-space: pre-line;
        }

        img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
        }

        h1 {
            font-size: 18pt;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <h1>{{ $tutorial->title }}</h1>

    @foreach ($details as $detail)
        <div class="section">
            @if ($detail->text)
                <p><?php echo nl2br(e($detail->text)); ?></p>
            @endif

            @if ($detail->image)
                <img src="{{ asset('storage/' . $detail->image) }}" alt="Gambar Tutorial">
            @endif
            
            @if ($detail->code)
                <pre class="code"><?php echo e($detail->code); ?></pre>
            @endif

            @if ($detail->url)
                <p>Link: {{ $detail->url }}</p>
            @endif
        </div>
    @endforeach
</body>
</html>
