<x-dashe-layout>


<div x-data="{show_resave_model:false}">

    <div x-transition:enter="transition duration-500 ease-in-out" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition duration-500 ease-in-out"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    class="fixed inset-0 bg-darker opacity-10 z-30"
    x-show="show_resave_model">

</div>


    <div x-transition:enter="transition duration-500 ease-in-out" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition duration-500 ease-in-out"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"

    @click.away="show_resave_model=false" x-show="show_resave_model" class="fixed z-40 flex flex-col p-8 space-y-4 bg-white border rounded-md text-darker top-24 left-1/2 right-1/5">
        <span class="w-full text-3xl font-bold text-right text-danger">ملاحظة</span>
        <hr>
        يرجى ادخال سبب رفض الطلب  !
        <hr>
        <form action="{{ route('paymentinfo.update',$paymentinfo) }}" method="post">
        @method('PUT')
            @csrf
            <input type="hidden" name="state" value="3">

        <div  class="flex flex-col p-2">
            <x-label value="ادخل ملاحظات الرفض "/>
            <textarea name="note" class="rounded-md dark:text-white dark:bg-darker text-dark bg-white p-2" name="" id="" cols="30" rows="5"></textarea>

        </div>
        <div class="flex justify-between space-x-2">
  <x-button variant='success' @click='show_resave_model=false'
  wire:click='makedonresave'>تأكيد </x-button>
  <x-button type="button" variant='danger' x-on:click="show_resave_model=false;" > الغاء</x-button>
        </div>
    </form>
    </div>


    <div class=" overflow-x-auto  w-full flex items-center justify-center  font-sans ">
        <div class="w-full ">
            <div class="rounded-t bg-white dark:bg-darker min-h-screen mb-0 px-4 py-3 border-0">

                <x-button href="{{ url()->previous() }}">عودة الى القائمة</x-button>


                <div class="text-center text-4xl font-bold mx-auto">
                    تفاصيل الطلب رقم : {{ $paymentinfo->id }}
                </div>
                <div class="m-6 p-6 shadow-sm rounded-md border dark:bg-dark">
                    <div dir="rtl" class="flex mx-auto rounded-sm border p-2 space-y-4 xl:w-2/3 flex-col">




                        <div class="flex flex-col">
                            <div class="flex border-b justify-start space-x-2">
                                <div class="w-1/3">
                                    <div class="text-xl font-bold">البطائق المطلوبة </div>
                               </div>
                                <div class="w-2/3">


                @foreach ($paymentinfo->orders as $order )
                <div class="border p-1 rounded-md">
                <div class="flex align-items-center">
                    <div class="w-full  justify-start flex flex-col">
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
                        <div class="flex border-b justify-start space-x-2">
                            <div class="w-1/3 text-xs font-bold mx-2 border-l-1 ">البريد الالكتروني</div>
                            <div class="w-2/3 mx-2 text-xs text-info">{{ $order->email??"لايوجد" }}</div>
                        </div>
                        <div class="flex border-b justify-start space-x-2">
                            <div class="w-1/3 text-xs font-bold mx-2 border-l-1 ">كلمة المرور</div>
                            <div class="w-2/3 mx-2 text-xs text-info">{{ $order->password??"لايوجد"}}</div>
                        </div>

                    </div>
                </div>
                </div>
                <hr>
                @endforeach
                </div>
                            </div>
                            <div class="flex border-b justify-start space-x-2">
                                <div class="w-1/3">
                <div class="text-xl font-bold">معلومات العميل </div></div>
                                <div class="w-2/3">
                <div class="border p-1 rounded-md">
                    <div class="flex align-items-center">
                        <div class=" w-full justify-start flex flex-col">
                            <div class="flex border-b justify-start space-x-2">
                                <div class="w-1/3 text-xs font-bold mx-2 border-l-1 ">العميل</div>
                                <div class="w-2/3 mx-2 flex flex-col text-xs text-info">
                                   <span>
                                    {{ $paymentinfo->orders()->first()->user->name }}
                                   </span>
                                   <span>
                                    {{"@".$paymentinfo->orders()->first()->user->username }}
                                   </span>
                                   <span>
                                    {{ $paymentinfo->orders()->first()->user->phone }}
                                </span>
                                </div>

                            </div>
                            <div class="flex border-b justify-start space-x-2">
                                <div class="w-1/3 text-xs font-bold mx-2 border-l-1 ">امتياز العميل</div>
                                <div class="w-2/3 mx-2 flex flex-wrap text-xs text-info">
                                  @foreach ($paymentinfo->orders()->first()->user->roles as $role)

                                    <span class="bg-m_primary-lighter m-2 p-1  text-dark rounded-md inline-block ">
                                        {{ $role->name }}
                                    </span>
                                  @endforeach
                                </div>

                            </div>
                            <div class="flex border-b justify-start space-x-2">
                                <div class="w-1/3 text-xs font-bold mx-2 border-l-1 ">العميل</div>
                                <div class="w-2/3 mx-2 text-xs text-info">{{ $paymentinfo->orders()->first()->user->name }}</div>

                            </div>
                        </div>
                    </div>
                </div>
</div>
                            </div>
                            <div class="flex border-b justify-start space-x-2">
                                <div class="w-1/3">
                <div class="text-xl font-bold">معلومات الدفع </div></div>
                                <div class="w-2/3">
                <div class="border p-1 rounded-md">
                    <div class="flex align-items-center">
                        <div class=" w-full  justify-start flex flex-col">
                            <div class="flex border-b justify-start space-x-2">
                                <div class="w-1/3 text-xs font-bold mx-2 border-l-1 ">وسيلة الدفع</div>
                                <div class="w-2/3 mx-2 flex flex-col text-xs text-info">
                                   <span>
                                    {{ $paymentinfo->paymentmethod->name }}
                                   </span>
                                </div>

                            </div>
                            <div class="flex border-b justify-start space-x-2">
                                <div class="w-1/3 text-xs font-bold mx-2 border-l-1 ">كود العملية</div>
                                <div class="w-2/3 mx-2 text-xs text-info">
                                    <span class="">
                                        {{ $paymentinfo->code }}
                                    </span>
                                </div>

                            </div>
                            <div class="flex w-full border-b justify-start space-x-2">
                                <div class="w-1/3 text-xs font-bold mx-2 border-l-1 ">الحالة</div>
                                <div class="w-2/3  mx-2 text-sm p-1">
                                    <span class="{{ $paymentinfo->accepted?'text-green-600':'text-red-800'}}">{{ $paymentinfo->accepted?"تم تاكيد حالة الدفع":"لم يتم تاكيد حالة الدفع" }}</span>
                        <br>
                                    <span class="px-2 {{ $paymentinfo->state==0?"bg-m_primary-lighter":($paymentinfo->state==1? "bg-info":($paymentinfo->state==2?'bg-green-600':'bg-red-400')) }} rounded-md text-darker">@php
                                        echo  $paymentinfo->state==0?"لم يتم التأكيد":($paymentinfo->state==1? "في انتظار التنفيذ ":($paymentinfo->state==2?'منفذ':'مرفوض'));
                                    @endphp</span>

                                </div>

                            </div>

                            <div class="flex w-full border-b justify-start space-x-2">
                                <div class="w-1/3 text-xs font-bold mx-2 border-l-1 ">اجمالي المبلغ</div>
                                <div class="w-2/3  mx-2 text-sm p-1">

                                    <s class="px-2">{{ " المبلغ قبل الخصم ".$paymentinfo->orginal_total()."$"}}</s>
                        <br>
                                    <span class="px-2 ">
                                        {{ " المبلغ بعد الخصم ".$paymentinfo->total_price."$" }}
                                        </span>

                                        <br>
                                    <span class="px-2 ">
                                        {{ " المبلغ المدفوع ".$paymentinfo->mount_pay."$" }}
                                        </span>

                                </div>

                            </div>
                        </div>
                    </div>
                </div></div>
                            </div>
                        </div>






                <div class="flex flex-wrap justify-between space-x-4">
                    <form action="{{ route('paymentinfo.update',$paymentinfo) }}" method="post">
                    @method('PUT')
                        @csrf
                    <input type="hidden" name="state" value="2">
                    <x-button variant="success">
                        قبول الطلب وتنفيذه
                    </x-button>

                    </form>
                    <x-button @click="show_resave_model=true" variant="danger">
                        رفض الطلب
                    </x-button>


                </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</x-dashe-layout>
