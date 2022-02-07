const groupSelect = document.querySelector('#group-select')

if (groupSelect){
	groupSelect.addEventListener("change", function(){
		const queryString = window.location.search;
		const urlParams = new URLSearchParams(queryString);
		urlParams.set('group', $(this).val());
		window.location.search = urlParams.toString()
	})
}
var pickSub = ""
const semestrSelect = document.querySelector('#semester-select')

semestrSelect.addEventListener("change", function(){
	const queryString = window.location.search;
	const urlParams = new URLSearchParams(queryString);
	urlParams.set('semester', $(this).val());
	window.location.search = urlParams.toString()
})

const monthSelect = document.querySelector('#month-select')

monthSelect.addEventListener("change", function(){
	const queryString = window.location.search;
	const urlParams = new URLSearchParams(queryString);
	urlParams.set('month', $(this).val());
	window.location.search = urlParams.toString()
})

new Swiper('.image-slider', {
	freeMode: true, 
	slidesPerView: 4,
});


const table = document.querySelector(".table")

const subjectsBtn = document.querySelectorAll('.slide-text')
const caruselForm = document.querySelector('.carusel-form')

subjectsBtn.forEach(btn => {
	btn.addEventListener("click", (event) => {
		subjectsBtn.forEach(el => {
			el.classList.remove("choosenSub")
		})
		event.target.classList.add("choosenSub")
		pickSub = event.target.innerHTML
		if(table.classList.contains("table-hide")) table.classList.remove("table-hide")

		$(caruselForm).request('onChangeSubject', {
			
			data: {
				subject: event.target.innerText,
				month: monthSelect.value,
			}
		})
		
		const saveBtn = document.querySelector(".save-btn")
		const cont = document.querySelector(".EJ-container")
		
		cont.addEventListener("keyup", (event) => {
			const target = event.target.closest(".date-row__input")
			const addTarget = event.target.closest(".addTaskMark")
			if (target) {
				if(saveBtn.classList.contains("hide")) saveBtn.classList.remove("hide")
			}
			if (addTarget) {
				if(saveBtn.classList.contains("hide")) saveBtn.classList.remove("hide")
			}
		})
	})
})


const fios = document.querySelectorAll(".stud-count")
let count = 0

fios.forEach(el => {
	count++
})

const markFieldLayout = () => `
	<div class="add-field__plus">
		<input class="addTaskMark" type="text">
	</div>`
	
const marksFields = count => {
	let fields = "";
	for(let i = 0; i < count; i++){
		fields += markFieldLayout()
	}
	return fields
}

const cont = document.querySelector(".EJ-container")
cont.addEventListener("click", (event) => {
	const target = event.target
	if (target.closest(".add-field__img")) {
		target.parentNode.parentNode.insertAdjacentHTML("beforebegin", `
		<div class="add-fields-col">
			<div class="addTaskHead">
				<div class="addTaskInput__div">
					<input class="addTaskName" placeholder="Событие" type="text">
					<input class="addTaskDate" placeholder="Число:" type="text">
				</div>
				<div class="plus-img__div">
					<svg class="addTaskDelete" width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M15 6L6 15" stroke="#CACACA" stroke-width="2" stroke-linecap="round"/>
						<path d="M15 15L6 6" stroke="#CACACA" stroke-width="2" stroke-linecap="round"/>
					</svg>
				</div>
			</div>
			${marksFields(count)}
		</div>
		`)
		$(document).ready(function(){
			$('.addTaskDate').mask('AB', {'translation':{
				A: {pattern: /[0-3]/},
				B: {pattern: /[0-9]/}
			}})
		})
		$(document).ready(function(){
			$('.addTaskName').mask('AAAAA', {'translation':{
				A: {pattern: /[А-Яа-я/]/}
			}})
		})
	}
	if (target.closest(".addTaskDelete")) {
		
		const inputsArr = target.closest(".add-fields-col").querySelectorAll(".addTaskMark")
		let marksArr = []
		inputsArr.forEach(input => {
			marksArr.push(input.value)
		})
		const dayMark = target.closest(".add-fields-col").querySelector(".addTaskDate").value
		const name = target.closest(".add-fields-col").querySelector(".addTaskName").value
		const surnamesSpanArr = document.querySelectorAll(".stud-count")
		const surnamesArr = []
		surnamesSpanArr.forEach(surname => {
			surnamesArr.push(surname.innerText)
		})
		if (inputsArr == [] || dayMark == '')
		{
			target.closest(".add-fields-col").remove()
		}
		else {
			$(target.closest(".addTaskDelete")).request('onDeleteAddict', {
				data: {
					date: year + '.' + month + '.' + dayMark,
					name: name,
					marks: marksArr,
					surnames: surnamesArr
				}
			})
		}
		
	}
})



const saveBtn = document.querySelector('#save-btn')
const monthName = document.querySelector('.sem-head')
const group = document.querySelector('.select-group')

let year = new Date().getFullYear();
const months = {
	Январь: 1,
	Февраль: 2,
	Март: 3,
	Апрель: 4,
	Май: 5,
	Июнь: 6,
	Июль: 7,
	Август: 8,
	Сентябрь: 9,
	Октябрь: 10,
	Ноябрь: 11,
	Декабрь: 12,
}

let month = months[`${monthName.innerText}`];

if (month > 8) {
	year--
}

function daysInMonth (month, year) { // Use 1 for January, 2 for February, etc.
  return new Date(year, month, 0).getDate();
}

if (saveBtn) {
	saveBtn.addEventListener('click', (event) => {
		let array = []
		const days = document.querySelectorAll('.date-head') 	
		const subject = document.querySelector('.choosenSub')
		
		const inputs = Array.from(document.querySelectorAll('.date-row__input'))
		const marks = inputs.map(input => ({
			mark: input.value
		}))
		days.forEach(day=> {
			fios.forEach(fio=>{
				let data = {
					date: year + '.' + month + '.' + day.innerText,
					subject: subject.innerText, 
					group: group.value,
					name: fio.innerText,
				}
				array.push(data);
			})
		})

		const finalGradesInputs = Array.from(document.querySelectorAll('.final'))
		const finalGrades = finalGradesInputs.map(input=>({
			month: monthName.innerText,
			mark: input.value
		}))

		const taskNameInputs = document.querySelectorAll('.addTaskName')
		const taskDateInputs = document.querySelectorAll('.addTaskDate')
		const taskMarkInputs = document.querySelectorAll('.addTaskMark')
		let addictiveArray = [];

		taskDateInputs.forEach(input => {
			if(input.value <= daysInMonth(month, year)){
				for (i = 0; i < taskNameInputs.length; i++)
				{
					if (i > 0)
					{
						j = taskMarkInputs.length/taskNameInputs.length
						for (; j < taskMarkInputs.length; j++)
						{
							let addict = {
								name: taskNameInputs[i].value,
								date: year + '.' + month + '.' + taskDateInputs[i].value,
								mark: taskMarkInputs[j].value
							}
							addictiveArray.push(addict)
						}
					}
					else 
					{
						j = 0
						for (; j < taskMarkInputs.length/taskNameInputs.length; j++)
						{
							let addict = {
								name: taskNameInputs[i].value,
								date: year + '.' + month + '.' + taskDateInputs[i].value,
								mark: taskMarkInputs[j].value
							}
							addictiveArray.push(addict)
						}
					}
				}
			if (!saveBtn.classList.contains("hide"))saveBtn.classList.add("hide")
			alert("Данные занесены!")
			}
			else alert("Число введено неверно!")
		})

		
		console.log(addictiveArray)
		$(saveBtn).request('onSaveMarks', {
			data: {
				data: array,
				marks: marks,
				finalGrades: finalGrades,
				addictive: addictiveArray
			}
		})

	})
}
document.addEventListener("DOMContentLoaded", function(){
	const body = document.querySelector("body")
	const subjArr = document.querySelectorAll(".slide-text")
	
	const saveBtn = document.querySelector(".save-btn")
	const cont = document.querySelector(".EJ-container")
	
	cont.addEventListener("keyup", (event) => {
		const target = event.target.closest(".date-row__input")
		const addTarget = event.target.closest(".addTaskMark")
		if (target) {
			if(saveBtn.classList.contains("hide")) saveBtn.classList.remove("hide")
		}
		if (addTarget) {
			if(saveBtn.classList.contains("hide")) saveBtn.classList.remove("hide")
		}
	})
	
	
	subjArr[0].classList.add("choosenSub")
	pickSub = subjArr[0].innerHTML
	$(body).request('onLoadPage', {
		data: {
			month: monthSelect.value,
			subject: pickSub
		}
	})
})


