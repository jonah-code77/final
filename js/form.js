

class app {
    constructor(formId, msgId, file){
        this.form = document.getElementById(formId);
        this.msg = document.getElementById(msgId);
        this.file = file;
        this.init();
    }

     showMessage(data){
        if (data.status === "success") {
            //ssthis.msg.innerHTML = data.msg;
            if (data.redirect) {
                setTimeout(()=>{
                    window.location.href = data.redirect
                })
            }
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
        .then(text => {
            try {
                const data = JSON.parse(text)
                this.showMessage(data)
            } catch (error) {
                this.msg.innerHTML = "Server returned invalid JSON. ".error.message
            }
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
new app("logIn", "msg", "logInn");



