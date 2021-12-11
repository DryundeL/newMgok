const addTableColumn = (length, target) => {
	target.style.padding = '0'
	target.innerHTML = `
		<div class="table-column__container">
			<span class="table-column__name">Название</span>
			<span class="table-column__max-score">
				<input type="text" />
			</span>
	`
	
	for (i = 1; i <= length; i++) {
		target.innerHTML += `
			<span class="table-column__item">
				<input type="text" />
			</span>
		`
	}
	target.innerHTML += '</div>'
}

const addColumnClick = (id) => {
	const studentsLength = document.querySelectorAll(`${id} .student-name`).length
	const plusBtns = document.querySelectorAll('.plus-th')
	
	plusBtns.forEach(btn => {
		btn.addEventListener('click', event => {
			addTableColumn(studentsLength, event.target)
		})
	})
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
			addColumnClick("#divM1")
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