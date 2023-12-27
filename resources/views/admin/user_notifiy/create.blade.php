<x-dashe-layout>


    <div class="max-w-4xl flex flex-col mx-auto  bg-white border rounded-lg dark:bg-dark ">
        <div class="text-center  p-8 bg-info shadow-sm rounded-md text-3xl text-darker dark:text-light">
            <h1>انشاء اشعار جديد </h1>
        </div>
        <hr>
        <form x-data="{p_price:''}"  dir="auto" method="POST" action="{{ route('usernotification.store') }}" class="mx-auto flex flex-col w-3/4  space-x-2 space-y-3  dark:bg-dark">
            @csrf
            <x-label :value="__('اختيار  مستخدم  ')" />
            <x-label :value="__('ادخل اسم المستخدم او رقم هاتفه او بريد الكتروني   ')" />
            <div>
                @livewire('search-user-select',[
                    'product_id'=>old('user_id')
                ])
                @error('user_id')
                <span class="text-danger font-bold"> {{ $message }}</span>
                @enderror
            </div>
             <div x-show="p_price!=0" class="flex px-4" >
              <span>العميل</span>
              <span class="font-bold text-red-600" x-text="p_price"></span>
            </div>
            <hr>

         <label for="to_all">ارسال لجميع
            <input type="checkbox" name="to_all"  id="to_all">
            </label>
            <hr>

            <x-label :value="__('عنوان الرسالة' )"/>
           <input  required type="text"
            name="title"
            value="{{ old('title') }}"
             class="rounded-md p-2 text-dark dark:bg-darker dark:text-light
           @error('code')
           border-danger
          @enderror  focus:border-info ">
          @error('title')
          <span class="text-danger font-bold"> {{ $message }}</span>
         @enderror

            <div>
                <x-label :value="__('محتوى الاشعار (الرسالة) ')" />
                <textarea
                    name="body"
                    class="w-full px-1 py-1 mt-1 dark:bg-darker border-2 border-blue-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" rows="3" >
          </textarea>
            </div>

            <hr>
            <x-label :value="__(' الصورة ')"/>
            <div id="img">
            </div>
            @error('img')
            <span class="text-sm text-danger">{{ $message }}</span>
            @enderror

            <div class="text-center">
            <x-button variant="info" type="submit" >
                ارسال الاشعار
            </x-button>
            </div>

        </form>

    </div>



    <x-slot name="script">
        <script>

            var img=new ImagetoServer({
                url:"{{ route('uploade') }}",
                src:"{{ old('img') }}",
                id:'img',
                h:1000,
                w:1000,
                with_w_h:true,
                shep:'rect',
            });
        </script>
    </x-slot>
</x-dashe-layout>
