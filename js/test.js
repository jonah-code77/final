

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
        .then(res => res.json())
        .then(data => this.showMessage(data))
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

new app("regForm", "msg", `regStudent`);
new app("logIn", "msg", "logInn");




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
        .then(text => {
            try {
                const data = JSON.parse(text)
                this.showMessage(data)
            } catch (error) {
                this.msg.innerHTML = "Server returned invalid JSON."
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

class adminApp{

    constructor(containerId,msgId,endPoint){
        this.container = document.getElementById(containerId);
        this.msg = document.getElementById(msgId);
        this.endPoint = endPoint;
        this.init();
    }

    init(){
        if(!this.container) return;

        this.container.addEventListener("click", (e)=> {
            const btn = e.target.closest(".admin-action");
            if (!btn) return;
            e.preventDefault();
            const action = btn.dataset.action;
            const id = btn.dataset.id;

            this.processing(id,action);
        });
    }

    showMessage(msg, type = "info"){
        this.msg.innerHTML = `<p class="${type}">${msg}</p>`;
        setTimeout (() => {this.msg.innerHTML = ""}, 2000)
        
    }

    processing(id,action){
        console.log("student id", id)
        // this.showMessage(
        //     action === "approved" ? "approving student..." : "rejecting student...","info"
        // );
        const fd = new FormData();
        fd.append("student_id", id);

        fetch(`${this.endPoint}/${action}Student`,{
            method: "POST",
            body: fd
        }).then(res => res.text())
        .then(text => {  
            console.log("RAW RESPONSE", text)    
            try {
                const data = JSON.parse(text)
                if (data.status === "success") {
                    this.showMessage(
                        action === "approved" ? "student approved" : "student rejected", "success"
                    )
                    const row = document.getElementById(`student-${id}`);
                    if(row) row.remove();
                }else{
                    this.showMessage(
                        Object.values(data.msg, "error")
                    )
                }
            } catch (error) {
                this.msg.innerHTML = `Server returned invalid JSON.`
                console.error("json parse error", error);
            }
        }).catch(error => {
            this.msg.innerHTML = `Error: Failed to submit form. ${error.message}`;
            console.error(error);
        })
    }
}

new adminApp("pendingStudent", "msg", "/FINAL/admin");








