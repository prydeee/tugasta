<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    @vite('resources/css/app.css') <!-- Assuming you have Vite setup for CSS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js library -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #343a40;
            padding: 10px;
            color: #ffffff;
            text-align: center;
        }
        .header-nav {
            margin-bottom: 20px;
        }
        .header-nav a {
            color: #ffffff;
            text-decoration: none;
            margin: 0 10px;
        }
        .header-nav a:hover {
            text-decoration: underline;
        }
        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }
        .card {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .card img {
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .card h3 {
            margin: 10px 0;
        }
        .card button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        .card button:hover {
            background-color: #0056b3;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            border-radius: 5px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .pie-chart {
            width: 100%;
            height: 300px;
        }
        .search-form {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
        }
        .search-form input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
            max-width: 400px;
        }
    </style>
</head>
<body>
<header>
    <div class="header-nav">
        @auth
            <a href="{{ route('dashboard') }}">Dashboard</a>
        @else
            <a href="{{ route('login') }}">Login</a> |
            <a href="{{ route('register') }}">Register</a>
        @endauth
    </div>
    <h1>Selamat Datang di Aplikasi Review Buku !</h1>
</header>

    <main class="container">
        <div class="search-form">
            <input type="text" id="search" placeholder="Cari buku...">
        </div>
        <div id="bookGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($bookData as $book)
                <div class="card" data-book-id="{{ $book['id_buku'] }}" data-book-name="{{ $book['nama_buku'] }}">
                    <img src="{{ $book['sampul_buku'] }}" alt="Cover Buku" class="w-32 h-40 object-cover">
                    <h3 class="text-xl font-semibold">{{ $book['nama_buku'] }}</h3>
                    <p>Jumlah Review: {{ $book['review_count'] }}</p>
                    <canvas id="pieChart-{{ $book['id_buku'] }}" class="pie-chart"></canvas>
                    <button onclick="showReviews({{ $book['id_buku'] }})">Detail Review</button><br>
                    <a href="{{ route('register') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah Review</a>
                </div>
            @endforeach
        </div>
    </main>

    <!-- Modal for Review Details -->
    <div id="reviewModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 class="text-xl font-bold mb-4">Review Details</h2>
            <div id="reviewList"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @foreach($bookData as $book)
                const ctx{{ $book['id_buku'] }} = document.getElementById('pieChart-{{ $book['id_buku'] }}').getContext('2d');
                new Chart(ctx{{ $book['id_buku'] }}, {
                    type: 'pie',
                    data: {
                        labels: @json(array_keys($book['genre_distribution'])),
                        datasets: [{
                            data: @json(array_values($book['genre_distribution'])),
                            backgroundColor: [
                                '#FF6384', '#36A2EB', '#FFCE56', 
                                '#4BC0C0', '#9966FF', '#FF9F40'
                            ],
                        }]
                    },
                    options: {
                        responsive: false,
                        maintainAspectRatio: false,
                    }
                });
            @endforeach

            // Modal functionality
            var modal = document.getElementById("reviewModal");
            var span = document.getElementsByClassName("close")[0];

            span.onclick = function() {
                modal.style.display = "none";
            }

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        });

        // Client-side search
        document.getElementById('search').addEventListener('input', function() {
            const searchQuery = this.value.toLowerCase();
            document.querySelectorAll('#bookGrid .card').forEach(function(card) {
                const bookName = card.getAttribute('data-book-name').toLowerCase();
                if (bookName.includes(searchQuery)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        function showReviews(bookId) {
            fetch(`/get-reviews/${bookId}`)
                .then(response => response.json())
                .then(data => {
                    const reviewList = document.getElementById('reviewList');
                    reviewList.innerHTML = '';
                    data.reviews.forEach(review => {
                        const reviewItem = document.createElement('div');
                        reviewItem.innerHTML = `
                            <p><strong>${review.user.name}</strong></p> <!-- Access user name here -->
                            <p><small>${new Date(review.created_at).toLocaleDateString()}</small></p>
                            <p>${review.review_buku}</p>
                            <hr />
                        `;
                        reviewList.appendChild(reviewItem);
                    });
                    document.getElementById('reviewModal').style.display = 'block';
                })
                .catch(error => console.error('Error fetching reviews:', error));
        }


    </script>
</body>
</html>
