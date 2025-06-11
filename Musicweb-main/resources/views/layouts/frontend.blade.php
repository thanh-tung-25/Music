<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MusicWeb</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a2d9d5d66a.js" crossorigin="anonymous"></script>
</head>
<body class="bg-gray-900 text-white font-sans">

    <nav class="bg-gray-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-purple-400">🎵 MusicWeb</h1>
            <ul class="flex gap-6">
                <li><a href="/music" class="hover:text-purple-300">Trang chủ</a></li>
                <li><a href="#" class="hover:text-purple-300">Nghệ sĩ</a></li>
                <li><a href="#" class="hover:text-purple-300">Thể loại</a></li>
                <li><a href="#" class="hover:text-purple-300">Playlist</a></li>
            </ul>
        </div>
    </nav>

    <main class="py-10 px-6 md:px-16">
        @yield('content')
    </main>

    <footer class="bg-gray-800 text-center py-6 mt-10">
        <p class="text-sm text-gray-400">© 2025 MusicWeb. All rights reserved.</p>
    </footer>

</body>
</html>
