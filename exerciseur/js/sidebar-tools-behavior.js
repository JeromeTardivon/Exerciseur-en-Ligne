let buttonTools = document.getElementById('button-tools')
let sideBar = document.getElementById('sidebar')
let columnSidebar = document.getElementsByClassName('columnSideBar')
let showSideBar = true
buttonTools.addEventListener("click", function (){
    if (showSideBar){
        sideBar.style.display = "flex"
        columnSidebar.item(0).style.width = '30%'
    }else{
        sideBar.style.display = "none"
        columnSidebar.item(0).style.width = '2%'
    }
    showSideBar = !showSideBar
})