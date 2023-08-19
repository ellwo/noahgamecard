


<x-dashe-layout>
    <div>


    <div dir="rtl" class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-darker">
        مرحبا  {{ '  '.auth()->user()->name }}
    </div>

        <div class="mt-2">
            <!-- State cards -->
            <div class="grid grid-cols-1 gap-8 p-4 lg:grid-cols-2 xl:grid-cols-3">

                <div  dir="rtl" class="flex items-center justify-between p-4 bg-white rounded-md dark:bg-darker">
                    <div class="flex space-y-2 flex-col">
                        <h6
                            class="text-xs font-medium leading-none tracking-wider text-gray-500 uppercase dark:text-primary-light">
                        عدد  الاقسام
                        </h6>
                        <span class="text-xl font-semibold">{{ $d_count }}</span>
                        <a href="{{ route('depts') }}">
                        <span class="inline-block px-2 py-px ml-2 text-xs text-green-500 bg-green-100 rounded-md">
                            ادارة الاقسام
                        </span>
                        </a>
                    </div>
                    <div>

                        <span>
                            <x-bi-key class="w-12 h-12 text-blue-400 dark:text-primary-dark" />
                        </span>

                    </div>
                </div>
                <div  dir="rtl" class="flex items-center justify-between p-4 bg-white rounded-md dark:bg-darker">
                    <div class="flex space-y-2 flex-col">
                        <h6
                            class="text-xs font-medium leading-none tracking-wider text-gray-500 uppercase dark:text-primary-light">
                            عدد الطلبات المعلقة
                        </h6>
                        <span class="text-xl font-semibold">{{ $unread__orders_count }}</span>
                        <a href="{{ route('paymentinfo') }}">
                        <span class="inline-block px-2 py-px ml-2 text-xs text-green-500 bg-green-100 rounded-md">
                            ادارة الطلبات
                        </span>
                        </a>
                    </div>
                    <div>
                        <span>
                            <x-bi-watch class="w-12 h-12 text-yellow-400 dark:text-primary"/>
                        </span>
                    </div>
                </div>

                <div  dir="rtl" class="flex items-center justify-between p-4 bg-white rounded-md dark:bg-darker">
                    <div class="flex space-y-2 flex-col">
                        <h6
                            class="text-xs font-medium leading-none tracking-wider text-gray-500 uppercase dark:text-primary-light">
                            عدد الطلبات المنفذة
                        </h6>
                        <span class="text-xl font-semibold">{{ $orders_done }}</span>
                        <a href="{{ route('paymentinfo') }}">
                        <span class="inline-block px-2 py-px ml-2 text-xs text-green-500 bg-green-100 rounded-md">
                            ادارة الطلبات
                        </span>
                        </a>
                    </div>
                    <div>
                        <span>
                            <x-bi-check class="w-12 h-12 text-green-500 dark:text-primary"/>
                        </span>
                    </div>
                </div>

                <div  dir="rtl" class="flex items-center  justify-between p-4 bg-white rounded-md dark:bg-darker">
                    <div class="flex space-y-2 flex-col">
                        <h6
                            class="text-xs font-medium leading-none tracking-wider text-gray-500 uppercase dark:text-primary-light">
                            اجمالي عدد المستخدمين
                        </h6>
                        <span class="text-xl font-semibold">{{ $users_count }}</span>
                        <a href="{{ route('admin.users.index') }}">
                        <span class="inline-block px-2 py-px ml-2 text-xs text-green-500 bg-green-100 rounded-md">
                            ادارة المستخدمين
                        </span>
                        </a>
                    </div>
                    <div>
                        <span>
                            <x-heroicon-s-user class="w-12 h-12 text-dark dark:text-primary"/>
                        </span>
                    </div>
                </div>

                <div dir="rtl" class="flex items-center justify-between p-4 bg-white rounded-md dark:bg-darker">
                    <div class="flex flex-col space-y-2">
                        <h6
                            class="text-xs font-medium leading-none tracking-wider text-gray-500 uppercase dark:text-primary-light">
                            عدد المنتجات المعروضة
                        </h6>
                        <span class="text-xl font-semibold">{{ $products_count }}</span>
                        <a target="_blank" href="{{ route('products') }}">
                        <span class="inline-block px-2 py-px ml-2 text-xs text-green-500 bg-green-100 rounded-md">
                            ادارة المنتجات
                        </span>
                        </a>
                    </div>
                    <div>
                        <span>
                            <x-bi-bag-fill class="w-12 h-12 text-primary dark:text-primary-dark" />
                        </span>
                    </div>
                </div>



            </div>



            <!-- Charts -->
            {{-- <div class="grid grid-cols-1 p-4 space-y-8 lg:gap-8 lg:space-y-0 lg:grid-cols-3">
                <!-- Bar chart card -->
                <div class="col-span-2 bg-white rounded-md dark:bg-darker" x-data="{ isOn: false }">
                    <!-- Card header -->
                    <div class="flex items-center justify-between p-4 border-b dark:border-primary">
                        <h4 class="text-lg font-semibold text-gray-500 dark:text-light">Bar Chart</h4>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-500 dark:text-light">Last year</span>
                            <button class="relative focus:outline-none" x-cloak
                                @click="isOn = !isOn; $parent.updateBarChart(isOn)">
                                <div
                                    class="w-12 h-6 transition rounded-full outline-none bg-primary-100 dark:bg-primary-darker">
                                </div>
                                <div class="absolute top-0 left-0 inline-flex items-center justify-center w-6 h-6 transition-all duration-200 ease-in-out transform scale-110 rounded-full shadow-sm"
                                    :class="{ 'translate-x-0  bg-white dark:bg-primary-100': !isOn, 'translate-x-6 bg-primary-light dark:bg-primary': isOn }">
                                </div>
                            </button>
                        </div>
                    </div>
                    <!-- Chart -->
                    <div class="relative p-4 h-72">
                        <canvas id="barChart"></canvas>
                    </div>
                </div>

                <!-- Doughnut chart card -->
                <div class="bg-white rounded-md dark:bg-darker" x-data="{ isOn: false }">
                    <!-- Card header -->
                    <div class="flex items-center justify-between p-4 border-b dark:border-primary">
                        <h4 class="text-lg font-semibold text-gray-500 dark:text-light">Doughnut Chart</h4>
                        <div class="flex items-center">
                            <button class="relative focus:outline-none" x-cloak
                                @click="isOn = !isOn; $parent.updateDoughnutChart(isOn)">
                                <div
                                    class="w-12 h-6 transition rounded-full outline-none bg-primary-100 dark:bg-primary-darker">
                                </div>
                                <div class="absolute top-0 left-0 inline-flex items-center justify-center w-6 h-6 transition-all duration-200 ease-in-out transform scale-110 rounded-full shadow-sm"
                                    :class="{ 'translate-x-0  bg-white dark:bg-primary-100': !isOn, 'translate-x-6 bg-primary-light dark:bg-primary': isOn }">
                                </div>
                            </button>
                        </div>
                    </div>
                    <!-- Chart -->
                    <div class="relative p-4 h-72">
                        <canvas id="doughnutChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Two grid columns -->
            <div class="grid grid-cols-1 p-4 space-y-8 lg:gap-8 lg:space-y-0 lg:grid-cols-3">
                <!-- Active users chart -->
                <div class="col-span-1 bg-white rounded-md dark:bg-darker">
                    <!-- Card header -->
                    <div class="p-4 border-b dark:border-primary">
                        <h4 class="text-lg font-semibold text-gray-500 dark:text-light">Active users right
                            now</h4>
                    </div>
                    <p class="p-4">
                        <span class="text-2xl font-medium text-gray-500 dark:text-light"
                            id="usersCount">0</span>
                        <span class="text-sm font-medium text-gray-500 dark:text-primary">Users</span>
                    </p>
                    <!-- Chart -->
                    <div class="relative p-4">
                        <canvas id="activeUsersChart"></canvas>
                    </div>
                </div>

                <!-- Line chart card -->
                <div class="col-span-2 bg-white rounded-md dark:bg-darker" x-data="{ isOn: false }">
                    <!-- Card header -->
                    <div class="flex items-center justify-between p-4 border-b dark:border-primary">
                        <h4 class="text-lg font-semibold text-gray-500 dark:text-light">Line Chart</h4>
                        <div class="flex items-center">
                            <button class="relative focus:outline-none" x-cloak
                                @click="isOn = !isOn; $parent.updateLineChart()">
                                <div
                                    class="w-12 h-6 transition rounded-full outline-none bg-primary-100 dark:bg-primary-darker">
                                </div>
                                <div class="absolute top-0 left-0 inline-flex items-center justify-center w-6 h-6 transition-all duration-200 ease-in-out transform scale-110 rounded-full shadow-sm"
                                    :class="{ 'translate-x-0  bg-white dark:bg-primary-100': !isOn, 'translate-x-6 bg-primary-light dark:bg-primary': isOn }">
                                </div>
                            </button>
                        </div>
                    </div>
                    <!-- Chart -->
                    <div class="relative p-4 h-72">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
            </div> --}}
        </div>





    <div class="p-6 mt-2 overflow-hidden rounded-md rounded-t-none shadow-md dark:bg-dark" dir="rtl">

        <h1 class=""></h1>
        <!-- State cards -->
        <div class="grid grid-cols-1 gap-8 p-4 lg:grid-cols-2 xl:grid-cols-4">


            <!-- Orders card -->

            <a href="{{ route('admin.contacts') }}"
                class="flex items-center justify-between p-4 bg-white rounded-md hover:shadow-2xl dark:bg-darker">
                <div>
                    <h6
                        class="text-sm font-bold leading-none tracking-wider text-gray-500 uppercase dark:text-primary-light">
                       الرسائل المستقبلة (الشكاوى والرسائل)
                    </h6>
                    <span class="text-xs font-semibold">

                    </span>
                </div>
                <div>


                    <span class="relative">
                        <x-bi-inbox-fill class="w-12 h-12 text-blue-400" />

                        <span class="absolute top-0 right-0 bg-white border rounded-full text-danger ">{{ $unreaded_messages }}</span>
                    </span>

                </div>
            </a>
        </div>
    </div>


    </div>

</x-dashe-layout>
