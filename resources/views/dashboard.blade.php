<x-app-layout :title="'Dashboard '">
    <div class="md:px-12 px-6 md:py-6 py-4">
        <!-- Header Section -->
        <section class="bg-[--primary] text-white p-6 rounded-md shadow-md mb-6">
            <h1 class="text-3xl font-semibold">Selamat Datang, {{ auth()->user()->name }}</h1>
            <p class="mt-2 text-white/80">Pantau dan kelola surat dengan mudah di sini.</p>
        </section>

        <!-- Main Statistics -->
        <div class="grid md:grid-cols-2 sm:grid-cols-2 grid-cols-1 gap-6 mb-8">
            <!-- Surat Masuk -->
            <article class="flex items-center justify-between p-6 rounded-md bg-blue-50 shadow  transition">
                <div>
                    <h3 class="text-lg font-semibold text-blue-800">Surat Masuk</h3>
                    <p class="text-4xl font-bold text-blue-900 mt-2">{{ $suratMasuk }}</p>
                    <p class="text-sm text-blue-600 mt-1">Hari ini</p>
                </div>
                <div class="bg-blue-100 text-blue-600 p-4 rounded-full text-2xl">
                    <i class="fa-solid fa-envelope"></i>
                </div>
            </article>

            <!-- Surat Keluar -->
            <article class="flex items-center justify-between p-6 rounded-md bg-green-50 shadow  transition">
                <div>
                    <h3 class="text-lg font-semibold text-green-800">Surat Keluar</h3>
                    <p class="text-4xl font-bold text-green-900 mt-2">{{ $suratKeluar }}</p>
                    <p class="text-sm text-green-600 mt-1">Hari ini</p>
                </div>
                <div class="bg-green-100 text-green-600 p-4 rounded-full text-2xl">
                    <i class="fa-solid fa-paper-plane"></i>
                </div>
            </article>
        </div>

        <!-- Statistik Surat -->
        <section class="mb-4 p-0">
            <h2 class="text-xl font-semibold text-slate-700 mb-4">Statistik Surat Mingguan</h2>
            <div class="bg-white p-6 rounded-md border shadow-sm  chart-container">
                <canvas id="performanceChart" class="w-full"></canvas>
            </div>
        </section>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('performanceChart').getContext('2d');
        const performanceChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'],
                datasets: [
                    {
                        label: 'Surat Masuk',
                        data: [12, 15, 9, 11, 13],
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: 'Surat Keluar',
                        data: [8, 10, 5, 7, 9],
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.3,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            color: '#333',
                            font: {
                                size: 14
                            }
                        }
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                },
                interaction: {
                    mode: 'nearest',
                    intersect: false
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#666'
                        }
                    },
                    x: {
                        ticks: {
                            color: '#666'
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>
