

<x-guest-layout>

    @if (session()->get('statt') == 'ok')
        <div class="fixed p-4   bg-green-500 text-white top-10 w-32 mx-auto right-5 toast" role="alert"
            x-on:toast1.window="open = !open" x-data="{ open: true }" x-show.transition="open" x-cloak>
            <div class="flex items-center justify-between mb-1">
                <span class="font-bold text-blue-600">
                    {{ __(session()->get('title')) }}</span>
                <button class="btn btn-dark btn-xs" @click="open = false"><svg class="w-4 h-4"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg></button>
            </div>
            {{ __(session()->get('message')) }}
        </div>
    @endif
<div class="flex py-4 flex-col items-center justify-center max-w-4xl mx-auto dark:bg-darker">
    <div class="w-full mx-auto " >
      <div class="h-auto p-6 text-right border bg-white shadow-md   border-gray-300 rounded-md" style="width: 100%;  "  >
        <form method="POST" class="w-full h-auto " action="{{ route('post.create_contact')}}" >
        @csrf

        <div dir="rtl" class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-darker">
            مرحبا  عزيزنا العميل  يمكنك الاستفسار او تقديم رسالة شكوى
        </div>

          <label class="block mb-6">
            <span class="text-black" style="font-family:none;">اسمك</span>
            <input
              type="text"
              name="name"
              class="block w-full  mt-1 lg:text-sm text-xs md:text-sm text-black border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
              placeholder=""
              dir="rtl"
              required
            />
          </label>
          <label class="block mb-6">
            <span class="text-black" style="font-family:none;">رقم الهاتف</span>
            <input
              type="tel"
              name="phone"
              class="block w-full  mt-1 lg:text-sm text-xs md:text-sm text-black border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
              placeholder=""
              dir="rtl"
              required
            />
          </label>
          <label class="block mb-6">
            <span class="text-black" style="font-family:none;">بريدك الالكتروني </span>
            <input
              name="email"
              type="email"
              class="block w-full mt-1 lg:text-sm text-xs md:text-sm border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
              placeholder="exampl@example.com"
              required
            />
          </label>

          <label class="block mb-6">
            <span class="text-black" style="font-family:none;">عنوان (الموضوع*) </span>
            <input
              name="subject"
              type="text"
              class="block w-full mt-1 lg:text-sm text-xs md:text-sm border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
              placeholder=""
              required
            />
          </label>
          <label class="block mb-6">
            <span class="text-black" style="font-family:none;">نص الرسالة</span>
            <textarea
              name="message"
              class="block w-full mt-1 lg:text-sm text-xs md:text-sm text-black border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
              rows="3"
              dir="rtl"
              placeholder="اخبرنا ماذا تريد ان تعرف او تستفسر..."
            ></textarea>
          </label>

          <div class="max-w-lg mx-auto">

            <fieldset dir="rtl" class="mb-5">

                <p class="xl:text-lg text-sm">النوع</p>
                <div class="flex items-center mb-4 ">
                    <input id="country-option-1" type="radio" name="kind" value="1" {{old('kind')=='1' ? 'checked ' : ''}} checked class="w-4 h-4 text-right border-gray-300 focus:ring-2 focus:ring-blue-300" aria-labelledby="country-option-4" aria-describedby="country-option-4">
                    <label for="country-option-1" class="block ml-2 xl:text-lg  text-right text-gray-900 border-r-4">
                   استفسار
                    </label>
                </div>
                <div class="flex items-center mb-4">
                    <input id="country-option-4" type="radio" name="kind" value="2" {{old('kind')=='2' ? 'checked ' : ''}} class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300" aria-labelledby="country-option-4" aria-describedby="country-option-4">
                    <label for="country-option-4" class="block ml-2 xl:text-lg  text-gray-900">
                        شكوئ
                    </label>
                </div>


            </fieldset>

        </div>




          <div class="mb-6 text-center flex-col flex space-y-2">
            <span class=" text-sm text-gray-500"> سيتم الرد عليك في غضون 24 ساعة </span>

            <button
              type="submit"
              class="h-12 px-5 text-center text-indigo-100 transition-colors duration-150 bg-indigo-700 rounded-lg max-h-20 focus:shadow-outline hover:bg-indigo-800" >
              ارسال
            </button>

        </div>

        </form>
      </div>
    </div>

    </div>
</x-guest-layout>
