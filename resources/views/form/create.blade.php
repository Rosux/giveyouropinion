{{-- route = http://127.0.0.1:8000/form/create/ --}}
<x-layout>
    Creation page

    <form method="POST" action="/form/create">
        @csrf

        <input type="questions" name="questions">
        
        <input type="submit" value="post">
    </form>
    
</x-layout>