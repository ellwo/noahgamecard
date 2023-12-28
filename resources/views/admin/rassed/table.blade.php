<section x-data='{open_delete:false}'>
    <div class="relative " x-data="{ show_resave_model: false,show_deny_model:false,amount_u:0,coin_u:'دولار' }">



            <div x-transition:enter="transition duration-500 ease-in-out" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition duration-500 ease-in-out"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-darker opacity-10 z-30" x-show="show_resave_model">

            </div>


            <div  dir="rtl" x-transition:enter="transition duration-500 ease-in-out" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition duration-500 ease-in-out"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                @click.away="show_resave_model=false" x-show="show_resave_model"
                class="fixed z-40 flex flex-col p-8 space-y-4 bg-white border rounded-md text-darker w-1/3 top-24 lg:left-1/2 ">
                <span class="w-full text-3xl font-bold text-right text-danger">ملاحظة</span>
                <hr>
             هل انت متأكد من تاكيد التغذية ؟ <br>سيضاف الملبغ لحساب المستخدم فورا
                <hr>
                    <div wire:ignore class="flex flex-col p-2">
                        {{-- <h6 class="mx-auto flex" dir="rtl">العملة
                            <select wire:model.lazy='coin_id'  class="bg-white text-dark text-xs dark:text-white dark:bg-dark rounded-md ">
                             @foreach ($coins as $c)
                             <option
                             value="{{ $c->id }}">
                             <span class="p-1 text-xs text-info">{{ $c->name." |".$c->nickname }}</span></option>

                             @endforeach
                            </select>
                        </h6> --}}

                        <div class="flex flex-col space-y-2">


                            <x-label value=" المبلغ المدخل من المستخدم " />
                            <span type="text"   x-text="amount_u" readonly class="rounded-md dark:text-white dark:bg-darker text-dark bg-white p-2" name="">
                            </span>

                            <x-label value=" العملة المدخل من المستخدم " />
                            <span type="text"   x-text="coin_u" readonly class="rounded-md dark:text-white dark:bg-darker text-dark bg-white p-2" name="">
                            </span>

                            <x-label value="المبلغ المؤكد " />
                            <input  type="text"   wire:model="amount" class="rounded-md dark:text-white dark:bg-darker text-dark bg-white p-2" name=""/>
                            <span class="text-danger font-bold">ملاحظة هامة يجب ادخال المبلغ المؤكد بعملة الدولار </span>

                        </div>

                    </div>
                    <div class="flex justify-between space-x-2">
                        <x-button variant='success' @click='show_resave_model=false' wire:click='v_accepte'>تأكيد
                        </x-button>
                        <x-button type="button" variant='danger' x-on:click="show_resave_model=false; $wire.cancel()"> الغاء</x-button>
                    </div>
            </div>
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


            <div x-transition:enter="transition duration-500 ease-in-out" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition duration-500 ease-in-out"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-darker opacity-10 z-30" x-show="show_deny_model">

            </div>


            <div x-transition:enter="transition duration-500 ease-in-out" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition duration-500 ease-in-out"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                @click.away="show_deny_model=false" dir="rtl" x-show="show_deny_model"
                class="fixed z-40 flex flex-col p-8 space-y-4 bg-white dark:bg-dark left-1/4 border lg:w-1/2 rounded-md text-darker top-24 mx-auto"

                >
                <span class="w-full text-3xl font-bold text-right text-danger">ملاحظة</span>
                <hr>
                يرجى ادخال سبب رفض الطلب !
                <hr>
                <x-label value="اخنر سبب الرفض "/>
            <br>
            <div class="flex flex-col dark:text-light space-y-2 items-stretch">

                <div @click='$wire.set("note","رقم الحوالة غير صحيح");show_deny_model=false; $wire.d_accepte();' class="border hover:bg-gray-200 hover:text-info rounded-md cursor-pointer p-2  font-bold">
                    رقم الحوالة غير صحيح
                </div>
                <div @click='$wire.set("note","المبلغ غير صحيح") show_deny_model=false; $wire.d_accepte();' class="border rounded-md hover:bg-gray-200 hover:text-info cursor-pointer p-2  font-bold">
                   المبلغ غير صحيح
                </div>
                </div>
                    <div class="flex flex-col p-2">
                        <x-label value="ادخل ملاحظات الرفض " />
                        <textarea wire:model.lazy='note' class="rounded-md dark:text-white dark:bg-darker text-dark bg-white p-2" name=""
                            id="" cols="30" rows="5"></textarea>

                    </div>
                    <div class="flex justify-between space-x-2">
                        <x-button variant='success' @click='show_deny_model=false; $wire.d_accepte() ' >تأكيد
                        </x-button>
                        <x-button type="button" variant='danger' x-on:click="show_deny_model=false;"> الغاء</x-button>
                    </div>
            </div>




        <x-auth-session-status class="mb-4" :status="session('status')" />

        <x-auth-validation-errors class="mb-4" :errors="$errors" />





    <div class="flex flex-col items-center justify-center pt-4 dark:bg-darker">
        <div class="flex flex-col w-full col-span-12 mx-auto">



            <div dir="rtl" class="items-center justify-between mb-4 space-x-2 space-y-2 md:flex md:mx-auto lg:w-1/3">
                <div class="w-full pr-4">
                    <div class="relative md:w-full">
                        <input  wire:model.lazy="search" type="search"
                            class="w-full py-2 pl-10 pr-4 font-medium text-gray-600 rounded-lg shadow focus:outline-none focus:shadow-outline"
                            placeholder="...ادخل رقم الحوالة او رقم عملية الايداع ">
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
                </div>
            </div>


            <div class="flex flex-col space-y-2 lg:w-1/3 mx-auto justify-end justify-items-end">

                <h4 class=" flex" dir="rtl">
                    <span class="w-1/3 my-auto">عرض الطلبات ال</span>
                    <select wire:model.lazy='status'  class="bg-white w-2/3 text-dark  dark:text-white dark:bg-dark rounded-md bg-white">
                        <option value="4">الكل</option>
                       <option
                        value="0">
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
                       'product_id'=>old('user_id')
                   ])</div>
                         </h4>


                         <div  class="flex transition-shadow rounded-lg shadow">
                            <div class="flex flex-col items-center w-full space-y-2 ">
                               <x-button href="{{ route('rasseds.create'  ) }}" class='block w-32' variant="success">
                                اضافة جديد
                                <x-heroicon-o-plus class="w-4 h-4"/>
                               </x-button>
                            </div>
                        </div>
                         <div class="w-full text-center flex">

                         <x-button class=" mx-auto  "  pill="true" variant='info' wire:click='refresh_page'> تحديث

                            <x-heroicon-s-refresh class="text-white w-8 h-8"/>

                       </x-button>
                         </div>
            </div>
             <br>


            <div class="w-full top-0 right-0 bottom-0 z-50 bg-white bg-opacity-50 fixed" wire:loading
                              >
                            <div class="w-full h-4 bg-blue-900 mt-16 rounded animate-pulse top-10 bottom-0 my-auto"></div>
                        </div>
            <div class="flex flex-col w-full mx-auto overflow-x-scroll md:overflow-x-hidden ">

            <h4 class="text-right flex mx-4" dir="rtl">عدد العناصر
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
                <table dir="rtl" class="table lg:px-4 space-y-6 text-xs border-separate md:min-w-full sm:text-sm text-dark dark:text-light">
                    <thead class=" dark:text-light bg-light dark:bg-dark">
                        <tr>
                            <th class="p-3">رقم العملية </th>
                            <th class="p-3 hidden md:block">وسيلة الدفع</th>
                            <th class="p-3 "> المبلغ المدخل من العميل</th>
                            <th class="p-3 "> المبلغ المؤكد </th>
                            <th class="p-3 ">الحالة</th>
                            <th class="p-3 text-right">تاريخ </th>
                            <th class="p-3 text-center ">العميل <br>

                            </th>

                            <th class="p-3 ">عمليات</th>
                        </tr>
                    </thead>
                    <tbody class="">

                        @foreach ($paymentinfos as $paymentinfo)


                        <tr class="bg-white dark:bg-dark">

                            <td class="">
                                <div class="text-center flex flex-col justify-center items-center">

                                {{ $paymentinfo->id }}
                                <hr>
                                <span>كود الحوالة / الايداع</span>
                                <code class="bg-gray-200 rounded-md p-2 text-dark text-center">{{ $paymentinfo->code }}</code>
                                <hr>
                                <div class="md:hidden justify-center">
                                <span class="font-bold text-blue-900 dark:text-gray-200">{{ $paymentinfo->paymentmethod->name }}</span>
                                <hr>
                                <div class=" justify-center">
                                <span class="font-bold text-blue-900 dark:text-gray-200"><a target="_blank" href="{{ $paymentinfo->prove_img }}"><img src="{{ $paymentinfo->prove_img }}" alt="" srcset=""></a></span>

                                </div>
                                </div>


                            </td>
                            <td class="md:p-3 hidden md:block">
                                <span class="font-bold text-blue-900 dark:text-gray-200">{{ $paymentinfo->paymentmethod->name }}</span>
                            </td>
                            <td class="md:p-3  lg:font-bold text-xs ">
                               <div class="text-center flex flex-col justify-center">

                                <span class="bg-m_primary-lighter  p-1 rounded-md"> {{ $paymentinfo->rassed_actevity->camount." /".$paymentinfo->rassed_actevity->coin?->nickname}} </span>
                                <span>{{ $paymentinfo->rassed_actevity->coin?->name }}</span>
                               </div>
                            </td>
                            <td class="text-center">
                                <div class="text-center flex flex-col justify-center">
                                    <span class="bg-info text-white p-1 rounded-md">
                                        {{ $paymentinfo->rassed_actevity->amount." / $"}}</span>
                                </div>
                            </td>
                            <td class="md:p-3 ">
                                <div class="text-center flex flex-col justify-center">

                                    <span class="px-2 p-1 {{ $paymentinfo->state==0?"bg-m_primary-lighter":($paymentinfo->state==1? "bg-m_primary-lighter":($paymentinfo->state==2?'bg-green-600':'bg-red-400')) }} rounded-md text-white">@php
                                        echo  $paymentinfo->state==0?"معلقة":($paymentinfo->state==1? "معلقة ":($paymentinfo->state==2?'مؤكدة':'مرفوض'));
                                    @endphp</span>
                                </div>
                            </td>

                            <td class="p-3 " >
                                <span dir="ltr">
                                    {{date('Y/m/d h:i A',strtotime($paymentinfo->updated_at))}}</span>
                            </td>

                            <td class="flex flex-col p-1 text-center justify-center items-center" dir="rtl">

                                <div class="my-auto">

                                <div class="flex space-x-2">
                                    {{ $paymentinfo->rassed_actevity->rassed->user->name ??""}}
                                 </div>
                                 <div class="flex space-x-2">
                                    {{ $paymentinfo->rassed_actevity->rassed->user->phone ??""}}
                                 </div>
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
                                <div class="flex flex-col space-y-1">

                                    @if ($paymentinfo->state == 2 || $paymentinfo->state==3)

                                <a @click="show_resave_model=true; amount_u={{  $paymentinfo->rassed_actevity->camount }}; coin_u='{{  $paymentinfo->rassed_actevity->coin?->name }}';  $wire.accepte({{ $paymentinfo->rassed_actevity->id }})"  class="mr-2 flex text-white bg-warning rounded-md text-xs md:text-sm  cursor-pointer hover:text-dark p-2  dark:hover:text-gray-100">
                                    <i class=" "><x-bi-pen class="w-5 h-5"/></i>
                                   تعديل المبلغ
                                </a>
                                    @else

                                    <a @click="show_resave_model=true;  amount_u={{  $paymentinfo->rassed_actevity->camount }}; coin_u='{{  $paymentinfo->rassed_actevity->coin?->name }}'; $wire.accepte({{ $paymentinfo->rassed_actevity->id }})"  class="mr-2 flex bg-green-600 rounded-md text-xs md:text-sm  cursor-pointer hover:text-dark p-2  dark:hover:text-gray-100">
                                        <i class="text-base "><x-heroicon-s-check class="w-5 h-5"/></i>
                                        قبول وتأكيد
                                    </a>

                                <a @click="show_deny_model=true; $wire.accepte({{ $paymentinfo->rassed_actevity->id }})"  class="mr-2 flex bg-red-700 rounded-md cursor-pointer text-white mt-2 hover:text-dark p-2  dark:hover:text-gray-100">
                                    <i class="text-base "><x-heroicon-s-x class="w-5 h-5"/></i>
                                    رفض
                                </a>
                                    @endif

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
