

    <div class="max-w-4xl flex flex-col mx-auto  bg-white border rounded-lg dark:bg-dark ">
        <div class="text-center p-4 bg-info shadow-sm rounded-md text-white">
            <h1>اسعار العملات مقابل الدولار </h1>
        </div>
        <hr>
        <form  dir="auto" method="POST" action="{{ route('coins.store') }}" class="mx-auto
        flex flex-col w-3/4 rounded-md border  space-x-2 space-y-3  dark:bg-dark">

            @csrf
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <x-auth-validation-errors class="mb-4" :errors="$errors" />


            <div class="flex flex-wrap justify-evenly space-y-2">


                <style>
                    img{
                        width: 20%;
                    }
                </style>

                <div class="flex w-full max-w-full p-1  mx-auto">

                    الايقونة
                    <input class="rounded-md mr-4 p-2 text-dark dark:bg-darker dark:text-light" type="text" value="الاسم" disabled/>
                        <input class="rounded-md p-2 text-dark dark:bg-darker dark:text-light" type="text" value="الاسم المختصر" disabled/>
                        <input class="rounded-md p-2 text-dark dark:bg-darker dark:text-light" type="text" value="السعر" disabled/>

                </div>
            @foreach ($coins as $coin)
            <input type="hidden" name="coin_id{{ $coin->id }}" value="{{ $coin->id }}">
               <div x-data='{"icon{{ $coin->id }}":0}' class="flex flex-col">
                <div class="flex ">
                    <img @click='icon{{ $coin->id }}=!icon{{ $coin->id }}' class="h-8 w-8 ml-2 rounded-full" src="{{ $coin->icon }}" alt="الصورة">
                    <input type="text" class="rounded-md p-2 text-dark dark:bg-darker dark:text-light" name="{{ "coin_name$coin->id" }}" value="{{ old("coin_name$coin->id",$coin->name) }}" id="">
                    <input type="text" class="rounded-md p-2 text-dark dark:bg-darker dark:text-light" name="{{ "coin_nickname$coin->id" }}" value="{{ old("coin_nickname$coin->id",$coin->nickname) }}" id="">
                    <input  type="text" name="coin_value{{ $coin->id }}"
                    value="{{old("coin_value$coin->id", $coin->value )}}"
                     class="rounded-md p-2 text-dark dark:bg-darker dark:text-light
                    @error("coin_value$coin->id")
                    border-danger
                   @enderror  focus:border-info ">
                </div>
                @error("coin_value$coin->id")
                <span class="text-danger ">{{ $message }}</span>
                @enderror
                <div x-show="icon{{ $coin->id }}">                <div id='{{ "coin_img$coin->id" }}'></div>
            </div>

                <script>

document.addEventListener('DOMContentLoaded',()=> {

            var img=new ImagetoServer({
                url:"{{ route('uploade') }}",
                src:"{{ old('coin_img'.$coin->id,$coin->icon) }}",
                id:'coin_img{{ $coin->id }}',
                mx_h:400,
                mx_w:400,
                w:400,
                h:400,
                shep:'',
            });
        });
                </script>
               </div>

            @endforeach


        </div>
                 <hr>
            <div class="text-center">
            <x-button variant="info" type="submit" >
                حفظ
            </x-button>
            </div>

        </form>

    </div>


    <x-slot name="script">
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/uploadeimage.js') }}"></script>
    </x-slot>

