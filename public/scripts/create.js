class CreateForm{
    constructor(){
        this.questions = {};
        this.#render();
    }

    /**
     * Moves a property in the questions object up or down one position.
     * @param {number} id - The id of the property to move.
     * @param {string} direction - The direction to move the property ('up' or 'down').
     */
    moveQuestion(id, direction){
        let keys = Object.keys(this.questions);
        let index = keys.indexOf(id.toString());
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
        if(Object.keys(this.questions).length >= 50){
            return;
        }
        let Q = {
            question_title: questionTitle,
            type: type
        };
        if(type === 1){
            Q.placeholder = options.placeholder || "";
        }else if(type === 2 || type === 3){
            Q.choices = options.choices || {0:"", 1:""};
        }
        this.questions[Object.keys(this.questions).length] = Q;
        this.#render();
    }

    /**
     * Deletes a property from the questions object.
     * @param {number} key - The key of the property to delete.
     */
    deleteQuestion(key){
        delete this.questions[key];
        let newQuestions = {};
        let count = 0;
        for(const index in this.questions){
            newQuestions[count] = this.questions[index];
            count++;
        }
        this.questions = newQuestions;
        this.#render();
    }

    /**
     * Sends the form data to the /form/create endpoint as a POST request.
     */
    async sendFormData(){
        // get the form data from the DOM
        let title = document.querySelector('#title').value;
        let password = document.querySelector('#password').checked;
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
        if(result.success == true){
            // redirect to the new form
            window.location.replace(window.location.protocol+"//"+window.location.host+"/form/"+result.newUrlToken+"/"+result.newPassword);
        }else{
            // TODO: Error Handling
        }
    }

    /**
     * remove a new choice to type 2/3 questions
     * @param {Number} key key of property to remove a choice from
     * @param {Number} questionKey key of the value to be removed
     */
    removeQuestionOption(key=-1, questionKey=-1){
        if(key == -1 || questionKey == -1 || this.questions[key] == undefined || this.questions[key].type == 1 || this.questions[key].choices == undefined || this.questions[key].choices[questionKey] == undefined || Object.keys(this.questions[key].choices).length <= 2){
            return;
        }
        delete this.questions[key].choices[questionKey];
        // convert keys so its ordered again
        let count = 0;
        let newData = {};
        for(const index in this.questions[key].choices){
            newData[count] = this.questions[key].choices[index];
            count++;
        }
        this.questions[key].choices = newData;
        this.#render();
    }

    /**
     * add a new choice to type 2/3 questions
     * @param {Number} key key of property to add a choice to
     * @param {String} value value to add as option
     */
    addQuestionOption(key=-1, value=""){
        // obj doesnt have correct type
        if(this.questions[key] == undefined || this.questions[key].type == 1 || this.questions[key].choices == undefined || Object.keys(this.questions[key].choices).length >= 25){
            return;
        }
        this.questions[key].choices[Object.keys(this.questions[key].choices).length] = value;
        this.#render();
    }

    /**
     * render the questions with eventlisteners
     */
    #render(){
        // output
        const outputElement = document.querySelector(".questions");
        // pre-empty output
        outputElement.innerHTML = "";
        // loop over questions
        for(let i=0;i<Object.keys(this.questions).length;i++){
            let Q = document.createElement("div");
            Q.classList.add("question-wrapper");
            // question type text
            let questionType = document.createElement("div");
            questionType.classList.add("question-type")
            let optionText = document.createElement("p");
            if(this.questions[i].type == 1){
                optionText.innerText = "Open Question";
            }else if(this.questions[i].type == 2){
                optionText.innerText = "Single Choice Options";
            }else if(this.questions[i].type == 3){
                optionText.innerText = "Multi Choice Options";
            }
            questionType.appendChild(optionText);
            Q.appendChild(questionType);
            // question number
            let qn = document.createElement("div");
            qn.classList.add("question-number");
            qn.innerHTML = `<p>${i+1}</p>`;
            Q.appendChild(qn);
            // button wrapper
            let dmm = document.createElement("div");
            dmm.classList.add("delete-move-wrapper");
            // delete button
            let deleteButton = document.createElement("button");
            deleteButton.addEventListener("click", (e)=>{
                this.deleteQuestion(i);
            });
            // move buttons
            let moveUp = document.createElement("button");
            let moveDown = document.createElement("button");
            moveUp.addEventListener("click",()=>{this.moveQuestion(i, "up");});
            moveDown.addEventListener("click",()=>{this.moveQuestion(i, "down");});
            // set svg's
            deleteButton.innerHTML = `<svg width="24" height="24" fill-rule="evenodd" clip-rule="evenodd"><path d="M12 11.293l10.293-10.293.707.707-10.293 10.293 10.293 10.293-.707.707-10.293-10.293-10.293 10.293-.707-.707 10.293-10.293-10.293-10.293.707-.707 10.293 10.293z"/></svg>`;
            moveUp.innerHTML = `<svg width="24" height="24" fill-rule="evenodd" clip-rule="evenodd"><path d="M23.245 20l-11.245-14.374-11.219 14.374-.781-.619 12-15.381 12 15.391-.755.609z"/></svg>`;
            moveDown.innerHTML = `<svg width="24" height="24" fill-rule="evenodd" clip-rule="evenodd"><path d="M23.245 4l-11.245 14.374-11.219-14.374-.781.619 12 15.381 12-15.391-.755-.609z"/></svg>`;
            // append * 3
            dmm.appendChild(deleteButton);
            dmm.appendChild(moveUp);
            dmm.appendChild(moveDown);
            // append to Q
            Q.appendChild(dmm);
            // input
            let inp = document.createElement("input");
            inp.type = "text";
            inp.placeholder = "Question Title";
            inp.value = this.questions[i].question_title;
            // when input changes update data
            inp.addEventListener("input", (e)=>{
                this.questions[i].question_title = e.target.value;
            });
            // question-input
            let questionInput = document.createElement("div");
            questionInput.classList.add("question-input");
            questionInput.appendChild(inp);
            // type stuff
            if(this.questions[i].type == 1){
                let placeholderInput = document.createElement("input");
                placeholderInput.type = "text";
                placeholderInput.placeholder = "Question Placeholder";
                placeholderInput.value = this.questions[i].placeholder;
                // handle input event
                placeholderInput.addEventListener("input", (e)=>{
                    this.questions[i].placeholder = e.target.value;
                });
                questionInput.appendChild(placeholderInput);
            }else if(this.questions[i].type == 2 || this.questions[i].type == 3){
                let optionWrapper = document.createElement("div");
                optionWrapper.classList.add("question-choices");
                // for all options
                for(let j=0;j<Object.keys(this.questions[i].choices).length;j++){
                    let option = document.createElement("input");
                    option.type = "text";
                    option.placeholder = `Option ${j+1}`;
                    option.value = this.questions[i].choices[j];
                    // when input changes update data
                    option.addEventListener("input", (e)=>{
                        this.questions[i].choices[j] = e.target.value;
                    });
                    // append to wrapper
                    optionWrapper.appendChild(option);
                    // create the remove button
                    let removeButton = document.createElement("button");
                    removeButton.addEventListener("click", (e)=>{
                        this.removeQuestionOption(i, j);
                    });
                    removeButton.innerHTML = `<svg width="24" height="24" fill-rule="evenodd" clip-rule="evenodd"><path d="M12 11.293l10.293-10.293.707.707-10.293 10.293 10.293 10.293-.707.707-10.293-10.293-10.293 10.293-.707-.707 10.293-10.293-10.293-10.293.707-.707 10.293 10.293z"/></svg>`;
                    // append to wrapper
                    optionWrapper.appendChild(removeButton);
                }
                questionInput.appendChild(optionWrapper);
                // add option button
                let optionBtn = document.createElement("button");
                optionBtn.innerText = "Add new choice";
                optionBtn.addEventListener("click", (e)=>{
                    this.addQuestionOption(i, '');
                });
                questionInput.appendChild(optionBtn);
            }
            // append questioninput to q
            Q.appendChild(questionInput);
            // append Q to outputElement
            outputElement.appendChild(Q);
        } 
    }
}

function sendData(){
    create.sendFormData();
}

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
        create.addQuestion("", 1, "");
    }else if(choice==2){
        // single choice from list
        create.addQuestion("", 2, "");
    }else if(choice==3){
        // multiple choices from list
        create.addQuestion("", 3, "");
    }
}

const create = new CreateForm();