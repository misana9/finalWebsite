const addButton = document.getElementById("addBtn");
const addForm = document.getElementById("addForm");
const updateBtn = document.getElementById("updateBtn");
const updateForm = document.getElementById("updateForm");

if (updateBtn && updateForm) {
  updateBtn.addEventListener("click", () => {
    updateForm.style.display = "none";
  });
}

if (addButton && addForm) {
  addButton.addEventListener("click", () => {
    if(addForm.style.display == "block"){
      addForm.style.display = "none";
    }else{
      addForm.style.display = "block";
    }
    if (updateForm) updateForm.style.display = "none"; // hide edit when adding
  });
}