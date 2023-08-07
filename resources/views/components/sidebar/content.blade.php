<x-perfect-scrollbar as="nav" aria-label="main" class="  h-screen space-y-4 flex-1 gap-4 px-3">

    <x-sidebar.link title="لوحة التحكم " href="{{ route('dashboard') }}" :isActive="request()->routeIs('dashboard')">
        <x-slot name="icon">
            <x-icons.dashboard class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>


<x-sidebar.dropdown title="حسابي " :active="request()->routeIs('profile')">

    <x-slot name="icon" >
        <span aria-hidden="true">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
        </span>
    </x-slot>
    <x-sidebar.sublink href="{{-- route('profile') --}}" title="استعراض " :active="request()->routeIs('profile')">

    </x-sidebar.sublink>


    <x-sidebar.sublink href="{{-- route('profile.create') --}}" title="تعديل البيانات " :active="request()->routeIs('profile')">

    </x-sidebar.sublink>


</x-sidebar.dropdown>


<x-sidebar.link title="لوحة التحكم" href="{{-- route('dashboard') --}}" :isActive="request()->routeIs('dashboard')">
    <x-slot name="icon">
        <x-icons.dashboard class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
    </x-slot>
</x-sidebar.link>




{{-- @role('admin')
       <x-sidebar.content-admin />
@endrole
 --}}







 @can('users_manage')

 <x-sidebar.link title="ادارة المستخدمين" href="{{ route('admin.users.index')}}" :isActive="request()->routeIs('admin.users.index')||request()->routeIs('admin.users.index')">
    <x-slot name="icon">
        <x-bi-person class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
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


@can('ادارة العروض')

<x-sidebar.link title="ادارة العروض " href="{{ route('offers')}}" :isActive="request()->routeIs('offers')">
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
        <x-bi-inbox class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
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
        <x-bi-magnet class="h-6 w-6 cursor-pointer "/>
    </x-slot>
</x-sidebar.link>
@endif


</x-perfect-scrollbar>
