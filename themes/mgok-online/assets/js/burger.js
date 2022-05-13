const headerWrapper = document.querySelector('.header__wrapper')
const burgerMenu = document.querySelector('.burger-menu')


headerWrapper.addEventListener('click', event => {

	if(event.target.closest('.nav-toggle')){
		event.target.closest('.nav-toggle').classList.toggle('opened');
		
		if(event.target.closest('.nav-toggle').classList.contains('opened')){
			burgerMenu.style.transform = "translate(0, 0vh)"
			document.documentElement.style.overflow = "hidden"
		}
		else{
			burgerMenu.style.transform = "translate(0, -200vh)"
			document.documentElement.style.overflow = "auto"
		}
		
		// if(burgerMenu.style.display=="flex") {
		// 	burgerMenu.classList.remove("opened-menu")
		// 	burgerMenu.style.display = "none"
		// }
		// else {
		// 	burgerMenu.style.display = "flex"
		// 	burgerMenu.classList.add("opened-menu")
		// }
	}
	
	if(event.target.classList.contains("menu__arrow") || event.target.classList.contains("user-name__div") || event.target.classList.contains("user-name__span")){
		const userActions = document.querySelector('.menu-class')
		if(userActions.style.display == "block") {
			document.querySelector(".menu__arrow").style.transform = "rotate(0deg)"
			userActions.style.display = "none"
		}
		else {
			document.querySelector(".menu__arrow").style.transform = "rotate(180deg)"
			userActions.style.display = "block"
		}
	}
	
})