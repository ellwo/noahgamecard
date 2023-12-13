
<div class="overflow-x-auto"
 {{-- x-data="{showform:{{$showform}}}" --}}
 >






    <div class=" overflow-x-auto bg-transparent w-full flex items-center justify-center  font-sans ">
        <div class="w-full lg:w-5/6">
            <div class="rounded-t bg-white dark:bg-dark-eval-2 mb-0 px-4 py-3 border-0">

                <div class="flex flex-wrap items-center">

                </div>
                <div class="flex flex-wrap items-center">
                    <div class="relative w-full sm:px-4 max-w-full flex-grow sm:flex-1">
                        <h3 class="font-semibold relative mb-4 flex text-base text-blueGray-700">
                            {{__('اجمالي المبيعات بحسب الاقسام ')}}
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


                        {{-- {{$departments->links()}} --}}
                    </div>




                    <div class="bg-white overflow-x-auto relative dark:bg-dark-eval-2 dark:text-white w-full shadow-md rounded my-6">

                        <div class="w-full top-0 bottom-0 z-30 bg-white bg-opacity-50 absolute" wire:loading
                           >
                            <div class="w-full h-4 bg-blue-900 mt-16 rounded animate-pulse top-10 bottom-0 my-auto"></div>
                        </div>

                        <div class=" hidden text-center justify-center items-center" dir="rtl">

                        <h4 class="text-right flex justify-items-center space-x-2" dir="rtl">من تأريخ
                            <input type="datetime-local"  wire:model.lazy='fromDate' class="bg-white  bg-white rounded-md text-dark  dark:text-white dark:bg-dark rounded-md border p-2"/>

                            </h4>

                        <h4 class="text-right flex justify-center space-x-2" dir="rtl">الى تأريخ

                            <input type="datetime-local"  wire:model.lazy='toDate' class="bg-white  bg-white rounded-md text-dark dark:text-white dark:bg-dark p-2 border"/>
                           </h4>
                        </div>
                        <table dir="rtl" class="min-w-max w-full table-auto overflow-x-auto">
                            <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm ">

                                <th class="py-3 px-2  text-right">القسم

                                    </th>
                                    <th class="py-3 px-2  text-right">اجمالي المبيعات</th>
                                    <th class="py-3 px-2  text-right"> عدد الطلبات</th>
                            </tr>
                            </thead>


                            <tbody   class="text-gray-600 dark:text-white text-sm font-light">


                            @foreach($departments as $d)
                            <tr  class="border-b relative border-gray-200 hover:bg-gray-100 dark:hover:bg-dark-bg dark:hover:text-white">
                                <td   class="py-3 px-2 mb-4 text-left" >
                                    <div class="flex items-center">
                                        <div class="mr-2">
                                            {{-- <img class="w-10 h-10 rounded-full" src="{{$d->img}}"/> --}}
                                        </div>
                                        <span class="font-bold">{{$d['name']}}
                                            </span>
                                    </div>
                                    </td>

                                            <td>
                                                {{$d['total_price']}}
                                            </td>


                                <td>
                                    {{$d['count']}}
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
    </x-slot>




</div>
