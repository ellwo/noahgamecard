<x-dashe-layout>


    <div class="flex flex-col max-w-4xl mx-auto bg-white border rounded-lg dark:bg-dark-eval-2 ">
        <div class="p-4 text-2xl text-center text-darker dark:text-light">
            <h1>تعديل قسم  (الاقسام)</h1>
        </div>
        <hr>
        <form  dir="auto" method="POST" action="{{ route('depts.update',$dept) }}" class="flex flex-col w-3/4 mx-auto space-x-2 space-y-3 dark:bg-dark">

            @method('PUT')
            @csrf
            <x-label :value="__('اسم القسم ')" />

            <div >
            <x-input name="name" required class=" p-2
            @error('name')
            border-danger
            @enderror border text-right " placeholder="اسم القسم" value="{{ $dept->name}}"/>

            @error('name')
            <span class="text-sm text-danger">{{ $message }}</span>

            @enderror
            </div>
            <x-label :value="__('ترتيب  القسم ')" />

            <div >
            <x-input name="order_num" required class=" p-2
            @error('order_num')
            border-danger
            @enderror border text-right " type="number" placeholder="رقم ترتيب القسم" value="{{ old('order_num',$dept->order_num) }}"/>

            @error('order_num')
            <span class="text-sm text-danger">{{ $message }}</span>

            @enderror
            </div>

            <div x-data="{reqcount:0}" class="flex flex-col">

                <x-label :value="__('الحقول المطلوبة عند الشحن')" />


                @foreach ( $dept->reqs??[] as $req)

                <div class="items-center justify-between p-4 space-x-2 border rounded-md lg:flex">

                    <x-label :value="__('اسم الحقل')" />
                    <x-input name="reqname[]" required class="p-2 text-right border " placeholder="اسم الحقل" value="{{ $req['lable'] }}"/>
            <x-label for="req1" :value="__('مطلوب الحقل (ضروري؟)')" />
           <input type="checkbox"
           @if($req['isreq']!=false)
           checked
           @endif

           name="reqisreq[]" id="req1">
           <x-button :bill="true" type="button"  onclick="$(this).parent().remove()" variant="danger">
            حذف
           </x-button>

        </div>
                @endforeach


        <template x-for="i in reqcount" >

            <div class="items-center justify-between p-4 space-x-2 border rounded-md lg:flex">

                <x-label :value="__('اسم الحقل')" />
                <x-input name="reqname[]" required class="p-2 text-right border " placeholder="اسم الحقل" value=""/>
        <x-label  :value="__('مطلوب الحقل (ضروري؟)')" />
       <input type="checkbox" name="reqisreq[]" >

       <x-button type="button" @click="reqcount--" onclick="$(this).parent().html('').hide()" variant="danger">
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
            <div>
                <label class="text-xs font-semibold text-gray-500 uppercase md:text-sm text-light">{{__('ملاحظات')}}</label>
                <textarea
                    name="note"
                    class="w-full px-1 py-1 mt-1 border-2 border-blue-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" rows="3" >
          {{ $dept->note }}
                </textarea>
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
                src:"{{ $dept->img }}",
                id:'imgurl',
                h:1000,
                w:1000,
                with_w_h:true,
                shep:'rect',
            });



        </script>




    </x-slot>








</x-dashe-layout>
