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




            <div class="flex flex-col justify-end mx-auto space-y-2 lg:w-1/3 justify-items-end">

                <h4 class="flex " dir="rtl">
                    <span class="w-1/3 my-auto">عرض الطلبات ال</span>
                    <select wire:model.lazy='status'  class="w-2/3 bg-white rounded-md text-dark text-md dark:text-white dark:bg-dark">
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

                <h4 class="flex " dir="rtl">
                    <span class="w-1/3 my-auto">عرض بحسب القسم</span>

                <select  wire:model="deptid" class="flex-1 my-2 rounded-md form-select dark:bg-darker"
                id="color1">
                <option  value="all"> القسم /الجميع
                </option>
                @foreach ($depts as $dept)
                    <option value="{{ $dept->id }}">
                        {{ $dept->name }}</option>
                @endforeach
            </select>
                </h4>

            <h4 class="flex " dir="rtl">
                <span class="w-1/3 my-auto">عرض الطلبات العميل :
                </span>
                {{-- <select wire:model.lazy='username'  class="w-2/3 text-xs bg-white rounded-md text-dark dark:text-white dark:bg-dark ">
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
                         <div class="flex w-full text-center">

                         <x-button class="mx-auto "  pill="true" variant='info' wire:click='refresh_page'> تحديث

                            <x-heroicon-s-refresh class="w-8 h-8 text-white"/>

                       </x-button>
                         </div>
            </div>

            <div class="fixed top-0 bottom-0 right-0 z-30 w-full bg-white bg-opacity-50" wire:loading
                              >
                            <div class="bottom-0 w-full h-4 my-auto mt-16 bg-blue-900 rounded animate-pulse top-10"></div>
                        </div>
            <div class="flex flex-col w-full mx-auto overflow-x-scroll md:overflow-x-hidden ">

                <div class="flex flex-wrap justify-between w-full mx-auto md:w-2/3">

            <h4 class="flex text-right" dir="rtl">عدد العناصر
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
                <table dir="rtl" class="table px-4 space-y-6 text-xs border-separate md:min-w-full sm:text-sm text-dark dark:text-light">
                    <thead class=" dark:text-light bg-light dark:bg-dark">
                        <tr>
                            <th class="p-3 text-right">رقم العملية </th>
                            <th class="hidden p-3 text-right lg:block"> البطائق  </th>
                            <th class="p-3 text-right ">  السعر</th>
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
                                <br>
                                {{ $paymentinfo->id }}
                                <hr>
                                <span></span>
                                {{ $paymentinfo->code }}
                                <hr>
                                <span class="{{ $paymentinfo->state!=0 ? 'text-green-600' : 'text-red-800' }}">{{ $paymentinfo->state!=0 ? 'تم تاكيد حالة الدفع' : 'لم يتم تاكيد حالة الدفع' }}</span>

                            </td>
                            <td class="hidden p-0 font-bold text-center text-blue-700 lg:text-lg lg:block">

                                <div class="w-full p-2">


                                    @foreach ($paymentinfo->orders as $order)
                                        <div class="p-1 border rounded-md">
                                            <div class="flex align-items-center">
                                                <div class="flex flex-col justify-start w-full">
                                                    <div class="flex justify-start space-x-2 border-b">
                                                        <div class="w-1/3 py-2 mx-2 text-xs font-bold border-l-1 ">اسم
                                                            البطاقة</div>
                                                        <div
                                                            class="w-2/3 py-2 mx-2 text-xs text-info dark:text-info-light">
                                                            {{ $order->product->name??'Deleted' }}</div>
                                                    </div>
                                                    <div class="flex justify-start space-x-2 border-b">
                                                        <div class="w-1/3 py-2 mx-2 text-xs font-bold border-l-1 ">الكمية
                                                        </div>
                                                        <div
                                                            class="w-2/3 py-2 mx-2 text-xs text-info dark:text-info-light">
                                                            {{ $order->qun }}</div>
                                                    </div>

                                                    @foreach ($order->reqs??[] as $r)

                                                    @if($r['value']!="")
                                                    <div class="flex justify-start space-x-2 border-b">
                                                        <div class="w-1/3 py-2 mx-2 text-xs font-bold border-l-1 ">{{ $r['lable'] }}</div>
                                                        <div
                                                            class="w-2/3 py-2 mx-2 text-xs text-info dark:text-info-light">
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
                            <td class="p-0 font-bold text-right">
                                <div class="flex flex-col">

                                    @if ($paymentinfo->orginal_total-$paymentinfo->total_price>0)

                                    <s> {{ $paymentinfo->orginal_total."/$"}}</s>
                                    <span>
                                        {{ $paymentinfo->total_price."/$" }}
                                    </span>
                                    @else

                                 <span>
                                        {{ $paymentinfo->total_price."/$" }}
                                    </span>
                                    @endif

                                </div>
                            </td>
                            <td class="p-0 text-right">
                                <div class="flex flex-col justify-center m-4 text-center">
                                <span class="px-2 {{ $paymentinfo->state==0?"bg-m_primary-lighter":($paymentinfo->state==1? "bg-info":($paymentinfo->state==2?'bg-green-600':'bg-red-400')) }} rounded-md text-white p-2">@php
                                    echo  $paymentinfo->state==0?"لم يتم التأكيد":($paymentinfo->state==1? "في انتظار التنفيذ ":($paymentinfo->state==2?'منفذ':'مرفوض'));
                                @endphp</span>

@if($paymentinfo->state==2 || $paymentinfo->state==3)
         <span class="font-bold text-blue-700">بواسطة : </span>
         <span>{{$paymentinfo->excuted_by?->execute->name}}</span>
         <span dir="ltr" class="text-xs">{{date('Y-m-d h:i A',strtotime($paymentinfo->excuted_by?->created_at))}}</span>

        @endif
    </div>
                            </td>

                            <td dir="ltr" class="p-0 text-right" >
                               انشئت في :  {{date($paymentinfo->created_at,'Y-m-d h:i A') }}
                               <hr>
                               تم تحديثها  في :  {{date($paymentinfo->updated_at,'Y-m-d h:i A') }}


                            </td>


                            <td class="">
                                {{ $paymentinfo->user->name }}
                                {{ $paymentinfo->user->phone }}

                            </td>
                            <td class="">
                                <div class="flex">

                                <a href="{{ route('paymentinfo.show',$paymentinfo) }}"  class="flex mr-2 text-gray-400 hover:text-dark dark:hover:text-gray-100">
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

        tr td:nth-child(n+7),
        tr th:nth-child(n+7) {
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
