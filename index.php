
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .vh-100 {
            height: 100vh;
        }

.btn-group{
    float:right;
}
.margin{
    margin-right:15px;

}
    </style>
</head>
<body>
    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="col-md-6 col-sm-8 col-10 mx-auto">
            <div class="card shadow-lg p-4">
                <h3 class="text-center mb-4">Register Form</h3>
                <form id="Login-Form">
                    <!-- Name field -->
                    <div class="form-group">
                        <label for="inputName">Name</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="inputName" 
                            placeholder="Enter your name" name="name" >
                            <div id="namemsg">

                            </div>
                    </div>
                   
                    <!-- Email Field -->
                    <div class="form-group">
                        <label for="inputEmail">Email address</label>
                        <input 
                            type="email" 
                            class="form-control" 
                            id="inputEmail" 
                            aria-describedby="emailHelp" 
                            placeholder="Enter your email" name="email" >
                        <small id="emailHelp" class="form-text text-muted" >
                            We'll never share your email with anyone else.
                        </small>
                        <div id="emailmsg">

                        </div>
                    </div>
                    
                    <!-- Date Field -->
                    <div class="form-group">
                        <label for="inputDate">Date of Birth</label>
                        <input 
                            type="date" 
                            class="form-control" 
                            id="inputDate" name="dob" >
                            <div id="dobmsg">

                            </div>
                    </div>
                    
                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary btn-block" id="Submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <div class="container vh-100 ">
    <table id="records" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th class="bg-primary text-white border border-white">id</th>
                <th class="bg-primary text-white border border-white">name</th>
                <th class="bg-primary text-white border border-white">email</th>
                <th class="bg-primary text-white border border-white">d.o.b</th>
                <th class="bg-primary text-white border border-white">createdAt</th>
                <th class="bg-primary text-white border border-white">modifiedAt</th>
                <th class="bg-primary text-white border border-white">edit</th>
                <th class="bg-primary text-white border border-white">delete</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
        </tfoot>
    </table>
    <div class="btn-group">
        <button class="btn btn-primary margin border border-primary border-bold left"><i class="bi bi-chevron-left" ></i></button>
        <button class="btn  margin border border-primary border-bold"><i>1</i></button>
        <button class="btn  margin border border-primary border-bold "><i>2</i></button>
        <button class="btn btn-primary margin border border-primary border-bold right"><i class="bi bi-chevron-right" ></i></button>
    </div>
    </div>
<div class="modal fade" id="Edit" tabindex="-1" aria-labelledby="EditModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="Edit-form" name="submit">
                    <!-- Name field -->
                    <div class="form-group">
                        <label for="inputName" >Name</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="Editname"
                            placeholder="Enter your name" name="name" required>
                    </div>
                    
                    <!-- Email Field -->
                    <div class="form-group">
                        <label for="inputEmail" >Email address</label>
                        <input 
                            type="email" 
                            class="form-control" 
                            id="Editemail"
                            aria-describedby="emailHelp" 
                            placeholder="Enter your email" name="email" required>
                    </div>
                    
                    <!-- Date Field -->
                    <div class="form-group">
                        <label for="inputDate" >Date of Birth</label>
                        <input 
                            type="date" 
                            class="form-control" 
                            id="Editdob" name="dob" required>
                    </div>
              
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save">Save changes</button>
      </div>
    </div>
  </div>
</div>
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/2.1.8/pagination/simple_incremental_bootstrap.js"></script>
    <!-- DataTables CSS -->
    <!-- DataTables Bootstrap JS -->
    
</body>
<script>

const table = new DataTable('#records', {
    pagingType: 'simple_numbers', 
    paging: false, 
});
const formData = document.getElementById("Login-Form");
const Submit = document.getElementById("Submit");
const url = "http://localhost/MYAPI/users";
let totalrows=0;
document.getElementById('save').addEventListener('click', function () {
    const modalElement = document.getElementById('Edit');
    const modalInstance = bootstrap.Modal.getInstance(modalElement);
    modalInstance.hide();
});
function customFetch(e) {
    Submit.innerHTML = "Please wait";
    Submit.disabled = true;

    return new Promise((resolve, reject) => {
        console.log("inside fetch");
        setTimeout(() => {
            var data = new FormData(formData);
            const value = Object.fromEntries(data.entries());
            fetch(`${url}/action.php/`, {
                method: "post",
                body: JSON.stringify(value),
                headers: {
                    "Content-type": "application/json",
                }
            }).then((response) => response.json()).then((data) => {
                resolve(data);
            });
        }, 2000);
    });
}

async function asynccall(e) {
    try {
        await customFetch(e);
        getFetchCall();
    } catch (e) {
        console.error("error occured:", e);
    } finally {
        Submit.disabled = false;
        Submit.innerHTML = "Submit";
    }
}

document.addEventListener("DOMContentLoaded", (event) => {
    getFetchCall();
    var errors={};
    formData.addEventListener("submit", (e)=>{
        e.preventDefault();
        console.log("document Loaded");
        var data = new FormData(formData);
        const pairs=Array.from(data);
        let obj;
        pairs.forEach(()=>{
            obj=Object.fromEntries(pairs);
        })
        console.log(obj);
        
       
        if(obj.name==""||obj.email==""||obj.dob=="")
        {
            errors.namemsg=(obj.name=="")?"<div style='color:red' >*name field required</div>":"";
            errors.emailmsg=(obj.email=="")?"<div style='color:red' >*email field required</div>":"";
            errors.dobmsg=(obj.dob=="")?"<div style='color:red' >*dob field required</div>":"";
            for(let index in errors)
            {
                ele=document.getElementById(index);
                ele.parentNode.children[1].style.border="3px solid red";
                ele.innerHTML=errors[index];
            }
        }
        else
        {
            asynccall(e); 
        }
    });
});

function Edit(name, email, dob, id) {
    document.getElementById("Editname").value = name;
    document.getElementById("Editemail").value = email;
    document.getElementById("Editdob").value = dob;
    document.getElementById("save").addEventListener("click", () => {
        Editform = document.getElementById("Edit-form");
        data = new FormData(Editform);
        data.append("id", id);
        const value = Object.fromEntries(data.entries());
        fetch(`${url}/action.php/?id=${id}`, {
            method: "PUT",
            body: JSON.stringify(value),
            headers: {
                "Content-type": "application/json",
            }
        }).then((response) => (response).text()).then((data) => {
            console.log(data);
            getFetchCall();
        });
    });
}

function Delete(id) {
    payload = { "id": id };
    fetch(`${url}/action.php?id=${id}`, {  
        method: "DELETE",
        body: JSON.stringify(payload),
        headers: {
            "Content-type": "application/json",
        }
    }).then((response) => response.text())
      .then((data) => {
          console.log(data);
          getFetchCall();
      });
     
}



function getFetchCall() {
    fetch(`${url}/action.php/`, {
        method: "get",
        headers: {
            "Content-type": "application/json",
        }
    }).then((response) => response.json()).then((data) => {
        let tbody=document.querySelector("#records tbody");
        tbody.innerHTML="";
        id=1;
        page=0;
        for(let row of data)
        {   
            let tr=document.createElement("tr");
            let arr=[
                id++,
                row.name,
                row.email,
                row["d.o.b"],
                row.created_at,
                row.updated_at,
                `<button type='button' class='btn btn-success text-white' data-bs-toggle='modal' data-bs-target='#Edit' onclick='Edit(\"" + "${row.name}" + "\",\"" + "${row.email}" + "\",\"" + "${row["d.o.b"]}" + "\",\"" + ${row.id} + "\")'>Edit</button>`,
                `<button type='button' class='btn btn-danger text-white' onclick='Delete(\"" +${row.id} + "\")'>Delete</button>`
            ];
            for(let col of arr)
            {
                let td=document.createElement("td");
                
                if(typeof col === 'string' && col.includes('<button'))
                {
                    td.innerHTML=col;
                }
                else
                {
                    td.textContent=col; 
                }
                tr.appendChild(td);      
            }
             tbody.appendChild(tr);
    }
    updatePaginationButtons();
  });
 }

function updatePaginationButtons(){
    fetch(`${url}/action.php?type=page`, {
        method: "get",
        headers: {
            "Content-type": "application/json",
        }
    }).then((response) => response.json()).then((data) => {
        entries=data.entries;
        console.log(entries);
    });
}


 
</script>
</html>
