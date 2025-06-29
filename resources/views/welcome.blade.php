<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ইউনিভার্সিটি ট্রান্সপোর্ট তথ্য</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Noto Sans Bengali', sans-serif; scroll-behavior: smooth; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #e0e0e0; }
        ::-webkit-scrollbar-thumb { background: #888; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #555; }
        .section-padding { padding: 80px 0; }
        @media (min-width: 768px) {
            .section-padding { padding: 120px 0; }
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

<div class="w-full min-h-screen flex flex-col">
    <!-- Header / Navigation -->
    <header class="bg-[#0e172a] text-white p-4 sticky top-0 z-50 shadow-md">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <a href="#" class="text-2xl font-bold text-teal-400">{{ $orgs->name }}</a>
            <nav>
                <ul class="flex space-x-6 text-lg font-medium">
                    <li><a href="#notice-panel" class="hover:text-teal-400 transition-colors duration-300">নোটিশ বোর্ড</a></li>
                    <li><a href="#route-list" class="hover:text-teal-400 transition-colors duration-300">রুট তালিকা</a></li>
                    <li><a href="#route-wise-trips" class="hover:text-teal-400 transition-colors duration-300">রুট ওয়াইজ ট্রিপ</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-teal-400 transition-colors duration-300">লগইন</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="flex-1">
        <!-- Hero Section (Simple placeholder) -->
        <section class="bg-gradient-to-r from-blue-700 to-blue-900 text-white py-20 md:py-32 flex items-center justify-center text-center">
            <div class="max-w-4xl mx-auto px-4">
                <h1 class="text-4xl md:text-6xl font-extrabold mb-4 leading-tight">{{ $orgs->name }} পরিবহন তথ্য</h1>
                <p class="text-lg md:text-xl opacity-90">ট্রিপের বিবরণ, রুটের তালিকা এবং গুরুত্বপূর্ণ নোটিশগুলো সহজে খুঁজে নিন।</p>
            </div>
        </section>

        <!-- Notice Panel Section -->
        <section id="notice-panel" class="section-padding bg-gray-50">
            <div class="max-w-6xl mx-auto px-4">
                <h2 class="text-3xl md:text-4xl font-bold text-center text-gray-900 mb-12">গুরুত্বপূর্ণ নোটিশসমূহ</h2>
                <div id="notices-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Notices will be injected here -->
                </div>
            </div>
        </section>

        <!-- Route List Section -->
        <section id="route-list" class="section-padding bg-white">
            <div class="max-w-6xl mx-auto px-4">
                <h2 class="text-3xl md:text-4xl font-bold text-center text-gray-900 mb-12">উপলব্ধ রুটের তালিকা</h2>
                <div id="routes-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($routes as $route)
                        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 cursor-pointer"
                             onclick="showTripsForRoute({{ $route->id }}, '{{ $route->title }}')">
                            <h4 class="font-bold text-xl text-blue-700 mb-2">{{ $route->title }}</h4>
                            <p class="text-gray-600 text-sm">এই রুটের ট্রিপগুলো দেখতে ক্লিক করুন।</p>
                            <span class="mt-4 text-right text-blue-500 hover:text-blue-700">&#10140;</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Route-wise Trips Section -->
        <section id="route-wise-trips" class="section-padding bg-gray-50">
            <div class="max-w-6xl mx-auto px-4">
                <h2 id="selected-route-title" class="text-3xl md:text-4xl font-bold text-center text-gray-900 mb-12">রুট ওয়াইজ ট্রিপ</h2>
                <p class="text-center text-gray-600 mb-8">এখানে নির্বাচিত রুটের জন্য উপলব্ধ সকল ট্রিপের বিবরণ দেখা যাবে।</p>
                <div class="bg-white p-6 md:p-8 rounded-xl shadow-lg border border-gray-100">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left min-w-[700px] text-gray-700">
                            <thead>
                            <tr class="bg-blue-50 text-blue-800 uppercase text-sm leading-normal rounded-lg">
                                <th class="p-4 rounded-tl-lg">শুরুর স্থান</th>
                                <th class="p-4">গন্তব্য</th>
                                <th class="p-4">গাড়ি</th>
                                <th class="p-4">ড্রাইভার</th>
                                <th class="p-4">উদ্দেশ্য</th>
                                <th class="p-4 rounded-tr-lg">তারিখ</th>
                            </tr>
                            </thead>
                            <tbody id="route-trips-table" class="text-gray-600 text-sm font-light">
                                @forelse($trips as $trip)
                                    <tr>
                                        <td class="p-4">{{ $trip->start_location ?? '' }}</td>
                                        <td class="p-4">{{ $trip->destination ?? '' }}</td>
                                        <td class="p-4">{{ $trip->vehicle_registration_number ?? '' }}</td>
                                        <td class="p-4">{{ $trip->driver_name ?? '' }}</td>
                                        <td class="p-4">{{ $trip->purpose ?? '' }}</td>
                                        <td class="p-4">{{ $trip->trip_initiate_date ? \Carbon\Carbon::parse($trip->trip_initiate_date)->format('d-m-Y') : '' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="p-4 text-center text-gray-500">কোনো ট্রিপ পাওয়া যায়নি।</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-[#0e172a] text-gray-400 py-8 text-center text-sm">
        <div class="max-w-6xl mx-auto px-4">
            <p>&copy; 2025 ইউনিভার্সিটি ট্রান্সপোর্ট ম্যানেজমেন্ট সিস্টেম। সর্বস্বত্ব সংরক্ষিত।</p>
        </div>
    </footer>
</div>

<script>
    const trips = @json($trips);

    function showTripsForRoute(routeId, routeTitle) {
        // Filter trips for the selected route
        const filteredTrips = trips.filter(trip => (trip.route_id ?? (trip.route ? trip.route.id : null)) == routeId);

        document.getElementById('selected-route-title').textContent = `রুট ওয়াইজ ট্রিপ: ${routeTitle}`;
        const tbody = document.getElementById('route-trips-table');
        tbody.innerHTML = '';

        if (filteredTrips.length === 0) {
            tbody.innerHTML = `<tr><td colspan="6" class="p-4 text-center text-gray-500">এই রুটের জন্য কোন ট্রিপ পাওয়া যায়নি।</td></tr>`;
            return;
        }

        // Show ALL trips for the selected route
        filteredTrips.forEach(trip => {
            const startLocation = trip.start_location ?? (trip.route ? trip.route.start_location : '');
            const destination = trip.destination ?? (trip.route ? trip.route.destination : '');
            const vehicle = trip.vehicle_registration_number ?? '';
            const driver = trip.driver_name ?? trip.driverId ?? '';
            const purpose = trip.purpose ?? '';
            const date = trip.trip_initiate_date
                ? toBengali(new Date(trip.trip_initiate_date).toLocaleDateString('bn-BD'))
                : (trip.date ? toBengali(new Date(trip.date).toLocaleDateString('bn-BD')) : '');

            const row = `
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors duration-200">
                    <td class="p-4">${startLocation}</td>
                    <td class="p-4">${destination}</td>
                    <td class="p-4">${vehicle}</td>
                    <td class="p-4">${driver}</td>
                    <td class="p-4">${purpose}</td>
                    <td class="p-4">${date}</td>
                </tr>
            `;
            tbody.innerHTML += row;
        });

        document.getElementById('route-wise-trips').scrollIntoView({ behavior: 'smooth' });
    }

    // If you use toBengali, make sure it's also in the global scope:
    function toBengali(n) {
        return n.toString().replace(/\d/g, d => '০১২৩৪৫৬৭৮৯'[d]);
    }
</script>
</body>
</html>
