const listButton = document.querySelector('.user-dropdown__btn')
const list = document.querySelector('.user-dropdown__list')
const activeClass = 'user-dropdown__list_active'
const parentBlock = '.user-dropdown'

function showWindow (btn, list, activeClass, parentBlock) {
  btn.addEventListener('click', () => {
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
 
// function addActivity() {
// 	const addActivityBlock = document.querySelectorAll('.schedule-add')
// 	addActivityBlock.forEach(item => {
// 		item.children[0].addEventListener('click', () => {
// 			item.innterHTML = activityForm
			
// 			const cancelBtn = document.querySelector('.schedule-add__cancel-btn')
// 			cancelBtn.addEventListener('click', () => item.innerHTML = activityBtn)
// 		})
// 	})
// }
// addActivity()


let btn1 = document.querySelector("#c_form")
let btn2 = document.querySelector("#itsupp")
let btn3 = document.querySelector("#ahch") 

if(btn1 && btn2 && btn3){
	btn1.addEventListener('click', event => {
	  window.open("https://docs.google.com/forms/d/e/1FAIpQLSexeSMUh9ru30IUdl2YJLfpAkiWdboTzRax1FGITKnOYxtr6A/viewform", '_blank')
	});
	btn2.addEventListener('click', event => {
	  window.open("https://docs.google.com/forms/d/e/1FAIpQLSc08R9sh4c-TKlFEwuVzS7fCxIPgPOBzCFHpAL-CgBkMWBy0g/viewform", '_blank')
	});
	btn3.addEventListener('click', event => {
	  window.open("https://docs.google.com/forms/d/e/1FAIpQLSd6kp_mejDUB3comkotkA1hAGxHOu-T5EcVYScyHGB8u2GUGg/viewform", '_blank')
	});
}

let mod1 = document.querySelector("#mod1");
let mod2 = document.querySelector("#mod2");
let mod3 = document.querySelector("#mod3");
let mod4 = document.querySelector("#mod4");
let mod5 = document.querySelector("#mod5");
let mod6 = document.querySelector("#mod6");
let mod7 = document.querySelector("#mod7");
let mod8 = document.querySelector("#mod8");
let divM1 = document.querySelector("#divM1");
let divM2 = document.querySelector("#divM2");
let divM3 = document.querySelector("#divM3");
let divM4 = document.querySelector("#divM4");
let divM5 = document.querySelector("#divM5");
let divM6 = document.querySelector("#divM6");
let divM7 = document.querySelector("#divM7");
let divM8 = document.querySelector("#divM8");
let saveBtn = document.querySelector("#save-btn")

const massDiv = document.querySelectorAll('.module-div');
const mass = document.querySelectorAll('.modbtn');
mass.forEach(element => element.addEventListener('click', event => {
	mass.forEach(el => el.classList.remove('selected'));
	switch(element.id){
		case 'mod1': {
			mod1.classList.add('selected');
			massDiv.forEach(div => div.classList.remove("shown"));
			divM1.classList.add("shown");
			break;
		}
		case 'mod2': {
			mod2.classList.add('selected');
			massDiv.forEach(div => div.classList.remove("shown"));
			divM2.classList.add("shown");
			break;
		}
		case 'mod3': {
			mod3.classList.add('selected');
			massDiv.forEach(div => div.classList.remove("shown"));
			divM3.classList.add("shown");
			break;
		}
		case 'mod4': {
			mod4.classList.add('selected');
			massDiv.forEach(div => div.classList.remove("shown"));
			divM4.classList.add("shown");
			break;
		}
		case 'mod5': {
			mod5.classList.add('selected');
			massDiv.forEach(div => div.classList.remove("shown"));
			divM5.classList.add("shown");
			break;
		}
		case 'mod6': {
			mod6.classList.add('selected');
			massDiv.forEach(div => div.classList.remove("shown"));
			divM6.classList.add("shown");
			break;
		}
		case 'mod7': {
			mod7.classList.add('selected');
			massDiv.forEach(div => div.classList.remove("shown"));
			divM7.classList.add("shown");
			break;
		}
		case 'mod8': {
			mod8.classList.add('selected');
			massDiv.forEach(div => div.classList.remove("shown"));
			divM8.classList.add("shown");
			break;
		}
	}
}));
