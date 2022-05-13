const dateCols = Array.from(document.querySelectorAll('.date-col, .date-col-additional'));

window.addEventListener('scroll', e => {
	dateCols?.forEach(column => {
		const top = column.getBoundingClientRect().top;
		const head = column.querySelector('.date-head, .addictional-head');

		if (top < 0) {
			column.style.paddingTop = '60px';
			head.style.position = 'absolute';
			head.style.top = Math.abs(top) + 'px';
		} else {
			column.style.paddingTop = '0px';
			head.style.position = 'relative';
			head.style.top = '0px';
		}
	})
})

const groupSel = document.querySelector('#group-select-journal')

if (groupSel){
	groupSel.addEventListener("change", function(){
		const queryString = window.location.search;
		const urlParams = new URLSearchParams(queryString);
		urlParams.delete('subject');
		urlParams.set('group', $(this).val());
		window.location.search = urlParams.toString()
	})
}

const monthSelect = document.querySelector('#month-select')
monthSelect.addEventListener("change", function(){
	const queryString = window.location.search;
	const urlParams = new URLSearchParams(queryString);
	urlParams.set('month', $(this).val());
	window.location.search = urlParams.toString()
})

// const subjectSelect = document.querySelector('#subject-select')
// subjectSelect.addEventListener("change", function(){
// 	const queryString = window.location.search;
// 	const urlParams = new URLSearchParams(queryString);
// 	urlParams.set('subject', $(this).val());
// 	window.location.search = urlParams.toString()
// })

const saveBtn = document.querySelector(".save-btn")
const cont = document.querySelector(".EJ-container")

function checkScroll()
{
	const elem = document.querySelector('.dates')
	const scrollBarWidth = elem.offsetHeight - elem.clientHeight;
	
	if (elem.scrollWidth > elem.clientWidth)
	{
		elem.style.top = `-${scrollBarWidth}px`
	}
	else {
		elem.style.top = ''
	}
}

const fios = document.querySelectorAll(".stud-count")
let count = fios.length;

const markFieldLayout = () => `
	<div class="add-field__plus">
		<span class="date-row addTaskMark" contenteditable="true">
	</div>`
	
const marksFields = count => {
	let fields = "";
	for(let i = 0; i < count; i++){
		fields += markFieldLayout()
	}
	return fields
}


cont.addEventListener("click", (event) => {
	const target = event.target
	if (target.closest(".add-field__img")) {
		target.parentNode.parentNode.insertAdjacentHTML("beforebegin", `
		<div class="add-fields-col">
			<div class="addTaskHead">
				<div class="addTaskInput__div">
					<select class="selectTask">
						<option>Кр</option>
						<option>Пр</option>
						<option>Пара</option>
						<option>Экз</option>
						<option>Зач</option>
						<option>Срез</option>
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
			$('.addTaskDate').mask('00')
		})
	}
	if (target.closest(".addTaskDelete")) {
		
		const inputsArr = target.closest(".add-fields-col").querySelectorAll(".addTaskMark")
		let marksArr = []
		inputsArr.forEach(input => {
			marksArr.push(input.value)
		})

		const uniqueId = target.closest(".addictional-head")?.querySelector(".addTaskInput__div")?.dataset?.uniqueId;
		const surnamesSpanArr = document.querySelectorAll(".stud-count")
		const surnamesArr = []
		surnamesSpanArr.forEach(surname => {
			surnamesArr.push(surname.innerText)
		})
		if (!uniqueId)
		{
			target.closest(".add-fields-col").remove()
		}
		else {
			$(target.closest(".addTaskDelete")).request('onDeleteAddict', {
				data: {
					unique_id: uniqueId
				}
			})
			target.closest(".add-fields-col").remove()
			const elem = document.querySelector('.dates')
	
			checkScroll(elem)
		}
		
	}
})

const monthName = document.querySelector('.sem-head');
const subject = document.querySelector('.select-subject');
const group = document.querySelector('.select-group');

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

function daysInMonth (month, year) {
  return new Date(year, month, 0).getDate();
}

if (saveBtn) {
	saveBtn.addEventListener('click', (event) => {
		
		//-- marks start
		const inputs = Array.from(document.querySelectorAll('.date-col .date-row[data-changed="true"]'));

		const marksObjectCreate = input => {
			const headerColumn = input.closest('.date-col')?.querySelector('.date-head');
			const mark = input.textContent;
			const date = year + '.' + month + '.' + headerColumn.innerText;
			const numberLesson = headerColumn?.dataset?.numberLesson;
			const fio = fios[$(input).index() - 1]?.textContent;
			
			return {
				mark, 
				date,
				numberLesson,
				fio
			}
		}
		const marks = inputs.map(input => marksObjectCreate(input))
		//-- marks end
		
		//-- additional start
		const additionalInputs = Array.from(document.querySelectorAll('.add-fields-col .date-row[data-changed="true"]'));

		let uniqueId = Date.now();
		
		const marksAdditionalObjectCreate = input => {
			const headerColumn = input.closest('.add-fields-col')?.querySelector('.addTaskInput__div');
			const mark = input.textContent;
			const date = year + '.' + month + '.' + headerColumn.querySelector('input').value;
			const event = headerColumn.querySelector('.selectTask').value;
			const index = $(input).parent().index();
			const fio = fios[index - 1]?.textContent;
			
			if (index - 1 === 0) {
				uniqueId = Date.now();
			}
			const markUniqueId = headerColumn.dataset.uniqueId ?? uniqueId;
			
			return {
				mark, 
				date,
				event,
				fio,
				unique_id: markUniqueId
			}
		}

		const additionalMarks = additionalInputs?.map(input => marksAdditionalObjectCreate(input));
		//-- additional end
		
		//-- validate start
		const additionalDates = Array.from(document.querySelectorAll('.addTaskDate'));
		const marksInputs = Array.from(document.querySelectorAll('.date-row, .addTaskMark'));
		
		const isAdditionalValidate = validationAdditionalsDates(additionalDates);
		const isMarksValidate = validationAllowedMarks(marksInputs);
		// -- validate end

		if (isAdditionalValidate && isMarksValidate) {
			const isAdditionalHaveMarks = validationAdditionalMarks();

			if (isAdditionalHaveMarks) {
				// loader
				const tableBody = document.querySelector('.table-body');
				const tebleLoader = document.querySelector('.table-loader');
				tableBody.classList.add('table-hide');
				tebleLoader.classList.remove('hide');
				saveBtn.classList.add('hide');
				
				$(saveBtn).request('onSaveMarks', {
					data: {
						subject: subject.value,
						group: group.value,
						marks: marks ?? [],
						addictive: additionalMarks,
					}
				})	
			}
		}
	})
}


function validationAdditionalsDates(additionalDates) {
	let errors = 0;
	
	additionalDates.forEach(input => {
		const daysCount = daysInMonth(month, year);
		const day = parseInt(input.value) || '';
		
		if (day > 0 && day <= daysCount && day !== '00') {
			input.classList.remove('validation-field');
		} else {
			input.classList.add('validation-field');
			errors++;
		}
	})
	
	return errors === 0;
}

function validationAllowedMarks(markInputs) {
	let errors = 0;

	const allowedMarks = ['2', '3', '4', '5', 'нб'];

	
	markInputs.forEach(input => {
		const value = input.textContent.trim();
		const isValidate = allowedMarks.includes(value) || value === '';
		
		if (isValidate) {
			input.classList.remove('validation-field');
		} else {
			input.classList.add('validation-field');
			errors++;
		}
	})
	
	return errors === 0;
}

function validationAdditionalMarks() {
	const additionalHeaders = Array.from(document.querySelectorAll('.addTaskHead, .addictional-head'));
	let isEmpty = false;
	
	for (const header of additionalHeaders) {
		const marks = Array.from(header.closest('.add-fields-col').querySelectorAll('.date-row'));
		
		if (marks.reduce((acc, mark) => acc += mark.textContent, '').trim() === '') {
			Swal.fire(
				"Доп. поле не может быть пустым", 
				"Для сохранения дополнительного поля необходимо, чтобы в столбце была хотя бы одна оценка", 
				"error"
			);
			
			return false;
		}
	}
	
	return true;
}


// show SAVE btn
document.addEventListener("DOMContentLoaded", function(){
	const saveBtn = document.querySelector(".save-btn")
	const cont = document.querySelector(".EJ-container")
	
	cont.addEventListener("keyup", (event) => {
		const target = event.target.closest(".date-row");
		const changeDate = event.target.closest('.addTaskInput__div');
		
		if (target) {
			event.target.dataset.changed = true;
		}
		
		if ((target || changeDate) && saveBtn.classList.contains("hide")) {
			saveBtn.classList.remove("hide")
		}
	})
	
	cont.addEventListener("click", (event) => {
		const target = event.target;

		if (target.classList.contains('selectTask') && saveBtn.classList.contains("hide")) {
			target.addEventListener('change', () => {
				saveBtn.classList.remove("hide")
			})
		}
	})
})

// fetch marks
document.addEventListener("DOMContentLoaded", function() {
	const group = document.querySelector('.table-head').dataset.group; 
	// const loader
	const tableBody = document.querySelector('.table-body');
	const tebleLoader = document.querySelector('.table-loader');

	const onGetMarks = $.request('onGetMarks', {
		data: {
			subject: subject.value,
			group: group,
			month: monthSelect.value
		},
		success: function(students) {
			renderMarks(students);
		}
	})
	
	const onGetAdditionalMarks = $.request('onGetAdditionalMarks', {
		data: {
			subject: subject.value,
			group: group,
			month: monthSelect.value,
		},
		success: function(students) {
			renderAdditionalMarks(students);
		}
	})

	Promise.all([onGetMarks, onGetAdditionalMarks]).then(() => {
		setTimeout(checkScroll, 0);
		
		tableBody.classList.remove('table-hide');
		tebleLoader.classList.add('hide');
	})
})

function renderMarks(students) {
	students?.forEach(student => {
		const marks = student.marks;
		const nameIndex = Array.from(fios)?.map(fio => fio.textContent)?.indexOf(student.full_name)
		
		marks?.forEach(mark => {
			let day = mark.date.split('-');
      day = day[day.length-1]
			if (day < 10) {
				day = day.replace('0', '');
			}

			const dateColumnHeader = Array.from(document.querySelectorAll(`.date-head`))
				.find(column => column.textContent.trim() === day && column.dataset.numberLesson == mark.number_lesson);

			if (dateColumnHeader) {
				const markFields = dateColumnHeader.parentNode.querySelectorAll('.date-row');
				markFields[nameIndex].textContent = mark.mark;
			}
		})
	})
}

function renderAdditionalMarks(students) {
	students?.forEach(student => {
		const marks = student.marks;
		const nameIndex = Array.from(fios)?.map(fio => fio.textContent)?.indexOf(student.full_name)
		
		marks?.forEach(mark => {
			const dateColumnHeader = Array.from(document.querySelectorAll(`.addictional-head > div`))
				?.find(column => column.dataset.uniqueId == mark.unique_id);
			
			if (dateColumnHeader) {
				const markFields = dateColumnHeader.closest('.date-col-additional').querySelectorAll('.date-row');
				markFields[nameIndex].textContent = mark.mark;
			}
		})
	})
}

$(document).ready(function() {
	const platform = navigator.platform.toLowerCase();
	
	if (platform.includes('mac')) {
	  const subjectSelect = document.querySelector('#subject-select')
		subjectSelect.addEventListener("change", function(){
			const queryString = window.location.search;
			const urlParams = new URLSearchParams(queryString);
			urlParams.set('subject', $(this).val());
			window.location.search = urlParams.toString()
		})
	} else {
		$('#subject-select').select2();
	  $('#subject-select').on("select2:select", function (e) {
	  	const text = e.params.data.text.trim();
	  	const queryString = window.location.search;
			const urlParams = new URLSearchParams(queryString);
			urlParams.set('subject', text);
			window.location.search = urlParams.toString()
	  })
	}
});