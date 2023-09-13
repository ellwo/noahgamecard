<section x-data='{open_delete:false}'>
    <div class="relative ">



        <div x-show="open_delete" class="absolute flex flex-col p-8 space-y-4 bg-white rounded-md top-24 right-1/2">
            <span class="w-full text-danger">تنويه</span>
            <hr>
            هل انت متاكد من الحذف ؟
            <div class="flex justify-between space-x-2">
      <x-button variant='success' wire:click='delete_ad({{ $deleted_ad }})' @click='open_delete=false' >تأكيد</x-button>
      <x-button variant='danger' @click="open_delete=false" > الغاء</x-button>
            </div>
        </div>




        <x-auth-session-status class="mb-4" :status="session('status')" />

        <x-auth-validation-errors class="mb-4" :errors="$errors" />





    <div class="flex flex-col items-center justify-center pt-4 dark:bg-darker">
        <div class="flex flex-col w-full col-span-12 mx-auto">



            <div class="items-center justify-between mb-4 space-x-2 space-y-2 md:flex md:mx-auto lg:w-2/3">
                <div class="w-full pr-4">
                    <div class="relative md:w-full">
                        <input wire:model='search' type="search"
                            class="w-full py-2 pl-10 pr-4 font-medium text-gray-600 rounded-lg shadow  focus:outline-none focus:shadow-outline"
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
                    {{-- <div class="flex transition-shadow shadow">
                        <div class="relative flex flex-col items-center space-y-2 ">
                            <x-label value="عرض المنتجات حسب "  />
                        <select wire:model.lazy='username' wire:change='UsernameUpdated' class="bg-white text-dark dark:text-white dark:bg-dark rounded-2xl ">
                            <option value="all">جميع الحسابات </option>
                            <option value="useronly">الحساب الشخصي </option>

                            @foreach ($bussinses as $buss)
                            <option wire:click="choseBuss('{{ $buss->username }}')" value="{{ $buss->username }}">{{ $buss->name }}
                            <span class="p-1 text-xs rounded-full text-info">{{ "@".$buss->username }} </span></option>
                            @endforeach

                        </select>

                        </div>
                    </div> --}}
                </div>
                <div>
                    <div  class="flex transition-shadow rounded-lg shadow">
                        <div class="flex flex-col items-center w-full space-y-2 ">
                           <x-button href="{{ route('discount.create') }}" class='block w-32' variant="success">
                            اضافة جديد
                            <x-heroicon-o-plus class="w-4 h-4"/>
                           </x-button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col w-full mx-auto overflow-x-scroll md:overflow-x-hidden ">

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
                <table class="table px-4 space-y-6 text-xs border-separate md:min-w-full sm:text-sm text-dark dark:text-light">
                    <thead class=" dark:text-light bg-light dark:bg-dark">
                        <tr>
                            <th class="p-3">الامتياز</th>
                            <th class="p-3 text-left">نسبة العمولة</th>
                            <th class="p-3 text-left">تاريخ الاضافة</th>
                             <th class="p-3 text-left">عمليات</th>
                        </tr>
                    </thead>
                    <tbody class="">

                        @foreach ($discounts as $ad)

                        <tr class="bg-white dark:bg-dark">
                            <td class="p-3">
                                <div class="flex align-items-center">

                                    <div dir="auto" class="ml-3">
                                    {{ $ad->role->name }}
                                    </div>
                                </div>
                            </td>
                            <td class="p-3">
                                <s class="font-sans"> {{ $ad->dis_persint."%" }}</s>

                            </td>

                            <td class="p-3">
                                {{$ad->created_at}}
                            </td>
                            <td class="p-3 ">

                                <a
                                href="{{ route('discount.edit',['discount'=>$ad]) }}" class="mx-2 text-gray-400 hover:text-yellow-700">
                                    <i class="text-lg text-primary material-icons-outlined">edit</i>
                                </a>
                                <a  @click="open_delete=true; $wire.set('deleted_ad',{{ $ad->id }})"
                                    href="#" class="ml-2 text-danger-light hover:text-danger">
                                    <i class="text-base material-icons-round">delete_outline</i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $discounts->links() }}
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

        tr td:nth-child(n+4),
        tr th:nth-child(n+4) {
            border-radius: 0 .625rem .625rem 0;
        }

        tr td:nth-child(1),
        tr th:nth-child(1) {
            border-radius: .625rem 0 0 .625rem;
        }
    </style>

    <x-slot name="script">


    </x-slot>



    </div>
    </section>
