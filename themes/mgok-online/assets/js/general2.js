const listButton = document.querySelector('.user-dropdown__btn')
const list = document.querySelector('.user-dropdown__list')
const activeClass = 'user-dropdown__list_active'
const parentBlock = '.user-dropdown'

function showWindow (btn, list, activeClass, parentBlock) {
  btn?.addEventListener('click', () => {
    list.classList.toggle(activeClass)
    
    window.addEventListener('click', event => {
    	// console.log(event.target.closest(parentBlock));
      if (!event.target.closest(parentBlock)) list.classList.remove(activeClass)
    })
  })
}

// showWindow(listButton, list, activeClass, parentBlock)

 if (document.body.clientWidth > 768) showWindow(listButton, list, activeClass, parentBlock)
 
const activityForm = `
	<form class="schedule-add__form">
		<div class="schedule-add__item">
			<span></span>
			<input type="text">
		</div>
		<div class="schedule-add__item">
			<span></span>
			<input type="text">
		</div>
		<div class="schedule-add__item">
			<span></span>
			<input type="text">
		</div>
		<div class="schedule-add__item">
			<span></span>
			<input type="text">
		</div>
		<div class="schedule-add__item">
			<span></span>
			<input type="text">
		</div>
		<div class="schedule-add__btns">
			<button class="schedule-add__cancel-btn">Отмена</button>
			<button class="schedule-add__add-btn">Добавить</button>
		</div>
	</form>
`
const activityBtn = `
	<div class="schedule-add__add">
		<img src="{{ 'assets/icons/plus.svg'|theme }}" alt="">
		<span>Добавить активность</span>
	</div>
`
 
function addActivity() {
	const addActivityBlock = document.querySelectorAll('.schedule-add')
	addActivityBlock.forEach(item => {
		item.children[0].addEventListener('click', () => {
			item.innterHTML = activityForm
			
			const cancelBtn = document.querySelector('.schedule-add__cancel-btn')
			cancelBtn.addEventListener('click', () => item.innerHTML = activityBtn)
		})
	})
}
addActivity()


let btn1 = document.querySelector("#techsup_form")

if(btn1){
	btn1.addEventListener('click', event => {
	  window.open("https://t.me/+du9x1pE7Tk45YjBi", '_blank')
	});
}

function updateTextInput(val, val2) {
          document.getElementById('timeFrom').value=val + ":" + val2; 
}

let addEventButton = document.querySelector("#add-event-button");
let inputPlace = document.querySelector("#event-input-place");
let timeFrom = document.querySelector("#timeFrom");
let timeTo = document.querySelector("#timeTo");
let alertMess = document.querySelector("#alert");

let pluses = document.querySelectorAll(".event-plus__div")
let schedule = document.querySelector(".schedule")
let addEventDiv = document.querySelectorAll("#add-event-div")

let add1 = document.querySelector("#add1")
let add2 = document.querySelector("#add2")
let add3 = document.querySelector("#add3")
let add4 = document.querySelector("#add4")
let add5 = document.querySelector("#add5")
let add6 = document.querySelector("#add6")
let add7 = document.querySelector("#add7")

schedule?.addEventListener('click', event => {
	const target = event.target
	
	if (target.closest('.schedule__element-li')) {
		const form = target.closest('.schedule__lessons-list').lastElementChild
		const addBtn = form.querySelector('#add-event-button')
		
		pluses.forEach(plus => {
			plus.parentNode.style.display = 'none'
		})
		form.style.display = "flex"
		
		cancelBtnOnClick()
		validationFields(form, addBtn)
	}
})



pluses.forEach(item => {
	item.addEventListener('click', event => {
		item.parentNode.lastElementChild.style.display = "flex"
		pluses.forEach(part => {
			part.style.display = "none"
		})
	})
})

function cancelBtnOnClick() {
	const cancelAddEvent = document.querySelectorAll("#cancel-add-event")
	
	cancelAddEvent.forEach(item => {
		item.addEventListener('click', event => {
			pluses.forEach(plus => {
				plus.parentNode.style.display = "flex"
			})
			addEventDiv.forEach(part =>{
				part.style.display = "none"
			})
		})
	})
}







// -----------------------------













































