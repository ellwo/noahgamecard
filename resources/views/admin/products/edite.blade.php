<x-dashe-layout>


    <div x-data="{step:1}"   class="items-center p-4 mx-auto md:max-w-5xl">

        <form action="{{ route('products.update',$product) }}" method="POST" class="bg-white rounded-lg dark:bg-darker" >

            @method('PUT')
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <x-auth-validation-errors class="mb-4" :errors="$errors" />


            @csrf
            <div dir="rtl" >


                <div class="" x-show='step==0'>

                </div>

                <div  class="space-y-4 text-center " x-show='step==1'>






                <div class="relative flex-col justify-between space-x-4 space-y-2 ">

                    <x-label for="department_id" :value="__('اختر القسم ')" />

                    <select  wire:model='dept' name="department_id" class="w-4/5 mx-2 text-gray-600 bg-white border border-gray-300 rounded-md appearance-none sm:pl-5 sm:pr-10 sm:mx-0 dark:bg-darker dark:text-white hover:border-gray-400 focus:outline-none">


                       @foreach( $depts as $ca)

                       @if($ca->id==$product->department->id)
                       <option selected value="{{$ca->id}}">{{$ca->name}}</option>

                       @else
                       <option  value="{{$ca->id}}">{{$ca->name}}</option>

                       @endif

                       @endforeach
                    </select>
                  </div>



                    {{-- @livewire('admin.dept-part-mulit-select', ['type' => 1,'selected'=>$product->parts->pluck('id')->toArray(),'dept'=>$product->department_id], key(time())) --}}
{{--

                    <input type="hidden" name="owner_id" value="{{ $product->owner_id}}"/>
                    <input type="hidden" name="owner_type" value="{{ $product->owner_type }}"/>

                @if ($product->owner_type=="App\Models\User")



                @else
                <div>
                    @include('components.mulit-select',[
                        'inputname'=>'parts',
                        'items'=>$product->owner->department->parts,
                        'id'=>'parts',
                        'lablename'=>'الفئات' ,
                        'selected'=> $product->parts->pluck('id')->toArray()
                            ])
                    </div>


                    <input type="hidden" name="department_id" value="{{ $product->depratment_id!=null?$product->depratment_id:$product->owner->department->id }}">


                @endif --}}




            </div>


                <div  class="" wire:ignore x-show="step==1">
                    <div class="grid gap-6 p-4 mb-6 lg:grid-cols-3">
                        <div>
                            <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">اسم المنتج</label>
                            <input type="text" value="{{ $product->name }}"  name="name" id="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>

                        </div>
                        <div>
                            <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">السعر</label>
                            <input type="text" value="{{ $product->price }}" name="price"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required>
                        </div>
                        <div class="flex justify-between space-x-2">

                            {{-- <div>
                            <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">الماركة العلامة التجارية  </label>

                            <select  name="brand_id" class="bg-white appearance-none rounded-xl dark:bg-darker text-darker dark:text-light" id="">
                                @foreach ($brands as $b )

                                <option  @if ($b->id==$product->brand_id)
                                    selected
                                @endif value="{{ $b->id }}">{{ $b->name }}</option>
                                @endforeach

                            </select>
                            </div> --}}
                        </div>






                    </div>
                    <div class="flex ">
                        <div class="flex flex-col p-8 text-center border rounded-md lg:w-2/3 ">
                            <div  wire:ignore>
                                <x-label :value="__('صورة العرض الاساسية')" />

                            <div id="img">
                        </div>
                            </div>


                        </div>



                    </div>

                    <div class="px-2 space-y-2">


 <x-label :value="__('وصف مختصر للمنتج')" />
 <textarea cols="30" rows="10"
 name="note" id="note" maxlength="191"
  class="w-full px-2 py-1 mr-2 text-black text-opacity-50 rounded shadow appearance-none ckeditor dark:bg-primary-darker dark:text-light focus:outline-none focus:shadow-outline focus:border-primary" >
 @php
  echo $product->discrip;
 @endphp
  </textarea></div>


                            <div class="m-5 mx-auto text-center">
                                <x-button variant="success" class="mx-auto" >
                                    حفظ
                                     <x-heroicon-o-plus class="w-4"/>
                                 </x-button>


                            </div>





        <x-slot name="script">
{{--
            <script src="{{ asset('js/jquery.min.js') }}"></script>
            <script src="{{ asset('js/uploadeimage.js') }}"></script> --}}
            <script type="text/javascript">
                 newimage=new ImagetoServer(
                    {
                        url:"{{route('uploade')}}",
                        id:"img",

                    shep:'rect',
                   // mx_h:850,
                   // mx_w:850,
                   with_w_h:true,
                        w:850,h:850,
                    //     withmask:true,
                    // maskUrl:'{{ config("mysetting.logo") }}',

                         src:"{{ $product->img }}"
            });



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







</x-dashe-layout>
