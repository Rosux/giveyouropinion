{{-- route = http://127.0.0.1:8000/form/edit/{id} --}}
<x-layout>

    
@isset($form)

    {{ $form }}

@endisset


</x-layout>