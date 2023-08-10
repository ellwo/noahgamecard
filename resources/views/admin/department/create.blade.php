<x-dashe-layout>


    <div class="flex flex-col max-w-4xl mx-auto bg-white border rounded-lg dark:bg-dark-eval-2 ">
        <div class="p-4 text-2xl text-center text-darker dark:text-light">
            <h1>اضافة قسم  (الاقسام)</h1>
        </div>
        <hr>
        <form  dir="auto" method="POST" action="{{ route('depts.store') }}" class="flex flex-col  mx-auto space-x-2 space-y-3 dark:bg-dark">

            @csrf
            <x-label :value="__('اسم القسم ')" />

            <div >
            <x-input name="name" required class=" p-2
            @error('name')
            border-danger
            @enderror border text-right " placeholder="اسم القسم" value="{{ old('name') }}"/>

            @error('name')
            <span class="text-sm text-danger">{{ $message }}</span>

            @enderror
            </div>
            <div>
                <x-label :value="__('ملاحظات ')" />
                <textarea
                    name="note"
                    class="py-1 px-1 w-full rounded-lg border-2 border-blue-300 mt-1 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" rows="3" >
          </textarea>
            </div>

            <div x-data="{reqcount:0}" class="flex flex-col">

                <x-label :value="__('الحقول المطلوبة عند الشحن')" />

            <div class="lg:flex  p-4 justify-between items-center border rounded-md space-x-2">

                    <x-label :value="__('اسم الحقل')" />
                    <x-input name="reqname[]" required class=" p-2
            border text-right " placeholder="اسم الحقل" value="ID الحساب "/>
            <x-label for="req1" :value="__('مطلوب الحقل (ضروري؟)')" />
           <input type="checkbox" name="reqisreq[]" id="req1">

        </div>

        <template x-for="i in reqcount" >

            <div class="lg:flex  p-4 justify-between items-center border rounded-md space-x-2">

                <x-label :value="__('اسم الحقل')" />
                <x-input name="reqname[]" required class=" p-2
        border text-right " placeholder="اسم الحقل" value=""/>
        <x-label  :value="__('مطلوب الحقل (ضروري؟)')" />
       <input type="checkbox" name="reqisreq[]" >

       <x-button type="button" @click="reqcount--" onclick="$(this).parent().remove()" variant="danger">
        حذف
       </x-button>
    </div>

        </template>
        <div class="text-center">
            <x-button variant="info" @click="reqcount++" class="mx-auto" type="button">
        اضافة حقل جديد
                <x-heroicon-o-plus class="w-4"/>
            </x-button>
            </div>





            </div>

            <hr>
            <x-label :value="__(' الصورة ')"/>
            <div id="imgurl">

            </div>

            @error('imgurl')
            <span class="text-sm text-danger">{{ $message }}</span>

            @enderror
            <div class="text-center">
            <x-button variant="success" type="submit" >
                حفظ
            </x-button>
            </div>

        </form>

    </div>

    <x-slot name="script">
        <script>

            var img=new ImagetoServer({
                url:"{{ route('uploade') }}",
                src:"{{ old('img') }}",
                id:'imgurl',
                h:1000,
                w:1000,
                with_w_h:true,
                shep:'rect',
            });



        </script>




    </x-slot>








</x-dashe-layout>
