<section id="tablec" x-data='{open_delete:false}'>



    <div class="relative ">



        <div x-show="open_delete" class="absolute z-50 flex flex-col p-8 space-y-4 bg-white rounded-md top-24 right-1/2">
            <span class="w-full text-danger">تنويه</span>
            <hr>
            هل انت متأكد من الغاء تنشيط المزود سيتم الغاء تنشيط جميع المنتجات المرتبطة  ؟
            <div class="flex justify-between space-x-2">
      <x-button variant='success' @click='open_delete=false'
       wire:click='deletePro({{$delete_orderid}})'
      >تأكيد</x-button>
      <x-button variant='danger' x-on:click="open_delete=false;$wire.set('delete_orderid',-1)" > الغاء</x-button>
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
                <x-button class=" mx-auto  "  pill="true" variant='info' wire:click='refresh_page'> تحديث

                    <x-heroicon-s-refresh class="text-white w-8 h-8"/>

               </x-button>
                </div>

                <hr>
                <br>
                {{ $users->links() }}
                <table dir="rtl" class="datatable table px-4 space-y-6 text-xs border-separate md:min-w-full sm:text-sm text-dark dark:text-light">
                    <thead class=" dark:text-light bg-light dark:bg-dark">
                        <tr>
                            <th class="p-3 tdp text-right">اسم المزود </th>
                            <th class="p-3 tdp text-right "> رقم الهاتف  </th>
                            <th class="p-3 tdp text-right ">  اجمالي المشتروات</th>
                            <th class="p-3 tdp text-right "> عدد المنتجات المرتبطة</th>
                            <th class="p-3 tdp text-right ">الرصيد الحالي  </th>
                            <th class="p-3 tdp text-right ">الحالة</th>
                            <th class="p-3 text-right ">عمليات</th>
                        </tr>
                    </thead>
                    <tbody class="">

                        @foreach ($users as $clients_provider)


                        <tr class="bg-white dark:bg-dark">

                            <td class="tdp flex flex-col">
                                {{ $clients_provider->name }}
                                {{-- <span class="text-info text-xs font-semibold">

                                    
                                {{ $clients_provider->username."@" }}
                                </span>
                                <span class="text-info text-xs font-semibold">

                                    {{ $clients_provider->email}}
                                    </span>
                                <hr> --}}
                                {{-- <span class="{{ $clients_provider->state!=0 ? 'text-green-600' : 'text-red-800' }}">{{ $clients_provider->state!=0 ? 'تم تاكيد حالة الدفع' : 'لم يتم تاكيد حالة الدفع' }}</span> --}}

                            </td>
                            <td class="p-0  tdp text-right  ">

                                <div class="">
                                    {{ $clients_provider->phone }}
                                </div>
                            </td>
                            <td class="p-0 tdp text-danger font-bold lg:text-lg">
                                <div class="flex flex-col">
                                    <span>
                                        {{abs( $clients_provider->pay_sum()) }} / بحسب سعرنا
                                    </span>
                                    <span>
                                        {{abs( $clients_provider->pay_sum_orgin()) }} / بحسب سعر المزود

                                    </span>
                                </div>
                            </td>
                            <td class="p-0 tdp  flex flex-col justify-center text-blue-700 font-bold lg:text-lg">
                                {{ $clients_provider->provider_products()->active()->count() }}

                                <a target="_blank" href="{{ route('provider_products',['client'=>$clients_provider->id]) }}"  class="mr-2 flex text-sm text-gray-400 hover:text-dark dark:hover:text-gray-100">
                                    <i class="text-base "><x-heroicon-s-eye class="w-5 h-5"/></i>
                                    عرض المنتجات
                                </a>

                            </td>

                            <td dir="ltr" class="p-0 tdp text-right text-success font-bold lg:text-lg" >
                                {{ $clients_provider->rassedy()  }} ريال يمني
                                <br>
                                {{  number_format((float)( $clients_provider->rassedy()/$coin?->value), 2, '.', '') }} دولار امريكي

                            </td>


                            <td class="block text-center" x-data='{isActive:{{$clients_provider->active??0}}}'>

                                <div class="flex flex-col justify-center text-center">

                                    @if ($clients_provider->active)

                                    <button dir="ltr" aria-hidden="true" class="mx-auto relative focus:outline-none" x-cloak

                                    {{-- wire:click="deletePro({{$clients_provider->id}})"
                                     --}}
                                    @click="open_delete=!open_delete; $wire.set('delete_orderid',{{$clients_provider->id}})">
                                        <div
                                            class="w-12 h-6 transition rounded-full outline-none  dark:"
                                            :class="{
                                                'bg-success':isActive,
                                                'bg-gray-400':!isActive
                                            }"
                                            >
                                        </div>
                                        <div class="absolute top-0 left-0 inline-flex items-center justify-center w-6 h-6 transition-all duration-150 transform scale-110 border rounded-full shadow-sm"
                                            :class="{ 'translate-x-0 -translate-y-px  bg-white text-primary-dark': !isActive,
                                             'translate-x-6 text-primary-100 bg-white': isActive }">


                                        </div>
                                    </button>
                                    @else

                                    <button dir="ltr" aria-hidden="true" class="mx-auto relative focus:outline-none" x-cloak

                                     wire:click="active_client({{$clients_provider->id}})"

                                    @click="isActive=true">
                                        <div
                                            class="w-12 h-6 transition rounded-full outline-none  dark:"
                                            :class="{
                                                'bg-success':isActive,
                                                'bg-gray-400':!isActive
                                            }"
                                            >
                                        </div>
                                        <div class="absolute top-0 left-0 inline-flex items-center justify-center w-6 h-6 transition-all duration-150 transform scale-110 border rounded-full shadow-sm"
                                            :class="{ 'translate-x-0 -translate-y-px  bg-white text-primary-dark': !isActive,
                                             'translate-x-6 text-primary-100 bg-white': isActive }">


                                        </div>
                                    </button>
                                    @endif

                                    <div x-show="!isActive" class="">
                                        غير نشط
                                      </div>
                                      <div x-show="isActive" class="">
                                           نشط
                                        </div>
                                </div>

                            </td>
                            <td class="">
                                <div class="flex">

                                <a href="{{ route('clients-provider.show',['clients_provider'=>$clients_provider,'client'=>$clients_provider->id]) }}"  class="mr-2 flex text-gray-400 hover:text-dark dark:hover:text-gray-100">
                                    <i class="text-base "><x-heroicon-s-eye class="w-5 h-5"/></i>
                                    عرض تفاصيل
                                </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $users->links() }}
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

    <x-slot name="script">
        {{-- <script src="{{ asset('local/jquery.min.js') }}"></script>

        <script src="{{ asset('local/bootstrap.min.js') }}"></script>

        <script src="{{ asset('local/popper.min.js') }}"></script>

        <script src="{{ asset('local/coreui.min.js') }}"></script>

        <script src="{{ asset('local/jquery.dataTables.min.js') }}"></script>

        <script src="{{ asset('local/dataTables.bootstrap4.min.js') }}"></script>

        <script src="{{ asset('local/dataTables.buttons.min.js') }}"></script>


        <script src="{{ asset('local/buttons.flash.min.js') }}"></script>

        <script src="{{ asset('local/buttons.html5.min.js') }}"></script>

        <script src="{{ asset('local/buttons.print.min.js') }}"></script>

        <script src="{{ asset('local/buttons.colVis.min.js') }}"></script>
        <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>

        <script src="{{ asset('local/vfs_fonts.js') }}"></script>
        <script src="{{ asset('local/jszip.min.js') }}"></script>



        <script src="{{ asset('local/dataTables.select.min.js') }}"></script>

        <script src="{{ asset('local/moment.min.js') }}"></script>

        <script src="{{ asset('local/select2.full.min.js') }}"></script>

        <script src="{{ asset('local/dropzone.min.js') }}"></script>

<script>
         $(function() {

 $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, { className: 'btn' })
  $.extend(true, $.fn.dataTable.defaults, {
    language: {

"sProcessing":   "جارٍ التحميل...",
"sLengthMenu":   "أظهر _MENU_ مدخلات",
"sZeroRecords":  "لم يعثر على أية سجلات",
"sInfo":         "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
"sInfoEmpty":    "يعرض 0 إلى 0 من أصل 0 سجل",
"sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
"sInfoPostFix":  "",
"sSearch":       "ابحث:",
"sUrl":          "",
"oPaginate": {
    "sFirst":    "الأول",
    "sPrevious": "السابق",
    "sNext":     "التالي",
    "sLast":     "الأخير"
}

},
    pageLength: 100,

    dom: 'lBfrtip<"actions">',
    buttons: [


    {
        extend: 'pdf',
        className: 'btn-default',
        text: "PDF",
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'excel',
        className: 'btn-default bg-success rounded-md p-2 mx-2',
        text: "استخراج ملف اكسل  ",
        exportOptions: {
          columns: ':visible'
        }
      },

      {
        extend: 'print',
        className: 'btn-default',
        text: "طباعة",
        exportOptions: {
          columns: '.tdp'
        }
      },

    ]
  });

  $.fn.dataTable.ext.classes.sPageButton = '';
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

  $('.datatable').DataTable({ buttons: dtButtons ,
searchable:false})
    // $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
    //     $($.fn.dataTable.tables(true)).DataTable()
    //         .columns.adjust();
    // });
});
</script> --}}
    </x-slot>
