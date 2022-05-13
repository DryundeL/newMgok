const modal = document.querySelector('.modal')

modal.addEventListener("click", event => {
	if((event.target.classList.contains("modal__overlay") || event.target.classList.contains("modal__cancel") || event.target.classList.contains("modal__submit")) && modal.style.display!="none"){
		modal.style.display = "none"
		document.querySelector('#start-time').value = ""
		document.querySelector('#end-time').value = ""
		document.querySelector('#cab-num').value = ""
		document.querySelector('#sub-name').options[0].selected = true
		document.querySelector('#repeat-event').checked = false
	}
})

const addEventBtns = document.querySelectorAll('.add-event-plus')

addEventBtns.forEach(button => {
	button.addEventListener('click', event => {
		modal.style.display = "block"
	})
})

const submitBtn = document.querySelector('.modal__submit')
const cancelBtn = document.querySelector('.modal__cancel')

submitBtn.addEventListener("click", event => {
	event.preventDefault();
})

cancelBtn.addEventListener("click", event => {
	event.preventDefault();
})



