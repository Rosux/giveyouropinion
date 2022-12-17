{{-- route = http://127.0.0.1:8000/form/answers/{urlToken} for admin/user to see answers--}}
<x-layout>
    

    
    @isset($answers)
    
        @foreach ($answers as $answer)
            {{ $answer }} <br>
        @endforeach

    @else
    
        No answers yet...

    @endisset



</x-layout>