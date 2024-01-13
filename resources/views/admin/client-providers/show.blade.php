<x-dashe-layout>
    {{-- <livewire:datatable
     model="App\Models\User"
      exclude="avatar,bio,banned_at,email_verified_at,updated_at,phone_verified_at"
      searchable="name,phone"
      exportable
      /> --}}

      <div class="" dir="rtl">


        <div class="border p-1 rounded-md bg-white dark:bg-darker mt-2">
            <div class="flex align-items-center">
                <div class="w-full  justify-start flex flex-col">
                    <div class="flex border-b justify-start space-x-2">
                        <div class="w-1/3 text-lg py-2 font-bold mx-2 border-l-1 ">
                            اسم المزود</div>

                            <div
                            class="w-2/3 mx-2 py-2 text-lg  dark:-light">
                            {{ $client->name }}</div>
                    </div>
                    <div class="flex border-b justify-start space-x-2">
                        <div class="w-1/3 py-2 text-lg font-bold mx-2 border-l-1 ">الرصيد الحالي
                        </div>
                        <div
                            class="w-2/3 mx-2 py-2 text-lg  dark:-light">
                            {{ $client->rassedy() }}</div>
                    </div>


                    <div class="flex border-b justify-start space-x-2">
                        <div class="w-1/3 py-2 text-lg font-bold mx-2 border-l-1 ">اجمالي  العمليات المنفذة بحسب سعر البيع
                        </div>
                        <div
                            class="w-2/3 mx-2 py-2 text-lg  dark:-light">
                            {{ abs($client->pay_sum()) }}</div>
                    </div>



                    <div class="flex border-b justify-start space-x-2">
                        <div class="w-1/3 py-2 text-lg font-bold mx-2 border-l-1 ">اجمالي العمليات المنفذة بحسب سعر المزود
                        </div>
                        <div
                            class="w-2/3 mx-2 py-2 text-lg  dark:-light">
                            {{ $client->pay_sum_orgin() }}</div>
                    </div>


                    <div class="flex border-b justify-start space-x-2">
                        <div class="w-1/3 py-2 text-lg font-bold mx-2 border-l-1 ">فارق سعر البيع عن سعر المزود
                        </div>
                        <div
                            class="w-2/3 mx-2 py-2 text-lg  dark:-light">
                            {{ abs($client->pay_sum())-$client->pay_sum_orgin() }}</div>
                    </div>


                    <div class="flex border-b justify-start space-x-2">
                        <div class="w-1/3 py-2 text-lg font-bold mx-2 border-l-1 ">حالة المزود
                        </div>
                        <div
                            class="w-2/3 mx-2 py-2 text-lg  dark:-light">
                            {{ $client->active?"نشط":"غير نشط " }}</div>
                    </div>


                    <div class="flex  justify-start space-x-2">
                        <div class="w-1/3 py-2 text-lg font-bold mx-2 border-l-1 ">عدد المنتجات المرتبطة
                        </div>
                        <div
                            class="w-2/3 mx-2 py-2 text-lg  dark:-light">
                            {{ $client->provider_products()->active()->count() }}</div>
                    </div>





                </div>
            </div>
        </div>





      </div>
      <div dir="rtl" class="p-6 overflow-hidden m-4 bg-white rounded-md shadow-md dark:bg-darker">
     العمليات المنفذة بواسطة {{$client->name}}
    </div>

      @livewire('orders.clients-orders',['client'=>$client->id,'deptid'=>$_GET['deptid']??'all','username'=>$_GET['username']??-1], key(time()))



</x-dashe-layout>
