<x-dashe-layout>


    <div x-data="{ show_resave_model: false }">

        <div x-transition:enter="transition duration-500 ease-in-out" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition duration-500 ease-in-out"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-darker opacity-10 z-30" x-show="show_resave_model">

        </div>


        <div x-transition:enter="transition duration-500 ease-in-out" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition duration-500 ease-in-out"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            @click.away="show_resave_model=false" x-show="show_resave_model"
            class="fixed z-40 flex flex-col p-8 space-y-4 bg-white border rounded-md text-darker top-24 lg:left-1/2 lg:right-1/5">
            <span class="w-full text-3xl font-bold text-right text-danger">ملاحظة</span>
            <hr>
            يرجى ادخال سبب رفض الطلب !
            <hr>
            <form action="{{ route('paymentinfo.update', $paymentinfo) }}" method="post">
                @method('PUT')
                @csrf
                <input type="hidden" name="state" value="3">

                <div class="flex flex-col p-2">
                    <x-label value="ادخل ملاحظات الرفض " />
                    <textarea dir="rtl" name="note" class="rounded-md dark:text-white dark:bg-darker text-dark bg-white p-2" name=""
                        id="" cols="30" rows="5"></textarea>

                </div>
                <div class="flex justify-between space-x-2">
                    <x-button variant='success' @click='show_resave_model=false' wire:click='makedonresave'>تأكيد
                    </x-button>
                    <x-button type="button" variant='danger' x-on:click="show_resave_model=false;"> الغاء</x-button>
                </div>
            </form>
        </div>


        <div class=" overflow-x-auto  w-full flex items-center justify-center  font-sans ">
            <div class="w-full ">
                <div class="rounded-t bg-white dark:bg-darker min-h-screen mb-0 px-4 py-3 border-0">

                    <x-button href="{{ url()->previous() }}">عودة الى القائمة</x-button>


                    <div class="text-center mb-2 lg:text-4xl text-xl font-bold mx-auto">
                        تفاصيل الطلب رقم : {{ $paymentinfo->id }}
                    </div>
                    <div class=" shadow-sm rounded-md border mx-auto xl:w-2/3 dark:bg-dark">
                        <div dir="rtl" class="flex mx-auto   space-y-4 w-full flex-col">




                            <div class="flex space-y-4 flex-col">
                                <div class="flex lg:flex-col flex-wrap  justify-start space-x-2">
                                    <div class="lg:w-1/3 w-full">
                                        <div class="lg:text-xl font-bold">البطائق المطلوبة </div>
                                    </div>
                                    <div class="lg:w-2/3 w-full">


                                        @foreach ($paymentinfo->orders as $order)
                                            <div class="border p-1 rounded-md">
                                                <div class="flex align-items-center">
                                                    <div class="w-full  justify-start flex flex-col">
                                                        <div class="flex border-b justify-start space-x-2">
                                                            <div class="w-1/3 text-xs py-2 font-bold mx-2 border-l-1 ">اسم
                                                                البطاقة</div>
                                                            <div
                                                                class="w-2/3 mx-2 py-2 text-xs text-blue-700 dark:text-info-light">
                                                                {{ $order->product->name }}</div>
                                                        </div>
                                                        <div class="flex border-b justify-start space-x-2">
                                                            <div class="w-1/3 py-2 text-xs font-bold mx-2 border-l-1 ">الكمية
                                                            </div>
                                                            <div
                                                                class="w-2/3 mx-2 py-2 text-xs text-blue-700 dark:text-info-light">
                                                                {{ $order->qun }}</div>
                                                        </div>

                                                        @foreach ($order->reqs??[] as $r)
                                                        <div class="flex border-b justify-start space-x-2">
                                                            <div class="w-1/3 text-xs  py-2 font-bold mx-2 border-l-1 ">{{ $r['lable'] }}</div>
                                                            <div
                                                                class="w-2/3 mx-2 text-xs py-2 text-blue-700 dark:text-info-light">
                                                                {{ $r['value']}}</div>
                                                        </div>
                                                        @endforeach


                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="flex lg:flex-col flex-wrap  justify-start space-x-2">
                                    <div class="lg:w-1/3 w-full">
                                        <div class="lg:text-xl font-bold">معلومات العميل </div>
                                    </div>
                                    <div class="lg:w-2/3 w-full">
                                        <div class="border p-1 rounded-md">
                                            <div class="flex align-items-center">
                                                <div class=" w-full justify-start flex flex-col">
                                                    <div class="flex border-b justify-start space-x-2">
                                                        <div class="w-1/3 text-xs py-2 font-bold mx-2 border-l-1 ">العميل
                                                        </div>
                                                        <div
                                                            class="w-2/3 mx-2 flex py-2 flex-col text-xs dark:text-info-light text-info">
                                                            <span>
                                                                {{ $paymentinfo->orders()->first()->user->name }}
                                                            </span>
                                                            <span>
                                                                {{ $paymentinfo->orders()->first()->user->phone }}
                                                            </span>
                                                        </div>

                                                    </div>
                                                    <div class="flex  justify-start space-x-2">
                                                        

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex lg:flex-col flex-wrap justify-start space-x-2">
                                    <div class="lg:w-1/3 w-full">
                                        <div class="lg:text-xl font-bold">معلومات الدفع </div>
                                    </div>
                                    <div class="lg:w-2/3 w-full">
                                        <div class="border p-1 rounded-md">
                                            <div class="flex align-items-center">
                                                <div class=" w-full  justify-start flex flex-col">
                                                    <div class="flex border-b justify-start space-x-2">
                                                        <div class="w-1/3 text-xs font-bold py-2 mx-2 border-l-1 ">وسيلة
                                                            الدفع</div>
                                                        <div
                                                            class="w-2/3 mx-2 flex py-2 flex-col text-xs dark:text-info-light text-info">
                                                            <span>
                                                                {{ $paymentinfo->paymentmethod->name }}
                                                            </span>
                                                        </div>

                                                    </div>
                                                    <div class="flex border-b justify-start space-x-2">
                                                        <div class="w-1/3 text-xs py-2 font-bold mx-2 border-l-1 ">كود
                                                            العملية</div>
                                                        <div class="w-2/3 mx-2 py-2 text-xs text-blue-700 dark:text-info-light">
                                                            <span class="">
                                                                {{ $paymentinfo->code }}
                                                            </span>
                                                        </div>

                                                    </div>
                                                    <div class="flex w-full border-b justify-start space-x-2">
                                                        <div class="w-1/3 text-xs py-2 font-bold mx-2 border-l-1 ">الحالة
                                                        </div>
                                                        <div class="w-2/3  mx-2 text-sm p-1">
                                                            <span
                                                                class="{{ $paymentinfo->state!=0 ? 'text-green-600' : 'text-red-800' }}">{{ $paymentinfo->state!=0 ? 'تم تاكيد حالة الدفع' : 'لم يتم تاكيد حالة الدفع' }}</span>
                                                            <br>
                                                            <span
                                                                class="px-2 {{ $paymentinfo->state == 0 ? 'bg-m_primary-lighter' : ($paymentinfo->state == 1 ? 'bg-info' : ($paymentinfo->state == 2 ? 'bg-green-600' : 'bg-red-400')) }} rounded-md text-darker">@php
                                                                    echo $paymentinfo->state == 0 ? 'لم يتم التأكيد' : ($paymentinfo->state == 1 ? 'في انتظار التنفيذ ' : ($paymentinfo->state == 2 ? 'منفذ' : 'مرفوض'));
                                                                @endphp</span>

                                                        </div>
                                                    </div>
                                                    <div class="flex w-full border-b justify-start space-x-2">
                                                        <div class="w-1/3 text-xs py-2 font-bold mx-2 border-l-1 ">ملاحظات
                                                        </div>
                                                        <div class="w-2/3  mx-2 text-sm p-1">
                                                            
                                                            <span>{{$paymentinfo->note}}</span>

                                                        </div>
                                                    </div>
                                                    
                                                    @if($paymentinfo->state==2 || $paymentinfo->state==3)
                                                    <div class="flex w-full border-b justify-start space-x-2">
                                                        <div class="w-1/3 text-xs py-2 font-bold mx-2 border-l-1 ">تم بواسطة 
                                                        </div>
                                                        <div class="w-2/3  mx-2 text-sm p-1">
        
                                                            <span>{{$paymentinfo->excuted_by?->execute->name}}</span>

                                                        </div>
                                                    </div>

                                                    <div class="flex w-full border-b justify-start space-x-2">
                                                        <div class="w-1/3 text-xs py-2 font-bold mx-2 border-l-1 ">ملاحظات المنفذ للعملية 
                                                        </div>
                                                        <div class="w-2/3  mx-2 text-sm p-1">
        
                                                            <span>{{$paymentinfo->excuted_by?->note}}</span>

                                                        </div>
                                                    </div>
                                                    @endif

                                                    <div class="flex w-full justify-start space-x-2">
                                                        <div class="w-1/3 text-xs font-bold mx-2 border-l-1 ">اجمالي
                                                            المبلغ</div>
                                                        <div class="w-2/3  mx-2 text-sm p-1">

                                                            <s
                                                                class="px-2">{{ ' المبلغ قبل الخصم ' . $paymentinfo->orginal_total . "$" }}</s>
                                                            <br>
                                                            <span class="px-2 ">
                                                                {{ ' المبلغ بعد الخصم ' . $paymentinfo->total_price . "$" }}
                                                            </span>

                                                            <br>
                                                            <span class="px-2 ">
                                                                {{ ' المبلغ المدفوع ' . $paymentinfo->total_price . "$" }}
                                                            </span>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>






                            @if($paymentinfo->state==1)

                            <div class="flex flex-wrap justify-between space-x-4">
                                <form action="{{ route('paymentinfo.update', $paymentinfo) }}" method="post">
                                    @method('PUT')
                                    @csrf
                                    <input type="hidden" name="state" value="2">


                                    <x-button variant="success">
                                        قبول الطلب وتنفيذه
                                    </x-button>

                                </form>
                                <x-button type="button" @click="show_resave_model=true" variant="danger">
                                    رفض الطلب
                                </x-button>
                            </div>
                            @endif



                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-dashe-layout>
