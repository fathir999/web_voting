<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Voting System</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-green-500 to-blue-600 min-h-screen flex items-center justify-center">
  <div class="bg-white rounded-lg shadow-2xl flex flex-col md:flex-row w-full max-w-4xl overflow-hidden mx-4 sm:mx-6">
    
    <!-- Kolom kiri (opsional gambar) -->
    <div id="imageBox" class="hidden md:flex md:w-1/2 bg-cover bg-center transition-all duration-1000">
    </div>

    <!-- Kolom kanan untuk form -->
    <div class="w-full md:w-1/2 p-6 sm:p-10 flex items-center justify-center">
      <div class="w-full max-w-sm">
        <div class="text-center mb-8">
          <h1 class="text-3xl font-bold text-gray-800">Daftar Akun</h1>
          <p class="text-gray-600 mt-2">Buat akun untuk mulai voting</p>
        </div>

        @if($errors->any())
          <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            @foreach($errors->all() as $error)
              <p>{{ $error }}</p>
            @endforeach
          </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
          @csrf

          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Nama Lengkap</label>
            <input 
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight 
                     focus:outline-none focus:ring-2 focus:ring-green-500"
              id="name" 
              type="text" 
              name="name" 
              value="{{ old('name') }}" 
              placeholder="John Doe" 
              required>
          </div>

          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
            <input 
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight 
                     focus:outline-none focus:ring-2 focus:ring-green-500"
              id="email" 
              type="email" 
              name="email" 
              value="{{ old('email') }}" 
              placeholder="email@example.com" 
              required>
          </div>

          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
            <input 
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight 
                     focus:outline-none focus:ring-2 focus:ring-green-500"
              id="password" 
              type="password" 
              name="password" 
              placeholder="••••••••" 
              required>
          </div>

          <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password_confirmation">
              Konfirmasi Password
            </label>
            <input 
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight 
                     focus:outline-none focus:ring-2 focus:ring-green-500"
              id="password_confirmation" 
              type="password" 
              name="password_confirmation" 
              placeholder="••••••••" 
              required>
          </div>

          <button 
            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded 
                   focus:outline-none focus:shadow-outline w-full" 
            type="submit">
            Daftar
          </button>

          <p class="text-center text-gray-600 mt-4">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="text-green-500 hover:text-green-700 font-semibold">
              Login di sini
            </a>
          </p>
        </form>
      </div>
    </div>
  </div>

  <script>
    // Jika ingin pakai gambar berganti otomatis, sama seperti di login
    const images = [
      "https://www.shutterstock.com/image-photo/kulonprogo-indonesia-sept-10-2025-600nw-2675165167.jpg",
       "https://validity.ngo/wp-content/uploads/2022/08/vote-Getty-Royalty-Free.jpg",
      "https://www.shutterstock.com/image-photo/dataran-tinggi-dieng-atau-dikenal-600nw-1788197321.jpg",
      "https://www.computerworld.com/wp-content/uploads/2024/03/cw_mobile_voting_by_inueng_and_filo_gettyimages_3x2_1200x800-100772605-orig.jpg?quality=50&strip=all"
    ];

    let index = 0;
    const imageBox = document.getElementById("imageBox");
    imageBox.style.backgroundImage = `url('${images[index]}')`;

    setInterval(() => {
      index = (index + 1) % images.length;
      imageBox.style.backgroundImage = `url('${images[index]}')`;
    }, 10000);
  </script>
</body>
</html>
