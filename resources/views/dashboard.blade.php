<x-app-layout :title="'Dashboard '">
    <div class="md:px-12 px-6 md:py-6 py-4">
        <!-- Header Section -->
        <section class="bg-[--primary] text-white p-6 rounded-md shadow-md mb-6">
            <h1 class="text-3xl font-medium">Selamat Datang, {{auth()->user()->name}}</h1>
            <p class="mt-2">Pantau dan kelola surat dengan mudah di sini.</p>
        </section>

        <!-- Main Statistics Section -->
        <div class="grid md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-6 mb-8">
            <!-- Surat Masuk -->
            <article class="bg-white border  p-6 rounded-md">
                <div class="flex justify-between items-center">
                    <span class="font-semibold text-lg">Surat Masuk</span>
                    <i class="text-2xl fa fa-envelope text-blue-500"></i>
                </div>
                <span class="text-4xl font-bold text-blue-500">20</span>
                <p class="text-slate-500 mt-2">Surat diterima hari ini</p>
            </article>

            <!-- Surat Keluar -->
            <article class="bg-white border  p-6 rounded-md">
                <div class="flex justify-between items-center">
                    <span class="font-semibold text-lg">Surat Keluar</span>
                    <i class="text-2xl fa fa-envelope text-green-500"></i>
                </div>
                <span class="text-4xl font-bold text-green-500">12</span>
                <p class="text-slate-500 mt-2">Surat dikirim hari ini</p>
            </article>

            <!-- Pending Approval -->
            <article class="bg-white border  p-6 rounded-md">
                <div class="flex justify-between items-center">
                    <span class="font-semibold text-lg">Persetujuan Tertunda</span>
                    <i class="text-2xl fa fa-circle-info text-yellow-500"></i>
                </div>
                <span class="text-4xl font-bold text-yellow-500">8</span>
                <p class="text-slate-500 mt-2">Surat menunggu persetujuan</p>
            </article>
        </div>

        <div class="grid md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-6">
            <!-- Recent Activities Section -->


            <!-- Performance Chart Section -->
            <section class="col-span-2">
                <h2 class="text-xl font-semibold mb-4">Statistik Surat</h2>
                <div class="bg-white p-6 rounded-md border">
                    <canvas id="performanceChart" class="w-full"></canvas>
                </div>
            </section>
            <section>
                <h2 class="text-xl font-semibold mb-4">Aktivitas Terbaru</h2>
                <div class="bg-white p-6 rounded-md border">
                    <ul class="divide-y divide-slate-200">
                        <li class="py-4 flex-col  flex  ">
                            <span>Surat masuk dari Kecamatan diterima.</span>
                            <span class="text-sm text-slate-500">20 Jan 2025, 10:00 AM</span>
                        </li>
                        <li class="py-4 flex flex-col   ">
                            <span>Surat keluar ke Dinas dikirim.</span>
                            <span class="text-sm text-slate-500">20 Jan 2025, 09:30 AM</span>
                        </li>
                        <li class="py-4 flex flex-col   ">
                            <span>Surat menunggu persetujuan Lurah.</span>
                            <span class="text-sm text-slate-500">19 Jan 2025, 04:00 PM</span>
                        </li>
                    </ul>
                </div>
            </section>
        </div>
    </div>

    <!-- Script for Chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('performanceChart').getContext('2d');
        const performanceChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'],
                datasets: [{
                    label: 'Surat Masuk',
                    data: [12, 15, 9, 11, 13],
                    borderColor: '#3b82f6',
                    fill: false
                }, {
                    label: 'Surat Keluar',
                    data: [8, 10, 5, 7, 9],
                    borderColor: '#10b981',
                    fill: false
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</x-app-layout>