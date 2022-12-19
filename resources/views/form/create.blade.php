{{-- route = http://127.0.0.1:8000/form/create/ --}}
<x-layout>
    Creation page

    <form method="POST" action="/form/create">
        @csrf

        <input type="text" name="questions" placeholder="questions"><br>
        <input type="checkbox" name="password" placeholder="password"><br>
        <input type="number" name="maxAnswers" placeholder="maxAnswers"><br>
        <input type="datetime-local" name="timeOpened" placeholder="timeOpened"><br>
        <input type="datetime-local" name="timeClosed" placeholder="timeClosed"><br>
        
        <input type="submit" value="post">
    </form>
    
</x-layout>