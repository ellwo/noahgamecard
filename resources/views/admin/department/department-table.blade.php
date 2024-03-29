
<div class="overflow-x-auto"
 {{-- x-data="{showform:{{$showform}}}" --}}
 >






    <div class=" overflow-x-auto bg-transparent w-full flex items-center justify-center  font-sans ">
        <div class="w-full lg:w-5/6">
            <div class="rounded-t bg-white dark:bg-dark-eval-2 mb-0 px-4 py-3 border-0">

                <div class="flex flex-wrap items-center">



                    <x-button variant="success" class="mx-auto" href="{{ route('depts.create') }}">
                        اضافة قسم جديد
                        <x-heroicon-s-plus class="h-8 w-8"/>
                    </x-button>



                </div>
                <div class="flex flex-wrap items-center">
                    <div class="relative w-full sm:px-4 max-w-full flex-grow sm:flex-1">
                        <h3 class="font-semibold relative mb-4 flex text-base text-blueGray-700">
                            {{__('الاقسام')}}
                            <x-bi-grid class="w-10 h-10 text-yellow-400 flex"/>

                        </h3>

                        <x-input-with-icon-wrapper>
                            <x-slot name="icon" role="button">
                                <x-bi-search aria-hidden="true" class="w-5 h-5" />
                            </x-slot>
                            <x-input dir="auto" wire:model="search" name="search" withicon id="search"
                                class="block rounded-full w-full" type="text" :value="old('name')" required autofocus
                                placeholder="{{ __('ابحث') }}" />
                        </x-input-with-icon-wrapper>

                    </div>





                    <div class="flex mt-4 dark:text-white flex-col ">


                        {{$departments->links()}}
                    </div>




                    <div class="bg-white overflow-x-auto relative dark:bg-dark-eval-2 dark:text-white w-full shadow-md rounded my-6">

                        <div class="w-full top-0 bottom-0 z-30 bg-white bg-opacity-50 absolute" wire:loading
                           >
                            <div class="w-full h-4 bg-blue-900 mt-16 rounded animate-pulse top-10 bottom-0 my-auto"></div>
                        </div>


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
                        <table class="min-w-max w-full table-auto overflow-x-auto">
                            <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm ">

                                <th class="py-3 px-2  text-left">القسم

                                    </th>
                                    <th class="py-3 px-2  text-left">رقم ترتيب القسم</th>
                                    <th class="py-3 px-2  text-left"> عدد المنتجات</th>
                                    <th class="py-3 px-2  text-left"> الحالة</th>

                                <th class="py-3  text-center">Actions</th>
                            </tr>
                            </thead>


                            <tbody   class="text-gray-600 dark:text-white text-sm font-light">


                            @foreach($departments as $d)
                            <tr  class="border-b relative border-gray-200 hover:bg-gray-100 dark:hover:bg-dark-bg dark:hover:text-white">
                                <td   class="py-3 px-2 mb-4 text-left" >
                                    <div class="flex items-center">
                                        <div class="mr-2">
                                            <img class="w-10 h-10 rounded-full" src="{{$d->img}}"/>
                                        </div>
                                        <span class="font-bold">{{$d->name}}
                                            </span>
                                    </div>
                                    <div>
                                        <span class=" mb-6 mt-4 text-green-600 font-bold py-1 px-1  text-xs">
                                    {{date('d/M/Y', strtotime($d->updated_at))}}
                                            </span></div></td>

                                            <td>
                                                {{$d->order_num}}
                                            </td>


                                <td>
                                    {{$d->products_count}}
                                </td>

                                <td x-data='{isActive:{{$d->active??0}}}'>

                                    <div class="flex flex-col">

                                        <button aria-hidden="true" class="relative focus:outline-none" x-cloak wire:click="deletePro({{$d->id}})" @click="isActive=!isActive;">
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

                                        <div x-show="!isActive" class="">
                                            غير نشط
                                          </div>
                                          <div x-show="isActive" class="">
                                               نشط
                                            </div>
                                    </div>
                                </td>


                                <td class="py-3   text-right">
                                    <div class="flex item-center justify-center">
                                        <div class="w-4  mr-2 mt-2 cursor-pointer transform hover:text-purple-500 hover:scale-110">
                                       


                                        </div>
                                        <a href="{{ route('depts.edit',['dept'=>$d]) }}"  class="w-4 mr-2 mt-2 cursor-pointer transform hover:text-purple-500 hover:scale-110">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </a>
                                    </div>

                    @if($deleteDept!="no" && $d->id==$deleteDept)

                    <div x-data="{dpm{{$deleteDept}}: 1}">
                        <div  x-show="dpm{{$deleteDept}}" class="dialog">
                            <div class="dialog-content">
                                <div class="dialog-header dark:text-black">هل انت متاكد من الحذف
                                </div>
                                <div class="dialog-body lg:flex" dir="auto">
                                    <h1 class="text-xl text-red-800 font-bold p-4 rounded-lg ">
                                        سيتم الغاء تنشيط القسم ولن يظهر لدى المستخدمين 
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
                                </td>

                            </tr>
                            @endforeach

                            </tbody>
                        </table>




                    </div>



                    </div>
            </div>
        </div>
    </div>

    @if( session()->get('statt')=='ok')

        <div class="fixed p-4   bg-green-500 text-white top-10 w-32 mx-auto right-5 toast" role="alert" x-on:toast1.window="open = !open" x-data="{ open: true }" x-show.transition="open" x-cloak>
            <div class="flex items-center justify-between mb-1">
            <span class="font-bold text-blue-600">
        {{__(session()->get('title'))}}</span>
                <button class="btn btn-dark btn-xs" @click="open = false"><svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
            </div>
            {{__(session()->get('message'))}}
        </div>
    @endif

    <x-slot name="script">
    <script>

        var img=new ImagetoServer({
            url:"{{ route('uploade') }}",
            src:"{{ old('img') }}",
            id:'imgurl',
            h:250,
            w:250,
            with_w_h:true,
            shep:'rect',
        });



    </script>
    </x-slot>




</div>
