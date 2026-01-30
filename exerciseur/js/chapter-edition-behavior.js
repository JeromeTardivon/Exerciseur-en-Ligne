let buttonTools = document.getElementById('button-tools')
let sideBar = document.getElementById('sidebar')
let showSideBar = false
buttonTools.addEventListener("click", function (){
    if (showSideBar){
        sideBar.style.display = "flex"
    }else{
        sideBar.style.display = "none"
    }
    showSideBar = !showSideBar
})