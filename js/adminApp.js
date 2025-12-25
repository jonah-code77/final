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
        // this.showMessage(
        //     action === "approved" ? "approving student..." : "rejecting student...","info"
        // );
        const fd = new FormData();
        fd.append("student_id", id);

        fetch(`${this.endPoint}/${action}Student`,{
            method: "POST",
            body: fd
        }).then(res => res.json())
        .then(data => {  
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
           
        }).catch(error => {
            this.msg.innerHTML = `Error: Failed to submit form. ${error.message}`;
            console.error(error);
        })
    }
}

new adminApp("pendingStudent", "msg", "/FINAL/admin");


