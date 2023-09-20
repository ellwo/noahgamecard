<x-dashe-layout>


    <div class="max-w-4xl flex flex-col mx-auto  bg-white border rounded-lg dark:bg-dark ">
        <div class="text-center  p-8 bg-info shadow-sm rounded-md text-3xl text-darker dark:text-light">
            <h1>تغذية حساب عميل </h1>
        </div>
        <hr>
        <form x-data="{p_price:''}"  dir="auto" method="POST" action="{{ route('rasseds.store') }}" class="mx-auto flex flex-col w-3/4  space-x-2 space-y-3  dark:bg-dark">

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
            <x-label :value="__('المبلغ ' )"/>
            <input  type="text"
             name="amount"
             value="{{ old('amount') }}"
             required
             class="rounded-md p-2 text-dark dark:bg-darker dark:text-light
            @error('amount')
            border-danger
           @enderror  focus:border-info ">
           @error('amount')
           <span class="text-danger font-bold"> {{ $message }}</span>
          @enderror


           <x-label :value="__('رقم الحوالة\كود الايداع' )"/>
           <input  required type="text"
            name="code"
            value="{{ old('code') }}"
             class="rounded-md p-2 text-dark dark:bg-darker dark:text-light
           @error('code')
           border-danger
          @enderror  focus:border-info ">
          @error('code')
          <span class="text-danger font-bold"> {{ $message }}</span>
         @enderror



            <div class="text-center">
            <x-button variant="info" type="submit" >
                تغذية الحساب
            </x-button>
            </div>

        </form>

    </div>




</x-dashe-layout>
