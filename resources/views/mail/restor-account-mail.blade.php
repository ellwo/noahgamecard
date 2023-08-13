
@component('mail::message')

@slot('header')

<x-application-logo/>
@endslot
# Introduction

The body of your message.


@component('mail::button', ['url' => ''])
Button Text
@endcomponent



Thanks,<br>
{{ config('app.name') }}
@endcomponent
