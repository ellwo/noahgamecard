<section>
    <div x-data="{step:1}"   class="items-center p-4 mx-auto max-w-5xl">

        <form action="{{ route('provider_products.store') }}" method="POST" class="bg-white rounded-lg dark:bg-darker" >

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <x-auth-validation-errors class="mb-4" :errors="$errors" />


            @csrf
            <div dir="rtl" >

        <div class="p-6 mb-4 overflow-hidden flex justify-between text-2xl bg-blue-300 rounded-md shadow-md dark:bg-dark-eval-1">
            اضافة منتج جديد
            <x-button href="{{route('provider_products')}}">
                عودة الى القائمة
            </x-button>
        </div>


                <div class="" x-show='step==0'>
                </div>

                <div  class="space-y-4 text-center " x-show='step==1'>
                    {{-- @livewire('admin.dept-part-mulit-select', ['type'=>1, 'selected'=>old('department_id')??[]  , 'dept'=> old('department_id','any')], key(time())) --}}






                    <div class="relative flex    items-center justify-between space-x-4 space-y-2 ">

                        <x-label class="w-1/3" for="department_id" :value="__('اختر المزود   ')" />

                        <select  wire:model='provider_id' name="provider_id" class="w-4/5 mx-2 text-gray-600 bg-white border border-gray-300 rounded-md appearance-none sm:pl-5 sm:pr-10 sm:mx-0 dark:bg-darker dark:text-white hover:border-gray-400 focus:outline-none">

                           @foreach( $providers as $p)
                           <option  value="{{$p->id}}">{{$p->name."  ".$p->phone }}</option>
                           @endforeach
                        </select>
                    </div>





                    <div class="relative flex    items-center justify-between space-x-4 space-y-2 ">

                        <x-label class="w-1/3" for="department_id" :value="__('اختر المنتج الاساسي  ')" />

                        <select  wire:model='product_id' name="product_id" class="w-4/5 mx-2 text-gray-600 bg-white border border-gray-300 rounded-md appearance-none sm:pl-5 sm:pr-10 sm:mx-0 dark:bg-darker dark:text-white hover:border-gray-400 focus:outline-none">

                           @foreach( $products as $p)
                           <option  value="{{$p->id}}">{{$p->name }}</option>
                           @endforeach
                        </select>

                        <select disabled wire:model='product_id' name="product_id" class="w-4/5 mx-2 text-gray-600 bg-white border border-gray-300 rounded-md appearance-none sm:pl-5 sm:pr-10 sm:mx-0 dark:bg-darker dark:text-white hover:border-gray-400 focus:outline-none">

                            @foreach( $products as $p)
                            <option  value="{{$p->id}}">{{ "   السعر:  ".$p->price."  $"}}</option>
                            @endforeach
                         </select>
                      </div>



                      <div class="relative flex w-1/2 items-center justify-between space-x-4 space-y-2 ">


                        <label for="last_name" class="block mx-4 mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">الحالة</label>

                    <label>
                      نشط
                    <input  type="radio" name="active" id="status"     value="1" />
                </label>
                <br>
                <label>
                    غير نشط
                    <input type="radio" name="active" id="status"  checked  value="0" />
                </label>
                    </div>

                    <div class="relative flex w-1/2 items-center justify-between space-x-4 space-y-2 ">


                        <label for="direct" class="block mx-4 mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">نوع التنفيذ</label>

                    <label>
                      مباشر
                    <input  type="radio" name="direct" id="direct"     value="1" />
                </label>
                <br>
                <label>
                    غير مباشر
                    <input type="radio" name="direct" id="direct"  checked  value="0" />
                </label>
                    </div>
                    </div>

            <div>

            </div>


                <div  class=""  x-show="step==1">
                    <div class="grid gap-6 p-4 mb-6 lg:grid-cols-2">
                        <div>
                            <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">اسم المنتج بحسب المزود</label>
                            <input type="text"  value="{{ old('name') }}" name="name" id="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>

                        </div>
                        <div>
                            <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">السعر بحسب المزود</label>
                            <input type="text" name="price" value="{{ old('price') }}"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required>
                        </div>


                    </div>
                    <div class="flex justify-between space-x-2">

                        <div x-data="{reqcount:1}"
                            class="flex flex-col w-full mx-4  space-y-2">

                            <x-label :value="__('الحقول المطلوبة من المزود')" />
                    <template x-for="i in reqcount" >


                        <div class="flex ">

                            <div class="lg:flex  p-4 justify-between items-center border rounded-md space-x-2">

                                <x-label :value="__('اسم الحقل')" />
                                <x-input name="reqname[]" required class=" p-2
                        border text-right " placeholder="اسم الحقل" value=""/>
                        <x-label  :value="__('  القيمة المسندة')" />

                     <div class="flex flex-col space-y-2">
                        <select name="reqvalue[]" id="" class="mx-2 text-gray-600 bg-white border border-gray-300 rounded-md appearance-none sm:pl-5 sm:pr-10 sm:mx-0 dark:bg-darker dark:text-white hover:border-gray-400 focus:outline-none">
                           <option value="">قيمة ثابته</option>
                            @foreach ($product->department->reqs??[] as $item)
                                <option value="{{$item['lable']}}">{{$item['lable']}}</option>
                            @endforeach
                           </select>
                           <x-input name="reqdef_val[]"  class=" p-2
                           border text-right " placeholder="قيمة ثابته" value=""/>
                         </div>
                            </div>

                            <div class="text-center flex items-start mt-2 m-2">

                   <x-button class="inline-block" type="button"  :pill="true"
                   @click='reqcount--;'
                   onclick="$(this).parent().parent().html('')" variant="danger">
                    <x-heroicon-s-x class="text-white h-4 w-4 "/>
                   </x-button>
                            </div>
                </div>


                    </template>
                    <div class="text-center">
                        <x-button variant="info" @click='reqcount++;'  class="mx-auto" type="button">
                    اضافة حقل جديد
                            <x-heroicon-o-plus class="w-4"/>
                        </x-button>
                        </div>

                        </div>

                                </div>



                    <div class="lg:flex ">

                    </div>


                    <div class="md:flex">

                    <div class="px-2 space-y-2 md:w-1/2">
                        <x-label :value="__('وصف مختصر للمنتج')" />
                        <textarea cols="30" rows="10"
                        name="note" id="note" maxlength="191"
                         class="w-full px-2 py-1 mr-2 text-black text-opacity-50 rounded shadow appearance-none ckeditor dark:bg-primary-darker dark:text-light focus:outline-none focus:shadow-outline focus:border-primary" >
                        @php
                         echo old('note');
                        @endphp
                         </textarea>
                    </div>






                </div>

                            <div class="m-5 mx-auto text-center">
                                <x-button variant="success"  class="mx-auto" >
                                    حفظ
                                     <x-heroicon-o-plus class="w-4"/>
                                 </x-button>


                            </div>





        <x-slot name="script">
            <script type="text/javascript">

            ClassicEditor
        .create( document.querySelector( '#note' ), {
            language: {
                // The UI will be English.
                ui: 'ar',

                // But the content will be edited in Arabic.
                content: 'ar'
            }  ,
             removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed'],

        } )
        .then( editor => {
            window.editor = editor;
        } )
        .catch( err => {
            console.error( err.stack );
        } );


            </script>

        </x-slot>
                </div>

    {{--
                <div  class="flex justify-between w-1/2 mx-auto mt-4 ">

                    <x-button x-show="step<2" type="button" class="block" variant="success" @click="step=step+1; $wire.set('step',{{ $step+1 }})" >التالي </x-button>

                    @if($step > 0 )

                    <x-button  type="button" @click="step=step-1; $wire.set('step',{{ $step-1 }})" variant="info" >السابق </x-button>

                    @endif

                </div> --}}
            </div>




        </form>


    </div>
</section>
