<!-- CHARTS + STATS GRID -->
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

    <!-- BIG ANALYTICS CHART -->
    <div class="xl:col-span-2 bg-white rounded-[30px] p-6 border border-gray-100 shadow-sm">

        <!-- HEADER -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>
                <h2 class="text-2xl font-black text-gray-900">
                    Sales Analytics
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Performance overview for listings and views
                </p>
            </div>

            <div class="flex items-center gap-3">

                <button class="px-4 py-2 rounded-2xl bg-indigo-600 text-white text-sm font-semibold shadow-lg">
                    Monthly
                </button>

                <button class="px-4 py-2 rounded-2xl bg-gray-100 text-gray-700 text-sm font-semibold">
                    Weekly
                </button>

            </div>

        </div>

        <!-- CHART -->
        <div class="mt-10">

            <!-- Y AXIS + GRAPH -->
            <div class="flex">

                <!-- Y AXIS -->
                <div class="flex flex-col justify-between text-xs text-gray-400 pr-4 h-72">

                    <span>100</span>
                    <span>80</span>
                    <span>60</span>
                    <span>40</span>
                    <span>20</span>
                    <span>0</span>

                </div>

                <!-- GRAPH AREA -->
                <div class="relative flex-1 h-72 border-l border-b border-gray-200">

                    <!-- HORIZONTAL LINES -->
                    <div class="absolute inset-0 flex flex-col justify-between">

                        <div class="border-t border-dashed border-gray-200"></div>
                        <div class="border-t border-dashed border-gray-200"></div>
                        <div class="border-t border-dashed border-gray-200"></div>
                        <div class="border-t border-dashed border-gray-200"></div>
                        <div class="border-t border-dashed border-gray-200"></div>

                    </div>

                    <!-- LINE GRAPH -->
                    <svg class="absolute inset-0 w-full h-full"
                        viewBox="0 0 700 300"
                        preserveAspectRatio="none">

                        <!-- AREA -->
                        <path d="
                            M0 220
                            C80 190, 120 160, 180 180
                            S300 80, 360 110
                            S500 170, 560 120
                            S650 40, 700 70
                            L700 300
                            L0 300
                            Z"
                            fill="rgba(79,70,229,0.12)" />

                        <!-- LINE -->
                        <path d="
                            M0 220
                            C80 190, 120 160, 180 180
                            S300 80, 360 110
                            S500 170, 560 120
                            S650 40, 700 70"
                            fill="none"
                            stroke="#4F46E5"
                            stroke-width="5"
                            stroke-linecap="round" />

                        <!-- POINTS -->
                        <circle cx="180" cy="180" r="7" fill="#4F46E5"/>
                        <circle cx="360" cy="110" r="7" fill="#4F46E5"/>
                        <circle cx="560" cy="120" r="7" fill="#4F46E5"/>
                        <circle cx="700" cy="70" r="7" fill="#4F46E5"/>

                    </svg>

                </div>

            </div>

            <!-- X AXIS -->
            <div class="flex justify-between text-xs text-gray-400 mt-4 pl-10">

                <span>Jan</span>
                <span>Feb</span>
                <span>Mar</span>
                <span>Apr</span>
                <span>May</span>
                <span>Jun</span>
                <span>Jul</span>

            </div>

        </div>

    </div>


    <!-- RIGHT SIDE -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-1 gap-6">

        <!-- TOTAL LISTINGS -->
        <div class="relative overflow-hidden bg-white rounded-[30px] p-6 border border-gray-100 shadow-sm">

            <div class="absolute -top-10 -right-10 w-40 h-40 bg-indigo-100 rounded-full blur-3xl opacity-40"></div>

            <div class="relative">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm text-gray-500 font-medium">
                            Total Listings
                        </p>

                        <h2 class="text-4xl font-black mt-2 text-gray-900">
                            120
                        </h2>
                    </div>

                    <div class="w-14 h-14 rounded-2xl bg-indigo-50 flex items-center justify-center">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-7 h-7 text-indigo-600"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 7l9-4 9 4-9 4-9-4z"/>

                        </svg>

                    </div>

                </div>

                <!-- MINI BAR GRAPH -->
                <div class="flex items-end gap-2 h-24 mt-8">

                    <div class="bg-indigo-200 rounded-t-xl w-full h-10"></div>
                    <div class="bg-indigo-300 rounded-t-xl w-full h-16"></div>
                    <div class="bg-indigo-400 rounded-t-xl w-full h-12"></div>
                    <div class="bg-indigo-500 rounded-t-xl w-full h-20"></div>
                    <div class="bg-indigo-600 rounded-t-xl w-full h-14"></div>

                </div>

                <div class="mt-6 flex items-center justify-between">

                    <div>
                        <p class="text-xs text-gray-400">
                            Monthly Growth
                        </p>

                        <h4 class="font-bold text-lg mt-1">
                            +12%
                        </h4>
                    </div>

                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                        Excellent
                    </span>

                </div>

            </div>

        </div>


        <!-- ACTIVE ITEMS -->
        <div class="relative overflow-hidden bg-white rounded-[30px] p-6 border border-gray-100 shadow-sm">

            <div class="absolute -top-10 -right-10 w-40 h-40 bg-green-100 rounded-full blur-3xl opacity-40"></div>

            <div class="relative">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm text-gray-500 font-medium">
                            Active Items
                        </p>

                        <h2 class="text-4xl font-black mt-2 text-green-600">
                            85
                        </h2>
                    </div>

                    <div class="w-14 h-14 rounded-2xl bg-green-50 flex items-center justify-center">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-7 h-7 text-green-600"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M5 13l4 4L19 7"/>

                        </svg>

                    </div>

                </div>

                <!-- MINI CHART -->
                <div class="mt-8">

                    <svg class="w-full h-24"
                        viewBox="0 0 300 100"
                        preserveAspectRatio="none">

                        <path d="
                            M0 70
                            C40 40, 80 60, 120 30
                            S200 80, 260 20
                            S280 40, 300 10"
                            fill="none"
                            stroke="#16A34A"
                            stroke-width="5"
                            stroke-linecap="round"/>

                    </svg>

                </div>

                <div class="mt-5 flex items-center justify-between">

                    <div>
                        <p class="text-xs text-gray-400">
                            Activity Rate
                        </p>

                        <h4 class="font-bold text-lg mt-1">
                            +8%
                        </h4>
                    </div>

                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                        Stable
                    </span>

                </div>

            </div>

        </div>

    </div>

</div>