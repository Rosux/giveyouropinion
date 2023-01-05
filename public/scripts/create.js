class CreateForm{
    constructor(){
        this.questions = {};
    }

    /**
     * Moves a property in the questions object up or down one position.
     * @param {string} id - The id of the property to move.
     * @param {string} direction - The direction to move the property ('up' or 'down').
     */
    moveQuestion(id, direction){
        let keys = Object.keys(this.questions);
        let index = keys.indexOf(id);
        if (index === -1) return; // property with specified id does not exist
        if (direction === 'up') {
            if (index === 0) return; // already at the top
            let temp = this.questions[index];
            this.questions[index] = this.questions[index - 1];
            this.questions[index - 1] = temp;
        } else if (direction === 'down') {
            if (index === keys.length - 1) return; // already at the bottom
            let temp = this.questions[index];
            this.questions[index] = this.questions[index + 1];
            this.questions[index + 1] = temp;
        }
    }

    /**
     * Adds a new question to the questions object.
     * @param {string} questionTitle - The title of the question.
     * @param {number} type - The type of the question.
     * @param {Object} options - Options specific to the type of the question.
     */
    addQuestion(questionTitle, type, options){
        let Q = {
            question_title: questionTitle,
            type: type
        };
        if(type === 1){
            Q.placeholder = options.placeholder || "";
        }else if(type === 2 || type === 3){
            Q.choices = options.choices || {};
        }
        this.questions[Object.keys(this.questions).length] = Q;
    }

    /**
     * Deletes a property from the questions object.
     * @param {string} key - The key of the property to delete.
     */
    deleteQuestion(key){
        delete this.questions[key];
        let newQuestions = {};
        for (let i = 0; i < Object.keys(this.questions).length; i++) {
            newQuestions[i] = this.questions[i];
        }
        this.questions = newQuestions;
    }

    /**
     * Sends the form data to the /form/create endpoint as a POST request.
     */
    async sendFormData(){
        // TODO: check csrf token if it works
        // get the form data from the DOM
        let title = document.querySelector('#title').value;
        let password = document.querySelector('#password').value;
        let maxAnswers = document.querySelector('#maxAnswers').value;
        let timeOpened = document.querySelector('#timeOpened').value;
        let timeClosed = document.querySelector('#timeClosed').value;
        let csrf = document.querySelector('meta[name="csrf-token"]').content;
        
        // create the form data object
        let formData = {
            _token: csrf,
            title: title,
            password: password,
            maxAnswers: maxAnswers,
            timeZone: Intl.DateTimeFormat().resolvedOptions().timeZone,
            timeOpened: timeOpened,
            timeClosed: timeClosed,
            questions: this.questions
        };

        // send the form data as a POST request
        let response = await fetch('/form/create', {
            method: 'POST',
            body: JSON.stringify(formData),
            headers: {
                'Content-Type': 'application/json'
            }
        });

        // process the response
        let result = await response.json();
        console.log(result);
    }

    #render(){
        // render the questions to the frontend
    }

}


const create = new CreateForm();




// var csrf = document.querySelector('meta[name="csrf-token"]').content;

// function postData(form, callbackFunction, errorFunction){
//     const request = new XMLHttpRequest();
//     request.onreadystatechange = function(){
//         if(request.readyState == XMLHttpRequest.DONE && this.status == 200){
//             callbackFunction(this);
//         }else if(request.readyState == XMLHttpRequest.DONE && request.status != 200){
//             console.error("Error: response failed");
//             if (typeof errorFunction === "function") { 
//                 errorFunction(this);
//             }
//             return;
//         }
//     }
//     request.dataType = 'json';
//     request.open("POST", form.getAttribute("action"), true);
//     request.send(new FormData(form));
// }

// function dd(){
//     var data = [
//         {
//             question_title: 'title1',
//             type: 1,
//             placeholder: 'placeholder1'
//         },
//         {
//             question_title: 'title2',
//             type: 2,
//             choices: {
//                 0: "blabla0",
//                 1: "blabla1",
//                 2: "blabla2"
//             }
//         },
//         {
//             question_title: 'title2',
//             type: 3,
//             choices: {
//                 0: "blabla0",
//                 1: "blabla1",
//                 2: "blabla2"
//             }
//         }
//     ];
//     const form = document.getElementById('form');
//     let formData = new FormData(form);
//     formData.append('questions', JSON.stringify(data));

//     // TIMEZONE TIMEZONE
//     const userTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
//     // add the timeZone object to the form data
//     formData.append('timeZone', userTimezone);
//     // TIMEZONE TIMEZONE

//     const formies = document.createElement("form");
//     formies.action = "/form/create";
//     formies.method = "POST";
//     // foreach data add it to new form element
//     for(const val of formData.entries()){
//         let i = document.createElement("input");
//         i.name = val[0];
//         i.value = val[1];
//         formies.appendChild(i);
//     }
//     console.log("sent data:",formData);
//     postData(formies, (e)=>{
//         try {
//             res = JSON.parse(e.response);
//         }catch(error){
//             res = e.response;
//         }
//         console.log(res, JSON.stringify(res));
//     });
// }


// form.addEventListener('submit', (e)=>{
//     e.preventDefault();
//     dd();
// });