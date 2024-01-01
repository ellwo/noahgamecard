<section x-data='{open_delete:false}'>
    <div class="relative " x-data="{ show_resave_model: false,show_deny_model:false,body:'',img:'',sented:'تم الارسال',title:'',user:'' }">
        <div x-transition:enter="transition duration-500 ease-in-out" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition duration-500 ease-in-out"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-darker opacity-10 z-30" x-show="show_resave_model">

    </div>


    <div  dir="rtl" x-transition:enter="transition duration-500 ease-in-out" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition duration-500 ease-in-out"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        @click.away="show_resave_model=false; user=''; body=''; title='';" x-show="show_resave_model"
        class="fixed z-40 flex flex-col p-8 space-y-4 bg-white dark:bg-darker border rounded-md  w-1/3 top-24 lg:left-1/2 ">
        <span class="w-full text-xl font-bold text-right ">تفاصيل الرسالة</span>
        <hr>
            <div wire:ignore class="flex flex-col p-2">

                <div x-show="img!=''">
                    <img x-bind:src="img" height="100"  alt="" width="100">
                </div>
                <div class="flex flex-col space-y-2">
                    <x-label value="العميل " />
                    <span type="text"   x-text="user" readonly class="dark:text-white dark:bg-darker text-dark bg-white p-2" name="">
                    </span>

                    <x-label value="عنوان الرسالة " />
                    <span type="text"   x-text="user" readonly class="dark:text-white dark:bg-darker text-dark bg-white p-2" name="">
                    </span>

                    <x-label value="الرسالة" />
                    <input readonly wire:model='body' class="rounded-md dark:text-white dark:bg-darker text-dark bg-white p-2"/>

                    <x-label value="الحالة" />
                    <span     x-text="sented" class="rounded-md dark:text-white dark:bg-darker text-dark bg-white p-2">
                    </span>

                </div>

            </div>
            <div class="flex justify-between space-x-2">
            </div>
    </div>
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <x-auth-validation-errors class="mb-4" :errors="$errors" />





    <div class="flex flex-col items-center justify-center pt-4 dark:bg-darker">
        <div class="flex flex-col w-full col-span-12 mx-auto">



            <div dir="rtl" class="items-center justify-between mb-4 space-x-2 space-y-2 md:flex md:mx-auto lg:w-2/3">
                <div class="w-full hidden pr-4">
                    <div class="relative md:w-full">
                        <input  wire:model.lazy="search" type="search"
                            class="w-full py-2 pl-10 pr-4 font-medium text-gray-600 rounded-lg shadow focus:outline-none focus:shadow-outline"
                            placeholder=".... ">
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


            <div class="flex flex-col space-y-2 lg:w-2/3 mx-auto justify-end justify-items-end">

                <h4 class=" flex" dir="rtl">
                    <span class="w-1/3 my-auto">عرض الاشعارات ال</span>
                    <select wire:model.lazy='status'  class="bg-white w-2/3 text-dark  dark:text-white dark:bg-dark rounded-md bg-white">
                        <option value="-1">الكل</option>
                       <option
                        value="1">
                        <span class="p-1 text-xs text-info">المرسلة</span></option>
                        <option
                        value="0">
                        <span class="p-1 text-xs text-info">المعلقة</span></option>

                    </select>
                </h4>

            <h4 class=" flex" dir="rtl">
                <span class="w-1/3 my-auto">عرض الاشعارت الخاصة بالعميل :
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
                               <x-button href="{{ route('usernotification.create'  ) }}" class='block w-32' variant="success">
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
                            <th class="p-3">عنوان الرسالة </th>
                            <th class="p-3 hidden md:block">العميل</th>
                            <th class="p-3 ">الحالة</th>
                            <th class="p-3 text-right">تاريخ </th>
                            </th>

                            <th class="p-3 ">عمليات</th>
                        </tr>
                    </thead>
                    <tbody class="">

                        @foreach ($notifiys as $n)


                        <tr class="bg-white dark:bg-dark">

                            <td class="">
                                <div class="text-center flex flex-col justify-center items-center">

                                {{ $n->title }}
                                <hr>
                                </div>


                            </td>
                            <td class="md:p-3 hidden md:block">
                                <span class="font-bold text-blue-900 dark:text-gray-200">{{ $n->user?->name }}</span>
                            </td>
                            <td class="md:p-3 ">
                                <div class="text-center flex flex-col justify-center">

                                    <span class="px-2 p-1 {{ $n->sented==1?'bg-green-600':'bg-red-400' }} rounded-md text-white">
                                    @php
                                        echo  $n->sented==0?"معلقة":"مرسلة";
                                    @endphp</span>
                                </div>
                            </td>

                            <td class="p-3 " >
                                <span dir="ltr">
                                    {{date('Y/m/d h:i A',strtotime($n->created_at))}}</span>
                            </td>
                            <td class="">
                                <div class="flex flex-col space-y-1">

                                    @if ($n->sented ==0)

                                <a @click="$wire.resend({{$n->id}})"  class="mr-2 flex text-center justify-center text-white bg-warning rounded-md text-xs md:text-sm  cursor-pointer hover:text-dark p-2  dark:hover:text-gray-100">
                                    <i class=" "><x-heroicon-s-refresh class="w-5 h-5"/></i>
                                   اعادة ارسال
                                </a>

                                    @endif

                                    {{--   body='{{ $n->body }}'; --}}
                                <a wire:click='setBody({{$n->id}})' @click="img='{{ $n->img }}'; title='{{ $n->title }}'; user='{{ $n->user->name }}';   sented='{{ $n->sented==0?'معلقة':'تم الارسال' }}';  show_resave_model=true;"  class="mr-2 flex text-center justify-center  rounded-md cursor-pointer  mt-2 hover:text-dark p-2  dark:hover:text-gray-100">
                                    <i class="text-base "><x-heroicon-s-eye class="w-5 h-5"/></i>
                                    عرض المحتوى
                                </a>

                                <a wire:click="setDeleteDept({{$n->id}})" class="w-4 mr-2 mt-2 cursor-pointer transform hover:text-red-800 hover:scale-110">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    حذف
                                </a>

                                @if($deleteDept!="no" && $d->id==$deleteDept)

                                <div x-data="{dpm{{$deleteDept}}: 1}">
                                    <div  x-show="dpm{{$deleteDept}}" class="dialog">
                                        <div class="dialog-content">
                                            <div class="dialog-header dark:text-black">هل انت متاكد من الحذف
                                            </div>
                                            <div class="dialog-body lg:flex" dir="auto">
                                                <h1 class="text-xl text-red-800 font-bold p-4 rounded-lg ">
                                                   هل انت متأكد من الحذف ؟؟!!
                                                </h1>
                                            </div>
                                            <div class="dialog-footer flex mx-auto">
                                                <button type="button" class="btn btn-light"
                                                        wire:click="setDeleteDept('no')"
                                                        @click="dpm{{$deleteDept}}=!dpm{{$deleteDept}}">Cancel</button>
                                                <button type="button" wire:click="DeleteDept({{$deleteDept}})"  class="btn hover:text-red-700 hover:border-red-700 bg-red-700 text-white">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $notifiys->links() }}
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
