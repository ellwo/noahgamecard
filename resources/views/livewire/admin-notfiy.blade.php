<div dir="ltr">


    <div class="hidden">

<audio id="sound">
    <source src="{{asset('notifiy.wav')}}" type="audio/wav">
  Your browser does not support the audio element.
  </audio>
    </div>



    <div wire:ignore x-transition:enter="transition duration-300 ease-in-out" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition duration-300 ease-in-out"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        x-show="isNotificationsPanelOpen" @click="isNotificationsPanelOpen = false"
        class="fixed inset-0 z-10 bg-primary-darker" style="opacity: 0.5" aria-hidden="true"></div>
    <!-- Panel -->
    <section wire:ignore.self x-transition:enter="transition duration-300 ease-in-out transform sm:duration-500"
        x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transition duration-300 ease-in-out transform sm:duration-500"
        x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
        x-ref="notificationsPanel" x-show="isNotificationsPanelOpen"
        @keydown.escape="isNotificationsPanelOpen = false" tabindex="-1"
        aria-labelledby="notificationPanelLabel"
        class="fixed inset-y-0 right-0 z-20 w-full max-w-xs bg-white dark:bg-darker dark:text-light sm:max-w-md focus:outline-none">
        <div class="fixed right-0 p-2 transform translate-x-full">
            <!-- Close button -->
            <button @click="isNotificationsPanelOpen = false"
                class="p-2 text-white rounded-md focus:outline-none focus:ring">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="flex flex-col h-screen" x-data="{ activeTabe: 'action' }">
            <!-- Panel header -->
            <div class="flex-shrink-0">
                <div class="flex items-center justify-between px-4 pt-4 border-b dark:border-primary-darker">
                    <h2 id="notificationPanelLabel" class="pb-4 font-semibold">الاشعارات</h2>
                    <div class="space-x-2">
                        <button @click.prevent="activeTabe = 'action'"
                            class="px-px pb-4 transition-all duration-200 transform translate-y-px border-b focus:outline-none"
                            :class="{'border-primary-dark dark:border-primary': activeTabe == 'action', 'border-transparent': activeTabe != 'action'}">
                            غير مقرؤ
                        </button>
                      
                        <button @click.prevent="activeTabe = 'user'"
                            class="px-px pb-4 transition-all duration-200 transform translate-y-px border-b focus:outline-none"
                            :class="{'border-primary-dark dark:border-primary': activeTabe == 'user', 'border-transparent': activeTabe != 'user'}">
                            مقرؤ
                        </button>

                    </div>
                </div>
            </div>

            <!-- Panel content (tabs) -->
            <div class="flex-1 pt-4 overflow-y-hidden hover:overflow-y-auto">
                <!-- Action tab -->
                <div class="space-y-4" x-show.transition.in="activeTabe == 'action'">
                   
                    {{$notifs->links()}}
                   @foreach ($notifs as $n)
                   <a href="#" wire:click="click_item({{$n->id}})" class="block bg-gray-200 dark:bg-dark">
                    <div class="flex px-4 text-right space-x-4">
                        <div class="relative flex-shrink-0">
                            <span
                                class="z-10 inline-block p-2 overflow-visible rounded-full bg-primary-50 text-primary-light dark:bg-primary-darker">
                                <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                            </span>
                            <div
                                class="absolute h-24 p-px -mt-3 -ml-px bg-primary-50 left-1/2 dark:bg-primary-darker">
                            </div>
                        </div>
                        <div class="flex-1 overflow-hidden">
                            <h5 class="text-sm font-semibold text-gray-600 dark:text-light">
                                {{$n->title}}
                            </h5>
                            <p
                                class="text-sm font-normal text-gray-800  dark:text-primary-lighter">
                                {{$n->body}}
                            </p>
                            <span class="text-sm font-normal text-gray-400 dark:text-primary-light"> 
                                {{date('Y/m/d h:i A',strtotime($n->created_at))}}
                            </span>
                        </div>
                    </div>
                </a>
                   
                   @endforeach
                </div>

                <div class="space-y-4" x-show.transition.in="activeTabe == 'user'">
                   {{$readed_notifs->links()}}
                    @foreach ($readed_notifs as $n)
                    <a  href="#" wire:click="click_item({{$n->id}})" class="block">
                     <div  class="flex text-right px-4 space-x-4">
                         <div class="relative flex-shrink-0">
                             <span
                                 class="z-10 inline-block p-2 overflow-visible rounded-full bg-primary-50 text-primary-light dark:bg-primary-darker">
                                 <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                         d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                 </svg>
                             </span>
                             <div
                                 class="absolute h-24 p-px -mt-3 -ml-px bg-primary-50 left-1/2 dark:bg-primary-darker">
                             </div>
                         </div>
                         <div class="flex-1 overflow-hidden">
                             <h5 class="text-sm font-semibold text-gray-600 dark:text-light">
                                 {{$n->title}}
                             </h5>
                             <p 
                                 class="text-sm font-normal text-gray-400  dark:text-primary-lighter">
                                 {{$n->body}}
                             </p>
                             <span class="text-sm font-normal text-gray-400 dark:text-primary-light"> 
                                 {{date('Y/m/d h:i A',strtotime($n->created_at))}}
                             </span>
                         </div>
                     </div>
                 </a>
                    
                    @endforeach
                 </div>

                <!-- User tab -->
              
            </div>
        </div>
    </section> 

    {{-- <script src="{{asset('js/jquery.min.js')}}"></script> --}}
        <script>

Audio.prototype.play = (function(play) {
return function () {
  var audio = this,
      args = arguments,
      promise = play.apply(audio, args);
  if (promise !== undefined) {
    promise.catch(_ => {
      // Autoplay was prevented. This is optional, but add a button to start playing.
      var el = document.createElement("button");
      el.innerHTML = "Play";
      el.addEventListener("click", function(){play.apply(audio, args);});
      this.parentNode.insertBefore(el, this.nextSibling)
    });
  }
};
})(Audio.prototype.play);
document.addEventListener('DOMContentLoaded',function(){


    $('.unread_count').html('{{$unread_count}}');


    window.Echo.channel('private-admin-notifiy')
  .listen('AdminNotifyEvent', (data) => {
    console.log('New notification:', data);

    @this.set('unread_count',{{$unread_count+1}});   

    $('.unread_count').html('{{$unread_count}}');
    document.getElementById("sound").play();
//     var audio = new Audio('{{asset("notifiy.wav")}}');
// audio.play();
    // Perform actions with the received data
  });

});
        </script>
    {{-- The Master doesn't talk, he acts. --}}
</div>
