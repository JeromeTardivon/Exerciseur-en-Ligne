document.getElementById('labelTeacherCode').style.visibility = "hidden";
document.getElementById('teacherCode').style.visibility = "hidden";
let radios = document.querySelectorAll("input[name=\"status\"]");

// Use Array.forEach to add an event listener to each radio element.
radios.forEach(function (radio) {
    radio.addEventListener('change', function () {
        let valueName = document.querySelector('input[name="status"]:checked').value;
        if (valueName === "teacher") {
            document.getElementById('labelTeacherCode').style.visibility = "visible";
            document.getElementById('teacherCode').style.visibility = "visible";
        } else {
            document.getElementById('labelTeacherCode').style.visibility = "hidden";
            document.getElementById('teacherCode').style.visibility = "hidden";
        }
    })
});
