{{-- route = http://127.0.0.1:8000/form/ --}}
<x-layout>
@foreach ($forms as $form)
    {{ $form }} <br>
@endforeach
</x-layout>