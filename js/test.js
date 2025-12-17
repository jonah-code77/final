

class app {
    constructor(formId, msgId, file){
        this.form = document.getElementById(formId);
        this.msg = document.getElementById(msgId);
        this.file = file;
        this.init();
    }

    showMessage(data){
        if (data.status === "success") {
            this.msg.innerHTML = data.msg;
            return;
        }


        let err = "";
        if (data.status === "error") {
            
            for(let field in data.errors){
                err += `<p>${data.errors[field]}</p>`
            }

        }
        this.msg.innerHTML = err;
    }

    submitForm(){
        fetch(this.file, {
            method: "POST",
            body: new FormData(this.form)
        })
        .then(res => res.text())
        .then(data => {
            console.log("raw response", data)
            this.msg.innerHTML = data
        })
        .catch(error => {
            this.msg.innerHTML = `Error: Failed to submit form. (${error.message})`;
            console.error(error);
        })
        
    }

    init(){
        if(!this.form)return;
        this.form.addEventListener("submit",e =>{
            e.preventDefault();
            this.submitForm();
        })
    }
}

new app("regForm", "msg", `regStudent`)

//for future use..lol..i suffer ooo

