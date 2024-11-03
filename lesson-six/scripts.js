/*
alert("This is alert message!")
let idx = 0;
for(idx = 0; idx < 10; idx++){
    alert(idx)
}
*/
/*
if(confirm("I like ZWA classes") === true) {
    alert("Correct answer");
} else {
    alert("Incorrect, MVCR is tracking you");
}*/
function myFunction() {
    let inputElement = document.querySelector('#alert-input');
    if (inputElement === null) {
        alert("No input found")
    }
    if (inputElement.value === "") {
        alert("No input provided")
    }
    else {
        alert(inputElement.value)
    }
}