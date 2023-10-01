<div class="overflow-x-auto">


    <x-auth-session-status class="mb-4" :status="session('status')" />


    <div class=" overflow-x-auto bg-transparent w-full flex items-center justify-center  font-sans ">
        <div class="w-full lg:w-5/6">
            <div class="rounded-t bg-white dark:bg-darker mb-4 mt-4 px-4 py-3 border-0">
                <div class="flex flex-wrap items-center">
                    <div class="relative w-full sm:px-4 max-w-full flex-grow sm:flex-1">
                        <h3 class="font-semibold relative mb-4 flex text-base text-blueGray-700">
                            {{ __('منتجات المزودين') }}
                            <x-bi-cart-fill class="w-10 h-10 text-yellow-400 flex" />
                            <span class="rounded-full p-1 bg-indigo-500 ">+</span>

                        </h3>
                        <x-input-with-icon-wrapper>
                            <x-slot name="icon" role="button">
                                <x-bi-search aria-hidden="true" class="w-5 h-5" />
                            </x-slot>
                            <x-input wire:model="search" name="search" withicon id="search"
                                class="block rounded-full w-full" type="text" :value="old('name')" required autofocus
                                placeholder="{{ __('ابحث') }}" />
                        </x-input-with-icon-wrapper>

                        <select  wire:model="deptid" class=" form-select flex-1 dark:bg-darker rounded-full m-2"
                            id="color1">
                            <option  value="all"> القسم /الجميع
                            </option>
                            @foreach ($depts as $dept)
                                <option  value="{{ $dept->id }}">
                                    القسم/{{ $dept->name }}</option>
                            @endforeach
                        </select>
                        <div class="w-full  mb-4 flex" dir="auto">
                            <label class=" text-xs  dark:text-white dark:bg-darker text-black sm:px-4" for="bydate">ترتيب
                                التاريخ</label>
                            <select class=" rounded-md border text-sm flex-1 dark:bg-darker " id="bydate" wire:model="dateorder">
                                <option value="no">بلا</option>
                                <option value="ASC"> تصاعدي</option>
                                <option value="DESC">تنازلي</option>
                            </select>
                            <label class=" text-xs dark:text-white sm:px-4 dark:bg-darker text-black" for="byprice">ترتيب السعر</label>
                            <select class=" rounded-md border text-sm flex-1 dark:bg-darker " wire:model="priceorder" id="byprice">
                                <option value="no">بلا</option>
                                <option value="ASC"> تصاعدي</option>
                                <option value="DESC">تنازلي</option>
                            </select>
                        </div>

                    </div>
                    <div class="relative w-full px-4 max-w-full  flex-1 text-right">


                        <a href="{{route("provider_products.create")}}" class="cursor-pointer text-white w-1/2 mx-auto bg-blue-900 btn flex rounded-md  p-2 mb-2  ">
                            اضافة منتج
                            <x-bi-cart class="w-6 h-6 text-yellow-400" />
                        </a>






                    </div>


                </div>

                <div class="flex mt-4 dark:text-white flex-col ">


                    {{ $products->links() }}
                </div>


                <div
                    class="bg-white overflow-x-auto relative dark:bg-darker dark:text-white w-full shadow-md rounded my-6">

                    <div class="w-full top-0 bottom-0 z-30 bg-white bg-opacity-50 absolute" wire:loading
                        wire:target="changeDept,changePro,subsearch,gotoPage,nextPage,perviousPage">
                        <div class="w-full h-4 bg-blue-900 mt-16 rounded animate-pulse top-10 bottom-0 my-auto"></div>
                    </div>





                    <h4 class="text-right flex my-2" dir="rtl">عدد العناصر
                        <select wire:model='paginate_num'  class="bg-white  bg-white rounded-md text-dark text-xs dark:text-white dark:bg-dark border-0">
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


                    <table dir="rtl" class="min-w-max w-full table-auto overflow-x-auto">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm ">

                                <th class="py-3 px-2  text-right">المنتج
                                </th>
                                <th class="py-3 px-2  text-right">المزود

                                </th>
                                <th class="py-3 px-2  text-right"> الحالة</th>
                                <th class="py-3  text-right">السعر
                                    <select class=" rounded-sm text-sm flex-1  dark:bg-darker" wire:model="priceorder"
                                        id="byprice">
                                        <option value="no">بلا</option>
                                        <option value="ASC"> تصاعدي</option>
                                        <option value="DESC">تنازلي</option>
                                    </select>
                                </th>

                                <th class="py-3  text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 dark:text-white text-sm font-light">


                            @foreach ($products as $product)
                                <tr
                                    class="border-b-2 border-dark relative border-gray-200 hover:bg-gray-100 dark:hover:bg-dark dark:hover:text-white">
                                    <td class="py-3 px-2 mb-4 text-right">
                                        <div class="flex items-center">
                                            
                                            <span dir="auto" class="font-bold w-44  truncate">{{ $product->name }}
                                                <span
                                                    class="block w-1/2 text-blue-700 dark:text-white sm:block font-light text-xs ">

                                                        المنتج الاساسي / {{ $product->product->name }}
                                                  
                                                </span>
                                                <span
                                                class="block w-1/2 text-blue-700 dark:text-white sm:block font-light text-xs ">

                                                    القسم/ {{ $product->product->department->name }}
                                            </span>
                                       
                                            </span>
                                        </div>
                                        <div>
                                            <span class=" mb-6 mt-4 text-green-600 font-bold py-1 px-1  text-xs">
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
                                        class="bg-success-dark mb-2  text-white font-bold p-2 px-3 rounded-full ">
                                        نشط
                                    </span>
                                        @else
                                        <span
                                        class="bg-danger mb-2  text-white font-bold p-2 px-3 rounded-full ">
                                    غير نشط    
                                    </span>
                                            
                                        @endif
                                    </td>
                                    <td class="py-3 text-md font-bold text-center">
                                        <div class="flex flex-col w-1/2">
                                            <span>   سعر المنتج الاساسي
                                            </span>
                                            <span
                                            class="bg-info mb-2  text-white font-bold p-2 px-3 rounded-full ">
                                        
                                            {{ $product->product->price."  /$" }}
                                        </span>
                                        <span>سعر المزود</span>
                                       
                                        <span
                                        class="bg-success-dark mb-2 text-white font-bold p-2 px-3 rounded-full ">
                                        {{ $product->price."  /$" }}
                                    </span>
                                        </div>
                                    </td>

                                    <td class="py-3   text-right">
                                        <div class="flex item-center justify-center">

                                            <div wire:click="setDeleteproid({{ $product->id }})"
                                                class="w-4 flex mr-2 mt-2 cursor-pointer transform hover:text-red-800 hover:scale-110">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                            </div>
                                        </div>
                                        @if ($deleteproid != 'no' && $deleteproid==$product->id)
                                        <div x-data="{dpm{{ $deleteproid }}: 1}">
                                            <div x-show="dpm{{ $deleteproid }}" class="dialog">

            <div x-transition:enter="transition duration-500 ease-in-out" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition duration-500 ease-in-out"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-darker opacity-10 z-30" @click='dpm{{ $deleteproid }}=!dpm{{ $deleteproid }}' 
            wire:click="setDeleteproid('no')"
            x-show="dpm{{ $deleteproid }}">

        </div>
                                                <div class="dialog-content p-4 w-1/3  fixed z-50 bg-white top-1/3 left-1/2 rounded-md">
                                                    <div class="dialog-header dark:text-black">
                                                    تعديل حالة المنتج     
                                                    </div>
                                                    <div class="dialog-body lg:flex" dir="auto">
                                                        <h1 class="text-sm text-red-800 font-bold p-4 rounded-lg "> 
                                                        
                                                        </h1>
                                                    </div>
                                                    <div class="dialog-footer flex justify-between  mx-auto">
                                                        <x-button 
                                                        
                                                        wire:click="active({{$deleteproid}})"
                                                        @click="dpm{{ $deleteproid }}=!dpm{{ $deleteproid }}"
                                                        variant='success' type="button" 
                                                        class=" text-white rounded-box p-2 "
                                                        >تنشيط </x-button>
                                                       
                                                            <button type="button"
                                                            @click="dpm{{ $deleteproid }}=!dpm{{ $deleteproid }}"
                                                      
                                                            wire:click="deactive({{ $deleteproid }})"
                                                            class="bg-red-700 text-white rounded-box p-2">الغاء التنشيط </button>
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
        <div class="fixed p-4  z-50  bg-green-500 rounded-md text-white top-10 w-1/4 mx-auto right-5 toast" role="alert"
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
