let timeLimitSection = document.getElementById("timelimit-box");
timeLimitSection.style.display = "none";
document.getElementById("timelimit").addEventListener('click', function() {
    if (this.checked){
        timeLimitSection.style.display = "block";
    }else{
        timeLimitSection.style.display = "none";
    }
})

let gradeOptions = document.getElementById("grade-options");
gradeOptions.style.display = "none";
document.getElementById("class-select").addEventListener('change', function (){
    if (this.value !== "unspecified"){
        gradeOptions.style.display = "block";
    }else{
        gradeOptions.style.display = "none";
    }
})

let coefficientBox = document.getElementById("coefficient-box");
coefficientBox.style.display = "none";
document.getElementById("graded").addEventListener('click', function() {
    if (this.checked){
        coefficientBox.style.display = "block";
    }else{
        coefficientBox.style.display = "none";
    }
})

let limitTryOptions = document.getElementById("limit-try-options");
limitTryOptions.style.display = "none";
document.getElementById("limittry").addEventListener('click', function() {
    if (this.checked){
        limitTryOptions.style.display = "block";
    }else{
        limitTryOptions.style.display = "none";
    }
})