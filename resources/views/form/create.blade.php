{{-- route = http://127.0.0.1:8000/form/create/ --}}
<x-layout>
    Creation page

    <form id="form" method="POST" action="/form/create">
        @csrf

        <input type="text" name="title" placeholder="title" value="blabla"><br>

        {{-- <input type="text" name="questions" placeholder="questions"><br> --}}

        <input type="checkbox" name="password" placeholder="password"><br>
        <input type="number" name="maxAnswers" placeholder="maxAnswers"><br>
        <input type="datetime-local" name="timeOpened" placeholder="timeOpened" value="2022-12-30T11:11"><br>
        <input type="datetime-local" name="timeClosed" placeholder="timeClosed"><br>
        <input type="submit" value="post">
    </form>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script defer>
        var csrf = document.querySelector('meta[name="csrf-token"]').content;

        function postData(form, callbackFunction, errorFunction){
            const request = new XMLHttpRequest();
            request.onreadystatechange = function(){
                if(request.readyState == XMLHttpRequest.DONE && this.status == 200){
                    callbackFunction(this);
                }else if(request.readyState == XMLHttpRequest.DONE && request.status != 200){
                    console.error("Error: response failed");
                    if (typeof errorFunction === "function") { 
                        errorFunction(this);
                    }
                    return;
                }
            }
            request.dataType = 'json';
            request.open("POST", form.getAttribute("action"), true);
            request.send(new FormData(form));
        }

        function dd(){
            var data = [
                {
                    question_title: 'title1',
                    type: 1,
                    placeholder: 'placeholder1'
                },
                {
                    question_title: 'title2',
                    type: 2,
                    choices: {
                        0: "blabla0",
                        1: "blabla1",
                        2: "blabla2"
                    }
                },
                {
                    question_title: 'title2',
                    type: 3,
                    choices: {
                        0: "blabla0",
                        1: "blabla1",
                        2: "blabla2"
                    }
                }
            ];
            const form = document.getElementById('form');
            let formData = new FormData(form);
            formData.append('questions', JSON.stringify(data));

            // TIMEZONE TIMEZONE
            const userTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
            // add the timeZone object to the form data
            formData.append('timeZone', userTimezone);
            // TIMEZONE TIMEZONE

            const formies = document.createElement("form");
            formies.action = "/form/create";
            formies.method = "POST";
            // foreach data add it to new form element
            for(const val of formData.entries()){
                let i = document.createElement("input");
                i.name = val[0];
                i.value = val[1];
                formies.appendChild(i);
            }
            console.log("sent data:",formData);
            postData(formies, (e)=>{
                try {
                    res = JSON.parse(e.response);
                }catch(error){
                    res = e.response;
                }
                console.log(res, JSON.stringify(res));
            });
        }
    

        form.addEventListener('submit', (e)=>{
            e.preventDefault();
            dd();
        });


    </script>
</x-layout>