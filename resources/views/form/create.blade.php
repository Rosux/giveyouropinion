{{-- route = http://127.0.0.1:8000/form/create/ --}}
<x-layout>
    <link rel="stylesheet" href="{{ asset("styles/create.css") }}">
    <script src="{{ asset("scripts/create.js") }}"></script>
    
    <div class="page-title"><p>Create a new form</p></div>
    
    <div class="creation-wrapper-wrapper">
        <div class="creation-wrapper">

            <div class="creation-title-wrapper">
                <input type="text" name="title" id="title" placeholder="New Form Title">
            </div>


            <div class="creation-settings-wrapper">
                <div class="creation-password">
                    <p>Generate Password?</p>
                    <div class="button-switch">
                        <input type="checkbox" name="password" id="password">
                        <label for="password"><div class="circle"></div></label>
                    </div>
                    <p class="option-hint">*Adds a password in the url</p>
                </div>
                <div class="creation-max-answers">
                    <p>Maximum Answers?</p>
                    <input type="number" name="maxAnswers" id="maxAnswers" placeholder="Maximum Answers">
                    <p class="option-hint">*Leave empty to allow unlimited asnwers</p>
                </div>
                <div class="creation-time-opened">
                    <p>Opening Time?</p>
                    <input type="datetime-local" name="timeOpened" id="timeOpened">
                    <p class="option-hint">*Leave empty to open right now</p>
                </div>
                <div class="creation-time-closed">
                    <p>Closing Time?</p>
                    <input type="datetime-local" name="timeClosed" id="timeClosed">
                    <p class="option-hint">*Leave empty to always keep it open</p>
                </div>
            </div>



            <div class="questions">
                {{-- add questions here with js --}}
            </div>


            
            <div class="creation-questions">


                {{-- choose from types --}}
                <div class="add-question-choice">
                    <div class="question-choice-title"><p>Choose a type</p></div>

                    <div class="question-choice"><p>Multi choice answers</p></div>
                    <div class="question-choice"><p>Single choice answers</p></div>
                    <div class="question-choice"><p>Free answers</p></div>


                </div>


                {{-- question button --}}
                <div class="add-question-button">
                    <button>Add New Question</button>
                </div>




            </div>
            <div class="creation-send">
                <button>Create</button>
            </div>
        </div>
    </div>



    {{-- <form id="form" method="POST" action="/form/create">
        @csrf

        <input type="text" name="title" placeholder="title" value="blabla"><br>


        <input type="checkbox" name="password" placeholder="password"><br>
        <input type="number" name="maxAnswers" placeholder="maxAnswers"><br>
        <input type="datetime-local" name="timeOpened" placeholder="timeOpened" value="2022-12-30T11:11"><br>
        <input type="datetime-local" name="timeClosed" placeholder="timeClosed"><br>
        <input type="submit" value="post">
    </form> --}}
    
</x-layout>