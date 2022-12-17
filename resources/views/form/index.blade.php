{{-- route = http://127.0.0.1:8000/form/ --}}
<x-layout>



    @isset($forms)

        @foreach ($forms as $form)

            {{ $form }} <br>

        @endforeach

    @endisset
    


</x-layout>