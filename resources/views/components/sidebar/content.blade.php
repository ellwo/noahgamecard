<x-perfect-scrollbar as="div"
x-data="perfectScroll"
aria-label="main"
class="flex flex-col flex-1 gap-4 px-3 overflow-y-scroll">

    <x-sidebar.link title="لوحة التحكم " href="{{ route('dashboard') }}" :isActive="request()->routeIs('dashboard')">
        <x-slot name="icon">
            <x-icons.dashboard class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>





 @can('users_manage')

 <x-sidebar.link title="ادارة المستخدمين" href="{{ route('admin.users.index')}}" :isActive="request()->routeIs('admin.users.index')||request()->routeIs('admin.users.index')">
    <x-slot name="icon">
        <x-bi-person class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
    </x-slot>
</x-sidebar.link>

 @endcan


 <x-sidebar.link title="اكواد تفعيل الحسابات" href="{{ route('codes')}}"
 :isActive="request()->routeIs('codes')||request()->routeIs('codes.*')">
</x-sidebar.link>



 @can('ادارة العملاء')

<x-sidebar.link title="ادارة العملاء" href="{{ route('users')}}" :isActive="request()->routeIs('users')||request()->routeIs('users.*')">
    <x-slot name="icon">
        <x-heroicon-s-users class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
    </x-slot>
</x-sidebar.link>
 @endcan



 @can('ادارة المزودين')

 <x-sidebar.dropdown title="ادارة المزودين" :active="Str::contains(request()->route()->uri(), 'provider')">
    <x-slot name="icon">
        <x-heroicon-o-view-grid class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
    </x-slot>

    <x-sidebar.sublink title="ارصدة المزودين" href="{{ route('clients-provider') }}"
        :active="request()->routeIs('clients-provider')" />
    <x-sidebar.sublink title="منتجات المزودين" href="{{ route('provider_products') }}"
        :active="request()->routeIs('provider_products')" />
</x-sidebar.dropdown>
@endcan



@can('ادارة المزودين')

<x-sidebar.dropdown title="التقارير" :active="Str::contains(request()->route()->uri(), 'report')">
   <x-slot name="icon">
       <x-heroicon-o-view-grid class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
   </x-slot>

   <x-sidebar.sublink title="تقرير المبيعات بحسب القسم " href="{{ route('depts',['report','report']) }}"
       :active="request()->routeIs('clients-provider')" />
   <x-sidebar.sublink title="تقرير اجمالي التغذية والشراء " href="{{ route('order.reports') }}"
       :active="request()->routeIs('order.reports')" />
</x-sidebar.dropdown>
@endcan
 @can('ادارة اسعار الصرف')

 <x-sidebar.link title="ادارة اسعار العملات" href="{{ route('coins')}}" :isActive="request()->routeIs('coins')||request()->routeIs('coins.*')">
    <x-slot name="icon">
        <x-bi-coin class="w-6 h-6 cursor-pointer "/>
      </x-slot>
</x-sidebar.link>

 @endcan



@can('ادارة المنتجات')
    <x-sidebar.link title="ادارة المنتجات" href="{{ route('products')}}" :isActive="request()->routeIs('products')||request()->routeIs('products-table')">
    <x-slot name="icon">
        <x-bi-bag class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
    </x-slot>
</x-sidebar.link>
@endcan

@can('ادارة الاقسام')
    <x-sidebar.link title="ادارة الاقسام" href="{{ route('depts')}}" :isActive="request()->routeIs('depts')">
    <x-slot name="icon">
        <x-bi-grid class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
    </x-slot>

</x-sidebar.link>

@endcan


@can('ادارة الاعلانات')
    <x-sidebar.link title="ادارة الاعلانات" href="{{ route('ad')}}" :isActive="request()->routeIs('ad')">
    <x-slot name="icon">
        <x-bi-images class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
    </x-slot>

</x-sidebar.link>

@endcan


@can('ادارة العروض')

<x-sidebar.link title="ادارة العروض " href="{{ route('offers')}}" :isActive="request()->routeIs('offers')">
    <x-slot name="icon">

     <x-bi-gift class="flex-shrink-0 w-6 h-6" aria-hidden="true"  />
    </x-slot>

</x-sidebar.link>

@endcan
@can('ادارة العمولات')
<x-sidebar.link title="ادارة العمولات " href="{{ route('discount')}}" :isActive="request()->routeIs('discount')">
    <x-slot name="icon">

        <svg class="flex-shrink-0 w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <g>
                <path fill="none" d="M0 0h24v24H0z"></path>
                <path d="M14.121 10.48a1 1 0 0 0-1.414 0l-.707.706a2 2 0 1 1-2.828-2.828l5.63-5.632a6.5 6.5 0 0 1 6.377 10.568l-2.108 2.135-4.95-4.95zM3.161 4.468a6.503 6.503 0 0 1 8.009-.938L7.757 6.944a4 4 0 0 0 5.513 5.794l.144-.137 4.243 4.242-4.243 4.243a2 2 0 0 1-2.828 0L3.16 13.66a6.5 6.5 0 0 1 0-9.192z"></path>
            </g>
        </svg>
    </x-slot>

</x-sidebar.link>
@endcan


@can('ادارة الطلبات')

<x-sidebar.link title="ادارة طلبات الخدمات" href="{{ route('paymentinfo') }}" :isActive="request()->routeIs('owne-service-orders')">
    <x-slot name="icon">
        <x-heroicon-s-shopping-cart class="flex-shrink-0 w-6 h-6" aria-hidden="true" />

        </x-slot>

</x-sidebar.link>
@endcan


@can('ادارة التغذية')
<x-sidebar.link title="ادارة عمليات التغذية " href="{{ route('rasseds') }}" :isActive="request()->routeIs('rasseds')">
    <x-slot name="icon">
        <x-bi-inbox class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
    </x-slot>

</x-sidebar.link>
@endcan


@if (request()->has('meme'))

<x-sidebar.link title="{{__('Setting')}}" href="{{route('sitesetting')}}"  :isActive="request()->routeIs('sitesetting')">
    <x-slot name="icon">
        <x-bi-magnet class="w-6 h-6 cursor-pointer "/>
    </x-slot>
</x-sidebar.link>
@endif


</x-perfect-scrollbar>
