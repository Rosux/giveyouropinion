{{-- route = http://127.0.0.1:8000/form/{urlToken} --}}
<x-layout>



    @isset($error)

        {{-- display the error message --}}
        {{ $error }}

    @else
        {{-- no errors --}}
    
        @isset($form)

            {{-- display form --}}
            {{ $form }}

        @else

            {{-- display a no form found error message --}}
            No form found!
            
        @endisset

    @endisset



</x-layout>
