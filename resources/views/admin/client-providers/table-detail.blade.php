
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

                </div>
                <div>

                    <div class="flex transition-shadow shadow">
                        <div class="relative flex flex-col items-center space-y-2 ">
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




            <div class="flex flex-col space-y-2 lg:w-1/3 mx-auto justify-end justify-items-end">

                <h4 class=" flex" dir="rtl">
                    <span class="w-1/3 my-auto">عرض العمليات ال</span>
                    <select wire:model.lazy='status'  class="bg-white w-2/3 text-dark text-md dark:text-white dark:bg-dark rounded-md bg-white">
                        <option value="4">الكل</option>
                       <option
                        value="1">
                        <span class="p-1 text-xs text-info">المعلقة</span></option>
                        <option
                        value="2">
                        <span class="p-1 text-xs text-info">المؤكدة</span></option>
                        <option
                        value="3">
                        <span class="p-1 text-xs text-info">المرفوضة</span></option>
                    </select>
                </h4>

                <h4 class=" flex" dir="rtl">
                    <span class="w-1/3 my-auto">عرض بحسب القسم</span>

                <select  wire:model="deptid" class=" form-select flex-1 dark:bg-darker rounded-md my-2"
                id="color1">
                <option  value="all"> القسم /الجميع
                </option>
                @foreach ($depts as $dept)
                    <option value="{{ $dept->id }}">
                        {{ $dept->name }}</option>
                @endforeach
            </select>
                </h4>

            <h4 class=" flex" dir="rtl">
                <span class="w-1/3 my-auto">عرض الطلبات العميل :
                </span>
                {{-- <select wire:model.lazy='username'  class="bg-white w-2/3 text-dark text-xs dark:text-white dark:bg-dark rounded-md ">
                 <option value="all">جميع العملاء </option>
                 @foreach ($coustmers as $c)
                 <option
                  value="{{ $c->id }}">{{ $c->name }}

                 <span class="p-1 text-xs text-info">{{ "tel:".$c->phone }} </span></option>
                 @endforeach
             </select> --}}
             <div class="w-2/3">
                @livewire('search-user-select',[
                       'user'=>$username
                   ])</div>
                         </h4>
                         <div class="w-full text-center flex">

                         <x-button class=" mx-auto  "  pill="true" variant='info' wire:click='refresh_page'> تحديث

                            <x-heroicon-s-refresh class="text-white w-8 h-8"/>

                       </x-button>
                         </div>
            </div>

            <div class="w-full top-0 right-0 bottom-0 z-30 bg-white bg-opacity-50 fixed" wire:loading
                              >
                            <div class="w-full h-4 bg-blue-900 mt-16 rounded animate-pulse top-10 bottom-0 my-auto"></div>
                        </div>
            <div class="flex flex-col w-full mx-auto overflow-x-scroll md:overflow-x-hidden ">

                <div class="flex flex-wrap mx-auto md:w-2/3 justify-between w-full">

            <h4 class="text-right flex" dir="rtl">عدد العناصر
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
                <div>
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
                </div>
                </div>

                <hr>
                <br>
                {{ $paymentinfos->links() }}
                <table dir="rtl" class="table datatable datatable-User px-4 space-y-6 text-xs border-separate md:min-w-full sm:text-sm text-dark dark:text-light">
                    <thead class=" dark:text-light bg-light dark:bg-dark">
                        <tr>
                            <th class="p-3 ">رقم العملية </th>
                            <th class="p-3 "> البطائق  </th>
                            <th class="p-3  "> سعر البيع</th>
                            <th class="p-3 text-right "> سعر المزود</th>
                            <th class="p-3 text-right ">  المدفوع من العميل</th>
                            <th class="p-3 text-center ">الحالة</th>
                            <th class="p-3 text-right ">تاريخ </th>
                            <th class="p-3 text-right ">العميل</th>
                            <th class="p-3 text-right ">عمليات</th>
                        </tr>
                    </thead>
                    <tbody class="">

                        @foreach ($paymentinfos as $paymentinfo)


                        <tr class="bg-white dark:bg-dark">

                            <td>
                                {{ $paymentinfo->id }}
                                <br>
                                {{ $paymentinfo->code }}
                                
                            </td>
                            <td class="p-0 hidden text-center text-blue-700 font-bold lg:text-lg lg:block">

                                <div class="w-full p-2">


                                    @foreach ($paymentinfo->orders as $order)
                                        <div class="border p-1 rounded-md">
                                            <div class="flex align-items-center">
                                                <div class="w-full  justify-start flex flex-col">
                                                    <div class="flex border-b justify-start space-x-2">
                                                        <div class="w-1/3 text-xs py-2 font-bold mx-2 border-l-1 ">
                                                            البطاقة</div>
                                                        
                                                            <div
                                                            class="w-2/3 mx-2 py-2 text-xs text-info dark:text-info-light">
                                                            {{ $order->product->name }}</div>
                                                    </div>
                                                    <div class="flex border-b justify-start space-x-2">
                                                        <div class="w-1/3 py-2 text-xs font-bold mx-2 border-l-1 ">الكمية
                                                        </div>
                                                        <div
                                                            class="w-2/3 mx-2 py-2 text-xs text-info dark:text-info-light">
                                                            {{ $order->qun }}</div>
                                                    </div>

                                                    @foreach ($order->reqs??[] as $r)

                                                    @if($r['value']!="")
                                                    <div class="flex border-b justify-start space-x-2">
                                                        <div class="w-1/3 text-xs  py-2 font-bold mx-2 border-l-1 ">{{ $r['lable'] }}</div>
                                                        <div
                                                            class="w-2/3 mx-2 text-xs py-2 text-info dark:text-info-light">
                                                            {{ $r['value']}}</div>
                                                    </div>
                                                    @endif
                                                    @endforeach


                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            <td>

                                <div class="flex flex-col text-center">
                                <span
                                    class="bg- mb-1   font-bold p-1 px-1 rounded-md ">
                                    {{ $paymentinfo->order->product->price."  /$" }}
                                </span>
                                </div>
                            </td>
                            <td>
                                <div class="flex flex-col text-center">
                               
                                <span
                                class="bg--dark mb-1  font-bold p-1 px-1 rounded-md ">
                                {{ $paymentinfo->order->product->provider_products()->where('client_provider_id',$client)->first()->price."  /$" }}
                            </span>
                                </div>
                            </td>
                            <td class="p-0 font-bold text-right">
                                <div class="flex flex-col">

                                    <div class="flex flex-col text-center">
                                      
                                <span
                                class="bg- mb-1  font-bold p-1 px-1 rounded-md ">
                                {{ $paymentinfo->total_price."/$" }}
                                   
                            </span>
                            
                                    </div>
                                  

                                </div>
                            </td>
                            <td class="p-0 text-right">
                                <div class="flex flex-col justify-center m-4 text-center">
                                <span class="px-2 {{ $paymentinfo->state==0?"bg-m_primary-lighter":($paymentinfo->state==1? "bg-info":($paymentinfo->state==2?'bg-green-600':'bg-danger')) }} rounded-md text-white p-2">@php
                                    echo  $paymentinfo->state==0?"لم يتم التأكيد":($paymentinfo->state==1? "في انتظار التنفيذ ":($paymentinfo->state==2?'منفذ':'مرفوض'));
                                @endphp</span>

@if($paymentinfo->state==2 || $paymentinfo->state==3)
<span dir="ltr" class="text-xs">{{date('Y-m-d h:i A',strtotime($paymentinfo->excuted_by?->created_at))}}</span>
<span dir="ltr" class="text-xs w-32" dir="ltr">{{$paymentinfo->excuted_by->note}}</span>

        @endif
    </div>
                            </td>

                            <td dir="ltr" class="p-0 text-right" >
                                {{$paymentinfo->updated_at}}

                            </td>


                            <td class=" ">
                                {{ $paymentinfo->user->name }}
                                {{ $paymentinfo->user->phone }}

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
        .dataTables_length{
            display: none !important;
        }
        .dataTables_filter{
            display: none !important;
        }
        .dataTables_info{
            display: none !important;
        }
        .dataTables_paginate{
            display: none !important;
        }
        .table {
            border-spacing: 0 15px;
        }

        i {
            font-size: 1rem !important;
        }

        .table tr {
            border-radius: 20px;
        }

        tr td:nth-child(n+9),
        tr th:nth-child(n+9) {
            border-radius:  .625rem 0 0 .625rem ;
        }

        tr td:nth-child(1),
        tr th:nth-child(1) {
            border-radius:0 .625rem   .625rem 0;
        }
    </style>

    <x-slot name="script">
  
        <script>
            

            


        //     $(function () {
        //     let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
          
        //     $.extend(true, $.fn.dataTable.defaults, {
        //       order: [[ 1, 'desc' ]],
        //       pageLength: 100,
        //     });
        //     $('.datatable-User:not(.ajaxTable)').DataTable({ buttons: dtButtons })
        //       $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        //           $($.fn.dataTable.tables(true)).DataTable()
        //               .columns.adjust();
        //       });
        //   })
          </script>      
    </x-slot>
      
    



    </div>
    </section>
