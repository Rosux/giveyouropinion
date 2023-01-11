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
        this.#render();
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
        this.#render();
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
        this.#render();
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
        // TODO implement the response stuff here

    }

    #render(){
        // render the questions

        const outputElement = document.querySelector(".questions");
        // empty output
        outputElement.innerHTML = "";
        // loop over questions
        for (let i = 0; i < Object.keys(this.questions).length; i++) {
            // this.questions[i];
            let Q = document.createElement("div");
            Q.classList.add("question-wrapper");
            
            // input
            let inp = document.createElement("input");
            inp.type = "text";
            inp.placeholder = "Question Title";
            inp.value = this.questions[i].question_title;
            // when input changes update data
            inp.addEventListener("input", (e)=>{
                this.questions[i].question_title = e.target.value;
            });
            Q.appendChild(inp);

            if(this.questions[i].type == 1){
                let placeholderInput = document.createElement("input");
                placeholderInput.type = "text";
                placeholderInput.placeholder = "Question Placeholder";
                placeholderInput.value = this.questions[i].placeholder;
                // handle input event
                placeholderInput.addEventListener("input", (e)=>{
                    this.questions[i].placeholder = e.target.value;
                });
                Q.appendChild(placeholderInput);
            }else if(this.questions[i].type == 2){





            }

            // append Q to outputElement
            outputElement.appendChild(Q);
        }
        

        


    }

}

const create = new CreateForm();
create.addQuestion("title1", 1, {placeholder: "placeholder1"});













function showOptions(){
    // hides .add-question-button and shows .add-question-choice
    document.querySelector(".add-question-button").style.visibility = "collapse";
    document.querySelector(".add-question-choice").style.visibility = "visible";
}

function choice(choice=0){
    document.querySelector(".add-question-button").style.visibility = "visible";
    document.querySelector(".add-question-choice").style.visibility = "collapse";
    if(choice==1){
        // open ended question
    }else if(choice==2){
        // single choice from list
    }else if(choice==3){
        // multiple choices from list
    }
}