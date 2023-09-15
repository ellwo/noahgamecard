<x-dashe-layout>
    {{-- <livewire:datatable
     model="App\Models\User"
      exclude="avatar,bio,banned_at,email_verified_at,updated_at,phone_verified_at"
      searchable="name,phone"
      exportable
      /> --}}

      @livewire('admin.code-table', key(time()))



</x-dashe-layout>
