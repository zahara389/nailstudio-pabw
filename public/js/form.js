const jobForm = document.getElementById("job-form");
const successMessage = document.getElementById("success-message");
const fileInput = document.getElementById("cv");
const fileNameDisplay = document.getElementById("file-name");

fileInput.addEventListener("change", function() {
  const file = this.files[0];
  if(file) {
    fileNameDisplay.textContent = "File terpilih: " + file.name;
  } else {
    fileNameDisplay.textContent = "Pilih file CV (PDF, DOC, DOCX)";
  }
});

jobForm.addEventListener("submit", function(e){
  e.preventDefault();
  jobForm.style.display = "none";
  successMessage.classList.remove("hidden");

  setTimeout(() => {
    successMessage.classList.add("hidden");
    jobForm.reset();
    fileNameDisplay.textContent = "Pilih file CV (PDF, DOC, DOCX)";
    jobForm.style.display = "block";
  }, 3000);
});
