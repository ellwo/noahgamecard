<section x-data='{open_delete:false}'>
    <div class="relative ">



        <div x-show="open_delete" class="absolute flex flex-col p-8 space-y-4 bg-white rounded-md top-24 right-1/2">
            <span class="w-full text-danger">تنويه</span>
            <hr>
            هل انت متاكد من الحذف ؟
            <div class="flex justify-between space-x-2">
      <x-button variant='success' @click='open_delete=false'
       wire:click='delete_order({{$delete_orderid}})'
      >تأكيد</x-button>
      <x-button variant='danger' x-on:click="open_delete=false;$wire.set('delete_orderid','no')" > الغاء</x-button>
            </div>
        </div>




        <x-auth-session-status class="mb-4" :status="session('status')" />

        <x-auth-validation-errors class="mb-4" :errors="$errors" />





    <div class="flex flex-col items-center justify-center pt-4 dark:bg-darker">
        <div class="flex flex-col w-full col-span-12 mx-auto">



            <div class="items-center justify-between mb-4 space-x-2 space-y-2 md:flex md:mx-auto lg:w-2/3">
                <div class="w-full pr-4">
                    <div class="relative md:w-full">
                        <input wire:model.lazy="search" type="search"
                            class="w-full py-2 pl-10 pr-4 font-medium text-gray-600 rounded-lg shadow focus:outline-none focus:shadow-outline"
                            placeholder="Search...">
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
                </div>
                <div>
                    <div class="flex transition-shadow shadow">
                        <div class="relative flex flex-col items-center space-y-2 ">
                            <x-label value="عرض المنتجات حسب "  />
                        {{-- <select wire:model.lazy='username' wire:change='UsernameUpdated' class="bg-white text-dark dark:text-white dark:bg-dark rounded-2xl ">
                            <option value="all">جميع الحسابات </option>
                            <option value="useronly">الحساب الشخصي </option>

                            @foreach ($bussinses as $buss)
                            <option wire:click="choseBuss('{{ $buss->username }}')"
                                value="{{ $buss->username }}">{{ $buss->name }}
                                <hr>
                            <span class="p-1 text-xs rounded-full text-info">{{ "@".$buss->username }} </span></option>
                            @endforeach

                        </select> --}}

                        </div>
                    </div>
                </div>
                <div>
                    <div  class="flex transition-shadow rounded-lg shadow">
                        <div class="flex flex-col items-center w-full space-y-2 ">
                           {{-- <x-button href="{{ route('product.create',['username'=>$type!='all'&&$type!='useronly'?$username:'me']) }}" class='block w-32' variant="success">
                            اضافة جديد
                            <x-heroicon-o-plus class="w-4 h-4"/>
                           </x-button> --}}
                        </div>
                    </div>
                </div>
            </div>

            <h4 class="mx-auto">عرض الطلبات ال</h4>
            <hr>
            <div class="flex p-4 mx-auto space-x-4 ">

                <div class="flex items-center mb-4">
                     <label for="country-option-1" class="block ml-2 text-sm font-medium text-gray-900 dark:text-white">
                 الكل
                    </label>
                    <input wire:model='status' id="country-option-1" type="radio" name="countries" value="4" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300" aria-labelledby="country-option-1" aria-describedby="country-option-1" checked="">

                </div>
                <div class="flex items-center mb-4">
                    <label for="country-option-2" class="block ml-2 text-sm font-medium text-gray-900 dark:text-white">
                   الطلبات الغير مؤكده
                   </label>
                   <input wire:model='status' id="country-option-2" type="radio" name="countries" value="0" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300" aria-labelledby="country-option-1" aria-describedby="country-option-1" checked="">

               </div>
               <div class="flex items-center mb-4">
                <label for="country-option-3" class="block ml-2 text-sm font-medium text-gray-900 dark:text-white">
               الطلبات المؤكده غير المنفذة
               </label>
               <input wire:model='status' id="country-option-3" type="radio" name="countries" value="1" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300" aria-labelledby="country-option-1" aria-describedby="country-option-1" checked="">

           </div>
           <div class="flex items-center mb-4">
            <label for="country-option-4" class="block ml-2 text-sm font-medium text-gray-900 dark:text-white">
           الطلبات المنفذة
           </label>
           <input wire:model='status' id="country-option-4" type="radio" name="countries" value="2" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300" aria-labelledby="country-option-1" aria-describedby="country-option-1" checked="">

       </div>
       <div class="flex items-center mb-4">
        <label for="country-option-5" class="block ml-2 text-sm font-medium text-gray-900 dark:text-white">
       الطلبات المرفوضة
       </label>
       <input wire:model='status' id="country-option-5" type="radio" name="countries" value="3" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300" aria-labelledby="country-option-1" aria-describedby="country-option-1" checked="">

   </div>

            </div>
            <div class="w-full top-0 right-0 bottom-0 z-30 bg-white bg-opacity-50 fixed" wire:loading
                              >
                            <div class="w-full h-4 bg-blue-900 mt-16 rounded animate-pulse top-10 bottom-0 my-auto"></div>
                        </div>
            <div class="flex flex-col w-full mx-auto overflow-x-scroll md:overflow-x-hidden ">
                <table dir="rtl" class="table px-4 space-y-6 text-xs border-separate md:min-w-full sm:text-sm text-dark dark:text-light">
                    <thead class=" dark:text-light bg-light dark:bg-dark">
                        <tr>
                            <th class="p-3">رقم العملية </th>
                            <th class="p-3">البطائق المطلوبة </th>
                            <th class="p-3 ">وسيلة الدفع</th>
                            <th class="p-3 "> اجمالي السعر</th>
                            <th class="p-3 ">الحالة</th>
                            <th class="p-3 ">تاريخ </th>
                            <th class="p-3 ">العميل</th>
                            <th class="p-3 ">عمليات</th>
                        </tr>
                    </thead>
                    <tbody class="">

                        @foreach ($paymentinfos as $paymentinfo)


                        <tr class="bg-white dark:bg-dark">

                            <td>
                                {{ $paymentinfo->id }}
                                <hr>
                                <span>كود العملية</span>
                                {{ $paymentinfo->code }}
                                <hr>
                                <span class="{{ $paymentinfo->accepted?'text-info':'text-red-800'}}">{{ $paymentinfo->accepted?"تم تاكيد حالة الدفع":"لم يتم تاكيد حالة الدفع" }}</span>

                            </td>
                            <td class="p-3">
                                @foreach ($paymentinfo->orders as $order )
                                <div class="border p-1 rounded-md">
                                <div class="flex align-items-center">
                                    <div class="ml-3  justify-start flex flex-col">
                                        <div class="flex border-b justify-start space-x-2">
                                            <div class="w-1/3 text-xs font-bold mx-2 border-l-1 ">اسم البطاقة</div>
                                            <div class="w-2/3 mx-2 text-xs text-info">{{ $order->product->name }}</div>
                                        </div>
                                        <div class="flex border-b justify-start space-x-2">
                                            <div class="w-1/3 text-xs font-bold mx-2 border-l-1 ">الكمية</div>
                                            <div class="w-2/3 mx-2 text-xs text-info">{{ $order->qun }}</div>
                                        </div>
                                        <div class="flex border-b justify-start space-x-2">
                                            <div class="w-1/3 text-xs font-bold mx-2 border-l-1 ">ID الحساب</div>
                                            <div class="w-2/3 mx-2 text-xs text-info">{{ $order->g_id }}</div>
                                        </div>

                                    </div>
                                </div>
                                </div>
                                <hr>
                                @endforeach

                            </td>
                            <td class="p-3">
                                <span class="font-bold text-blue-900">{{ $paymentinfo->paymentmethod->name }}</span>

                            </td>
                            <td class="p-3 font-bold">
                                <div class="flex flex-col">
                                        <s> {{ $paymentinfo->orginal_total()}}</s>
                                        <span>
                                            {{ $paymentinfo->total_price }}
                                        </span>

                                </div>
                            </td>
                            <td class="p-3">
                                <span class="px-2 {{ $paymentinfo->state==0?"bg-m_primary-lighter":($paymentinfo->state==1? "bg-info":($paymentinfo->state==2?'bg-green-600':'bg-red-400')) }} rounded-md text-darker">@php
                                    echo  $paymentinfo->state==0?"لم يتم التأكيد":($paymentinfo->state==1? "في انتظار التنفيذ ":($paymentinfo->state==2?'منفذ':'مرفوض'));
                                @endphp</span>
                            </td>

                            <td class="p-3 " >

                                {{$paymentinfo->updated_at}}
                            </td>

                            <td class="flex flex-col p-1" dir="rtl">

                                <div class="flex space-x-2">
                                    {{ $paymentinfo->orders()->first()->user->name ??""}}
                                 </div><div class="flex space-x-2">
                                    {{ $paymentinfo->orders()->first()->user->email ??""}}
                                 </div>
                                 <div class="flex space-x-2">
                                    {{ $paymentinfo->orders()->first()->user->username ??""}}
                                 </div>
                                 <div class="flex space-x-2">
                                    {{ $paymentinfo->orders()->first()->user->phone ??""}}
                                 </div>
                                 {{-- <div class="flex space-x-2">
                                    <span class="mx-2 font-bold text-info">العنوان: </span>{{ $order->address }}
                                 </div>
                                 <div class="flex space-x-2 ">
                                    <span class="mx-2 font-bold text-info">الكمية: </span>{{ $order->qun }}
                                 </div> --}}

                            </td>

                            <td class="flex mt-16">


                            </td>
                            <td class="">
                                <div class="flex">

                                <a href="{{ route('paymentinfo.show',$paymentinfo) }}"  class="mr-2 flex text-gray-400 hover:text-dark dark:hover:text-gray-100">
                                    <i class="text-base "><x-heroicon-s-eye class="w-5 h-5"/></i>
                                    عرض تفاصيل
                                </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $paymentinfos->links() }}
            </div>
        </div>
    </div>
    <style>
        .table {
            border-spacing: 0 15px;
        }

        i {
            font-size: 1rem !important;
        }

        .table tr {
            border-radius: 20px;
        }

        tr td:nth-child(n+8),
        tr th:nth-child(n+8) {
            border-radius:  .625rem 0 0 .625rem ;
        }

        tr td:nth-child(1),
        tr th:nth-child(1) {
            border-radius:0 .625rem   .625rem 0;
        }
    </style>

    <x-slot name="script">


    </x-slot>



    </div>
    </section>