<div class="overflow-x-auto">


    <x-auth-session-status class="mb-4" :status="session('status')" />


    <div class="flex items-center justify-center w-full overflow-x-auto font-sans bg-transparent ">
        <div class="w-full lg:w-5/6">
            <div class="px-4 py-3 mt-4 mb-4 bg-white border-0 rounded-t dark:bg-darker">
                <div dir="rtl" class="flex flex-wrap items-center">
                    <div class="relative flex-grow w-full max-w-full sm:px-4 sm:flex-1">
                        <h3 class="relative flex mb-4 text-base font-semibold text-blueGray-700">
                            {{ __('منتجات المزودين') }}
                            <x-bi-cart-fill class="flex w-10 h-10 text-yellow-400" />
                            <span class="p-1 bg-indigo-500 rounded-full ">+</span>

                        </h3>
                        <div class="relative md:w-full">
                            <input wire:model.lazy="search" type="search"
                                class="w-full py-2 pl-10 pr-4 font-medium text-gray-600 rounded-lg shadow focus:outline-none focus:shadow-outline"
                                placeholder="ابحث...">
                            <div class="absolute top-0 left-0 inline-flex items-center p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                                    <circle cx="10" cy="10" r="7" />
                                    <line x1="21" y1="21" x2="15" y2="15" />
                                </svg>
                            </div>
                        </div>
                        <select  wire:model="deptid" class="flex-1 m-2 rounded-full  form-select dark:bg-darker"
                            id="color1">
                            <option  value="all"> القسم /الجميع
                            </option>
                            @foreach ($depts as $dept)
                                <option  value="{{ $dept->id }}">
                                    {{ $dept->name }}</option>
                            @endforeach
                        </select>
                        <select  wire:model="client" class="flex-1 m-2 rounded-full  form-select dark:bg-darker"
                            id="color1">
                            <option  value="all"> المزود /الجميع
                            </option>
                            @foreach ($clients as $dept)
                                <option  value="{{ $dept->id }}">
                                   {{ $dept->name }}</option>
                            @endforeach
                        </select>
                        <div class="flex w-full mb-4" dir="auto">
                            <label class="text-xs text-black  dark:text-white dark:bg-darker sm:px-4" for="bydate">ترتيب
                                التاريخ</label>
                            <select class="flex-1 text-sm border rounded-md  dark:bg-darker" id="bydate" wire:model="dateorder">
                                <option value="no">بلا</option>
                                <option value="ASC"> تصاعدي</option>
                                <option value="DESC">تنازلي</option>
                            </select>
                            <label class="text-xs text-black  dark:text-white sm:px-4 dark:bg-darker" for="byprice">ترتيب السعر</label>
                            <select class="flex-1 text-sm border rounded-md  dark:bg-darker" wire:model="priceorder" id="byprice">
                                <option value="no">بلا</option>
                                <option value="ASC"> تصاعدي</option>
                                <option value="DESC">تنازلي</option>
                            </select>
                        </div>

                    </div>
                    <div class="relative flex-1 w-full max-w-full px-4 text-right">


                        <a href="{{route("provider_products.create")}}" class="flex w-1/2 p-2 mx-auto mb-2 text-white bg-blue-900 rounded-md cursor-pointer btn ">
                            اضافة منتج
                            <x-bi-cart class="w-6 h-6 text-yellow-400" />
                        </a>






                    </div>


                </div>

                <div class="flex flex-col mt-4 dark:text-white ">


                    {{ $products->links() }}
                </div>


                <div
                    class="relative w-full my-6 overflow-x-auto bg-white rounded shadow-md dark:bg-darker dark:text-white">

                    <div class="absolute top-0 bottom-0 z-30 w-full bg-white bg-opacity-50" wire:loading>
                        <div class="bottom-0 w-full h-4 my-auto mt-16 bg-blue-900 rounded animate-pulse top-10"></div>
                    </div>





                    <h4 class="flex my-2 text-right" dir="rtl">عدد العناصر
                        <select wire:model='paginate_num'  class="text-xs bg-white border-0 rounded-md text-dark dark:text-white dark:bg-dark">
                            <option value="10">10</option>
                            <option value="10">15</option>
                            <option value="20">20</option>
                           <option
                            value="50">

                            <span class="p-1 text-xs text-info">50</span></option>
                            <option
                            value="100">
                            <span class="p-1 text-xs text-info">100</span></option>

                        </select>
                        </h4>


                    <table dir="rtl" class="w-full overflow-x-auto table-auto min-w-max">
                        <thead>
                            <tr class="text-sm text-gray-600 uppercase bg-gray-200 ">

                                <th class="px-2 py-3 text-right">المنتج
                                </th>
                                <th class="px-2 py-3 text-right">المزود

                                </th>
                                <th class="px-2 py-3 text-right"> الحالة</th>
                                <th class="py-3 text-right">السعر

                                </th>

                                <th class="py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm font-light text-gray-600 dark:text-white">


                            @foreach ($products as $product)
                                <tr
                                    class="relative border-b-2 border-gray-200 border-dark hover:bg-gray-100 dark:hover:bg-dark dark:hover:text-white">
                                    <td class="px-2 py-3 mb-4 text-right">
                                        <div class="flex items-center">

                                            <span dir="auto" class="font-bold ">{{ $product->name }}
                                                <span
                                                    class="block text-xs font-light text-blue-700 dark:text-white ">

                                                        المنتج الاساسي / {{ $product->product?->name??"" }}

                                                </span>
                                                <span
                                                class="block text-xs font-light text-blue-700 dark:text-white ">

                                                    القسم/ {{ $product->product?->department->name??"" }}
                                            </span>

                                            </span>
                                        </div>
                                        <div>
                                            <span class="px-1 py-1 mt-4 mb-6 text-xs font-bold text-green-600 ">
                                                {{ date('d/M/Y', strtotime($product->updated_at)) }}

                                            </span>
                                        </div>



                                    </td>

                                    <td>
                                        {{$product->client_provider->name}}
                                    </td>

                                    <td class="px-2">

                                        @if ($product->active)
                                        <span
                                        class="p-2 px-3 mb-2 font-bold text-white rounded-full bg-success-dark ">
                                        نشط
                                    </span>
                                        @else
                                        <span
                                        class="p-2 px-3 mb-2 font-bold text-white rounded-full bg-danger ">
                                    غير نشط
                                    </span>

                                        @endif
                                    </td>
                                    <td class="py-3 font-bold text-center text-md">
                                        <div class="flex flex-col w-1/2">
                                            <span>   سعر المنتج الاساسي
                                            </span>
                                            <span
                                            class="p-2 px-3 mb-2 font-bold text-white rounded-full bg-info ">

                                            {{ $product->product->price."  /$" }}
                                        </span>
                                        <span>سعر المزود</span>

                                        <span
                                        class="p-2 px-3 mb-2 font-bold text-white rounded-full bg-success-dark ">
                                        {{ $product->price."  /$" }}
                                    </span>
                                        </div>
                                    </td>

                                    <td class="py-3 text-right">
                                        <div class="flex justify-center item-center">

                                            <a href="{{ route('provider_products.edit', $product) }}"
                                            {{-- wire:click="setDeleteproid({{ $product->id }})" --}}
                                                class="flex w-4 mt-2 mr-2 transform cursor-pointer hover:text-red-800 hover:scale-110">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </a>
                                        </div>
                                        @if ($deleteproid != 'no' && $deleteproid==$product->id)
                                        <div x-data="{dpm{{ $deleteproid }}: 1}">
                                            <div x-show="dpm{{ $deleteproid }}" class="dialog">

            <div x-transition:enter="transition duration-500 ease-in-out" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition duration-500 ease-in-out"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-30 bg-darker opacity-10" @click='dpm{{ $deleteproid }}=!dpm{{ $deleteproid }}'
            wire:click="setDeleteproid('no')"
            x-show="dpm{{ $deleteproid }}">

        </div>
                                                <div class="fixed z-50 w-1/3 p-4 bg-white rounded-md dialog-content top-1/3 left-1/2">
                                                    <div class="dialog-header dark:text-black">
                                                    تعديل حالة المنتج
                                                    </div>
                                                    <div class="dialog-body lg:flex" dir="auto">
                                                        <h1 class="p-4 text-sm font-bold text-red-800 rounded-lg ">

                                                        </h1>
                                                    </div>
                                                    <div class="flex justify-between mx-auto dialog-footer">
                                                        <x-button

                                                        wire:click="active({{$deleteproid}})"
                                                        @click="dpm{{ $deleteproid }}=!dpm{{ $deleteproid }}"
                                                        variant='success' type="button"
                                                        class="p-2 text-white  rounded-box"
                                                        >تنشيط </x-button>

                                                            <button type="button"
                                                            @click="dpm{{ $deleteproid }}=!dpm{{ $deleteproid }}"

                                                            wire:click="deactive({{ $deleteproid }})"
                                                            class="p-2 text-white bg-red-700 rounded-box">الغاء التنشيط </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>






        </div>
    </div>



    @if (session()->get('statt') == 'ok')
        <div class="fixed z-50 w-1/4 p-4 mx-auto text-white bg-green-500 rounded-md top-10 right-5 toast" role="alert"
            x-on:toast1.window="open = !open" x-data="{ open: true }" x-show.transition="open" x-cloak>
            <div class="flex items-center justify-between mb-1">
                <span class="font-bold text-blue-600">
                    {{ __(session()->get('title')) }}</span>
                <button class="btn btn-dark btn-xs" @click="open = false"><svg class="w-4 h-4"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg></button>
            </div>
            {{ __(session()->get('message')) }}
        </div>
    @endif
</div>
