{{-- route = http://127.0.0.1:8000/form/ --}}
<x-layout>



    @isset($forms)

        @foreach ($forms as $form)

            {{-- display form --}}
            <pre>{{ $form }}</pre><br>
            <form method="POST" action="/form/delete">
                @csrf
                <input type="number" value="{{ $form['id'] }}" name="id" hidden>
                <button>delete this form</button>
            </form><hr><br><br>

        @endforeach

    @endisset
    


</x-layout>