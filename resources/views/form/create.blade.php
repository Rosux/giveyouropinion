{{-- route = http://127.0.0.1:8000/form/create/ --}}
<x-layout>
    <link rel="stylesheet" href="{{ asset("styles/create.css") }}">
    <script defer src="{{ asset("scripts/create.js") }}"></script>
    
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
            
            <div class="page-title"><p>Questions</p></div>

            <div class="questions">
                {{-- questions get added here with js --}}
            </div>

            {{-- the add new question button --}}
            <div class="creation-questions">
                {{-- choose from types --}}
                <div class="add-question-choice" style="visibility: collapse">
                    <div class="question-choice-title"><p>Choose a type</p></div>
                    <div class="question-choice" onclick="choice(3);"><p>Multi Choice Question</p></div>
                    <div class="question-choice" onclick="choice(2);"><p>Single Choice Question</p></div>
                    <div class="question-choice" onclick="choice(1);"><p>Open Question</p></div>
                </div>
                {{-- question button --}}
                <div class="add-question-button">
                    <button onclick="showOptions();">Add New Question</button>
                </div>
            </div>
            
            {{-- sending button --}}
            <div class="creation-send">
                <button onclick="sendData();">Create</button>
            </div>
        </div>
    </div>

</x-layout>