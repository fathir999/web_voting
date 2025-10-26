<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Voting System</title>
  <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gradient-to-br from-blue-500 to-purple-600 min-h-screen flex items-center justify-center py-8">

  <div class="bg-white rounded-lg shadow-2xl flex flex-col md:flex-row w-full max-w-4xl overflow-hidden mx-4 sm:mx-6">

    <!-- Kolom kiri: gambar -->
    <div id="imageBox" class="hidden md:flex md:w-1/2 bg-cover bg-center transition-all duration-1000">
    </div>

    <!-- Kolom kanan: form login -->
    <div class="w-full md:w-1/2 p-6 sm:p-10 flex items-center justify-center">
      <div class="w-full max-w-sm">
        <div class="text-center mb-8">
          <h1 class="text-3xl font-bold text-gray-800">Masuk Akun</h1>
          <p class="text-gray-600 mt-2">Login untuk mulai voting</p>
        </div>

        @if ($errors->any())
          <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            @foreach ($errors->all() as $error)
              <p>{{ $error }}</p>
            @endforeach
          </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
          @csrf

          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
              Email
            </label>
            <input
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500"
              id="email" type="email" name="email" value="{{ old('email') }}" placeholder="email@example.com" required>
          </div>

          <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
              Password
            </label>
            <input
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500"
              id="password" type="password" name="password" placeholder="••••••••" required>
          </div>

          <button
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full"
            type="submit">
            Login
          </button>

          <div class="text-center mt-4">
            <p class="text-gray-600">Belum punya akun?
              <a href="{{ route('register') }}" class="text-blue-500 hover:text-blue-700 font-semibold">
                Daftar di sini
              </a>
            </p>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Script Ganti Gambar -->
  <script>
    const images = [
      "https://static.vecteezy.com/system/resources/thumbnails/040/890/255/small/ai-generated-empty-wooden-table-on-the-natural-background-for-product-display-free-photo.jpg",
      "https://i.pinimg.com/736x/78/54/f5/7854f559189799cc8a2d149d049bdb74.jpg",
      "https://media.istockphoto.com/id/1186879378/photo/green-park-blur-bokeh-background.jpg?s=612x612&w=0&k=20&c=Tuw-hS-znc-nw_CpIcxZ6s5AjjRpCEzGhJ1n08En098="
    ];

    const imageBox = document.getElementById("imageBox");
    let index = 0;

    function changeImage() {
      imageBox.style.backgroundImage = `url('${images[index]}')`;
      index = (index + 1) % images.length;
    }

    // Mulai dan ganti tiap 5 detik
    changeImage();
    setInterval(changeImage, 10000);
  </script>

</body>
</html>
